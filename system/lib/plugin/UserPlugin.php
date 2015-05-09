<?php

use Phalcon\Mvc\User\Plugin;

/**
 * Plugin for working with user session
 */
class UserPlugin extends Plugin {

    public function __construct($session) {
        $this->session = $session;
    }

    /**
     * function for get current user id
     * @return user id or false if not set
     */
    public function getId() {
        if($this->session->has('id')) {
            return $this->session->get('id');
        }
        return false;
    }

    /**
     * function for set current user id
     * @param integer $id current id
     */
    public function setId($id) {
        $this->session->set('id', $id);
    }

    /**
     * function for get var from current user session
     * @param string $var name of var to get from current user session
     * @return value or false if not set
     */
    public function getVar($var) {
        if($this->session->has($var)) {
            return $this->session->get($var);
        }
        return false;
    }
    
    /**
     * function for set var in to current user session
     * @param string $var name of var to set in to current user session
     * @param string $value value of $var to set in to current user session
     */
    public function setVar($var, $value) {
        $this->session->set($var, $value);
    }

    /**
     * function for destroy current user session
     */
    public function logout() {
        $this->session->destroy();
    }

}
