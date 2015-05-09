<?php

/**
 * {module_name} actions.
 *
 * @package    IWP
 * @subpackage errors
 * @author     Vasiliy.Razumov[1248783@gmail.com]
 * @version    $Id: controller 432 2015-04-30 17:22:58Z Vasiliy.Razumov $
 */
class ErrorsController extends BaseController {

    public function initialize() {
        $this->setTitle('Oops!');
        parent::initialize();
    }

    public function show404Action() {
        
    }

    public function show401Action() {
        
    }

    public function show500Action($exception = array('debug' => false)) {
            $this->view->exception = $exception;
    }

}
