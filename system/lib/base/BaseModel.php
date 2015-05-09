<?php

use Phalcon\Mvc\Model;

class BaseModel extends Model {
    
    public $pdo;

    public function initialize() {
        $this->pdo = $this->getDi()->getShared('db');
    }

    public function getSource() {
        $tbl_name = preg_replace_callback('#[A-Z]#', function($val) {
            return '_' . strtolower($val[0]);
        }, lcfirst(get_class($this)));
        return $tbl_name;
    }

}
