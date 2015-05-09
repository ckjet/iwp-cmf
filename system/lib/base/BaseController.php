<?php

use Phalcon\Mvc\Controller;

class BaseController extends Controller {

    protected function initialize() {
        $util = new UtilPlugin();
        $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_ACTION_VIEW);
        $this->user = new Phalcon\Session\Bag('backend');
        $this->view->iwp_user = $this->user;
        $this->view->iwp_server = $util->getServerInfo();
        $this->view->iwp_controller = $this->dispatcher->getControllerName();
        $this->view->iwp_action = $this->dispatcher->getActionName();
    }

    protected function setTitle($title) {
        $this->tag->setTitle($title);
        $this->tag->prependTitle('IWP :: ');
    }

    protected function getUser() {
        return new UserPlugin($this->user);
    }

    protected function forward($uri) {
        $uriParts = explode('/', $uri);
        $params = array_slice($uriParts, 2);
        return $this->dispatcher->forward(array(
                    'controller' => $uriParts[0],
                    'action' => $uriParts[1],
                    'params' => $params
        ));
    }

}
