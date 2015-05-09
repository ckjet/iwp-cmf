<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatcherException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
 */
class NotFoundPlugin extends Plugin {

    
    public function __construct($parent) {
        $this->parent = $parent;
    }

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeException(Event $event, MvcDispatcher $dispatcher, Exception $exception) {
        if ($exception instanceof DispatcherException) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                    $dispatcher->forward(array(
                        'controller' => 'errors',
                        'action' => 'show404'
                    ));
                    return false;
            }
        }
        include $this->parent->root . '/system/lib/autoload/exception.php';
        new iwp_exception($exception, $this->parent);
        $error = array(
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        );
        $dispatcher->forward(array(
            'controller' => 'errors',
            'action' => 'show500',
            'params' => (IWP_DEBUG ? $error : array())
        ));
        return false;
    }

}
