<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;

class iwp_exception {

    protected $error;

    public function __construct($exception, $parent) {
        $this->error = array(
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
            'debug' => $parent->debug
        );
        $this->init_di($parent);
        $dispatcher = $this->di['dispatcher'];
        $view = $this->di['view'];
        $dispatcher->setControllerName($parent->config['app']->errors->error500->controller);
        $dispatcher->setActionName($parent->config['app']->errors->error500->action);
        $dispatcher->setParams(array('exception' => $this->error));
        $view->start();
        $dispatcher->dispatch();
        $view->render(
                $dispatcher->getControllerName(), $dispatcher->getActionName(), $dispatcher->getParams()
        );
        $view->finish();
        $response = $this->di['response'];
        $response->setContent($view->getContent());
        $response->sendHeaders();
        echo $response->getContent();
        exit();
    }

    protected function init_di($parent) {
        $this->di = new Phalcon\DI\FactoryDefault();
        $this->di->set('view', function() use ($parent) {
            $view = new View();
            $view->setViewsDir($parent->root . '/system/apps/' . $parent->application . $parent->config['app']->path->views);
            $view->registerEngines(array(
                ".volt" => 'volt'
            ));
            return $view;
        });
        /**
         * Setting up volt
         */
        $this->di->set('volt', function($view, $di) use ($parent) {
            $volt = new VoltEngine($view, $di);
            if (!is_dir($parent->root . '/system/cache/' . $parent->application)) {
                mkdir($parent->root . '/system/cache/' . $parent->application);
            }
            $volt->setOptions(array(
                "compiledPath" => $parent->root . '/system/cache/' . $parent->application . '/'
            ));
            $compiler = $volt->getCompiler();
            $compiler->addFunction('sizeof', 'sizeof');
            $compiler->addFunction('print_r', 'print_r');
            $compiler->addFunction('gen_url', function($data) use($parent) {
                $data = array_map(function($input) {
                    return trim(str_replace('\'', '', $input));
                }, explode(',', $data));
                $url = '/' . implode('/', $data) . $parent->config['app']->path->suffix;
                return '\'' . $url . '\'';
            });
            $compiler->addFunction('is_a', 'is_a');
            return $volt;
        }, true);
    }

}
