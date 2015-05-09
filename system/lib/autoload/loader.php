<?php

use Phalcon\Mvc\View;
use Phalcon\DI\FactoryDefault;
use Phalcon\Loader as Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaData;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Flash\Session as FlashSession;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Config\Adapter\Yaml as Yaml;
use Phalcon\Mvc\Router;

/**
 * Class iwp_autoload
 *
 * @package    IWP
 * @subpackage application
 * @author     Vasiliy.Razumov
 * @version    $Id: controller 1 2015-04-30 17:22:58Z Vasiliy.Razumov $
 */
class iwp_autoload {

    /**
     *
     * @var string Application name
     */
    public $application;

    /**
     *
     * @var string Debug setting
     */
    public $debug;

    /**
     *
     * @var boolean Configuration
     */
    public $config;

    /**
     *
     * @var string Loader
     */
    protected $loader;

    /**
     *
     * @var string Root dir
     */
    public $root;

    /**
     *
     * @var object Factory
     */
    protected $di;

    /**
     *
     * @var string Version
     */
    protected $version = '1.3.8';

    /**
     * 
     * @param string $application Application name
     * @param bool $debug Debug setting
     */
    public function __construct($application, $debug) {
        $this->root = realpath('..');
        $this->application = $application;
        $this->debug = $debug;
        $this->error_reporting();
        $this->config['db'] = new Yaml($this->root . '/system/config/databases.yml');
        $this->config['app'] = new Yaml($this->root . '/system/apps/' . $this->application . '/config/config.yml');
        $this->config['cache'] = new Yaml($this->root . '/system/apps/' . $this->application . '/config/cache.yml');
        $this->config['router'] = new Yaml($this->root . '/system/apps/' . $this->application . '/config/routing.yml');
        $this->config['router'] = array_reverse($this->config['router']->toArray());
        $this->init_loader();
        $this->init_app();
    }

    protected function error_reporting() {
        error_reporting($this->debug ? E_ALL : 0);
    }

    protected function init_loader() {
        $this->loader = new Loader();
        $this->loader->registerDirs(array(
            $this->root . '/system/apps/' . $this->application . $this->config['app']->path->controllers,
            $this->root . '/system/apps/' . $this->application . $this->config['app']->path->models,
            $this->root . '/system/lib/plugin',
            $this->root . '/system/lib/base'
        ))->register();
    }

    protected function init_app() {
        try {
            $this->init_di();
            $application = new Application($this->di);
            echo $application->handle()->getContent();
        } catch (Exception $e) {
            include $this->root . '/system/lib/autoload/exception.php';
            new iwp_exception($e, $this);
        }
    }

    protected function set_constant() {
        define('IWP_DEBUG', $this->debug);
    }

    protected function init_di() {
        $this->di = new FactoryDefault();
        $this->init_di_dispatcher();
        $this->init_di_router();
        $this->init_di_db();
        $this->init_di_db_cache();
        $this->init_di_url();
        $this->init_di_view();
        $this->init_di_model_metadata();
        $this->init_di_session();
        $this->init_di_flash();
        $this->init_di_elements();
    }

    protected function init_di_dispatcher() {
        $this->di->set('dispatcher', function() {
            $eventsManager = new EventsManager;
            $di = $this->di;
            /**
             * Handle exceptions and not-found exceptions using NotFoundPlugin
             */
            $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin($this));
            $dispatcher = new Dispatcher;
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        });
    }

    protected function init_di_url() {
        $this->di->set('url', function() {
            $url = new UrlProvider();
            $url->setBaseUri($this->config['app']->path->baseUri);
            return $url;
        });
    }

    protected function init_di_view() {
        $this->di->set('view', function() {
            $view = new View();
            $view->setViewsDir($this->root . '/system/apps/' . $this->application . $this->config['app']->path->views);
            $view->registerEngines(array(
                ".volt" => 'volt'
            ));
            return $view;
        });
        $this->di->set('volt', function($view, $di) {
            $volt = new VoltEngine($view, $di);
            if (!is_dir($this->root . '/system/cache/' . $this->application)) {
                mkdir($this->root . '/system/cache/' . $this->application);
            }
            $volt->setOptions(array(
                "compiledPath" => $this->root . '/system/cache/' . $this->application . '/'
            ));
            $compiler = $volt->getCompiler();
            $compiler->addFunction('sizeof', 'sizeof');
            $compiler->addFunction('print_r', 'print_r');
            $compiler->addFunction('gen_url', function($data) {
                $data = array_map(function($input) {
                    return trim(str_replace('\'', '', $input));
                }, explode(',', $data));
                $url = '/' . implode('/', $data) . $this->config['app']->path->suffix;
                return '\'' . $url . '\'';
            });
            $compiler->addFunction('is_a', 'is_a');
            return $volt;
        }, true);
    }

    protected function init_di_router() {
        $this->di->set('router', function() {
            $router = new Router(false);
            array_walk($this->config['router'], function($routeDefinition, $routeName) use($router) {
                if (!array_key_exists('pattern', $routeDefinition)) {
                    throw new RuntimeException("Bad route definition, key 'pattern' is missing for route named '{$routeName}'");
                }
                if (!isset($routeDefinition['param'])) {
                    $routeDefinition['param'] = array();
                }
                $router->add($routeDefinition['pattern'], $routeDefinition['param'])->setName($routeName);
            });
            $router->notFound($this->config['app']->errors->error404->toArray());
            return $router;
        }, true);
    }

    protected function init_di_db() {
        $this->di->set('db', function() {
            $dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $this->config['db']->param->adapter;
            return new $dbclass(array(
                "host" => $this->config['db']->param->host,
                "username" => $this->config['db']->param->username,
                "password" => $this->config['db']->param->password,
                "dbname" => $this->config['db']->param->name,
                "options" => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                )
            ));
        });
    }

    protected function init_di_db_cache() {
        $this->di->set('modelsCache', function() {
            $frontCache = new \Phalcon\Cache\Frontend\Data(array(
                "lifetime" => $this->config['cache']->lifetime->orm
            ));
            $cache = new \Phalcon\Cache\Backend\Memcache($frontCache, array(
                "host" => "localhost",
                "port" => "11211"
            ));
            return $cache;
        });
    }

    protected function init_di_model_metadata() {
        $this->di->set('modelsMetadata', function() {
            return new MetaData();
        });
    }

    protected function init_di_session() {
        $this->di->set('session', function() {
            $session = new SessionAdapter();
            $session->start();
            return $session;
        });
    }

    protected function init_di_flash() {
        $this->di->set('flash', function() {
            return new FlashSession(array(
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
            ));
        });
    }

    protected function init_di_elements() {
        $this->di->set('elements', function() {
            return new Elements();
        });
    }

}
