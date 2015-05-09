<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\Config\Adapter\Yaml as Yaml;
use Phalcon\CLI\Console as ConsoleApp;

class iwp_cli_autoload {

    protected $di;
    protected $config;
    protected $root;
    protected $arguments;
    protected $version = '1.2.0';

    public function __construct($argv) {
        $this->root = realpath('.');
        $this->config['db'] = new Yaml($this->root . '/system/config/databases.yml');
        $this->argv = $argv;
        $this->autoload();
        $this->init_di();
        $this->init_arguments();
        $this->init_app();
        return $this;
    }

    public function init_app() {
        $console = new ConsoleApp();
        $console->setDI($this->di);
        try {
            $console->handle($this->arguments);
        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage() . "\n";
            exit(255);
        }
    }

    public function autoload() {
        $loader = new \Phalcon\Loader();
        $loader->registerDirs(array(
            $this->root . '/system/lib/cli/task',
            $this->root . '/system/lib/task',
            $this->root . '/system/lib/base'
        ));
        $loader->register();
    }

    public function init_di() {
        $this->di = new CliDI();
        $this->init_di_db();
        return $this->di;
    }

    public function init_di_db() {
        $this->di->set('db', function() {
            $dbclass = 'Phalcon\Db\Adapter\Pdo\\' . $this->config['db']->param->adapter;
            return new $dbclass(array(
                "host" => $this->config['db']->param->host,
                "username" => $this->config['db']->param->username,
                "password" => $this->config['db']->param->password,
                "dbname" => $this->config['db']->param->name
            ));
        });
        return $this->di;
    }

    protected function init_arguments() {
        $this->arguments = array(
            'task' => 'help',
            'action' => 'main'
        );
        $params = array();
        foreach ($this->argv as $k => $arg) {
            if ($k == 1) {
                if ($arg == '-v') {
                    $this->arguments = array(
                        'task' => 'help',
                        'action' => 'version',
                        'params' => array("IWP cli ver. " . $this->version . "\n")
                    );
                    break;
                } elseif ($arg == '-h') {
                    break;
                }
                $row = explode(':', $arg);
                $this->arguments['task'] = isset($row[0]) ? $row[0] : 'help';
                $this->arguments['action'] = isset($row[1]) ? $row[1] : 'main';
            } elseif ($k >= 2) {
                $params[$k] = $arg;
            }
        }
        if ($this->arguments['task'] != 'help') {
            $this->arguments['params'] = array();
            if (count($params) > 0) {
                foreach ($params as $v) {
                    $this->arguments['params'][] = $v;
                }
            }
        }
        return $this->arguments;
    }

}
