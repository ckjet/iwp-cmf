<?php

class IwpAdministrator extends BaseModel {

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $level;

    public function getAuth($login, $password) {
        $query = $this->modelsManager->createBuilder()
                ->from('IwpAdministrator')
                ->columns(array('id', 'login', 'email', 'level'))
                ->where('login = :login: AND password = :password:', array('login' => $login, 'password' => md5($password)));
        $results = $query->getQuery()->execute();
        return $results->getFirst();
    }
    
    public function getList() {
        $query = $this->modelsManager->createBuilder()
                ->from('IwpAdministrator')
                ->columns(array('id', 'login', 'email', 'level'))
                ->orderBy('id DESC');
        return $query;
    }

}
