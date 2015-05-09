<?php

/**
 * {module_name} actions.
 *
 * @package    IWP
 * @subpackage index
 * @author     Vasiliy.Razumov[1248783@gmail.com]
 * @version    $Id: controller 432 2015-04-30 17:22:58Z Vasiliy.Razumov $
 */
class IndexController extends BaseController {

    public function initialize() {
        parent::initialize();
        $this->setTitle('Manage your companies');
        if (!$this->getUser()->getId()) {
            return $this->response->redirect('/user/logon.adm');
        }
    }

    public function indexAction() {
        $view = $this->view;
        $view->data = array(
            'php', 'apache', 'sql', 'sf 1.4'
        );
    }

    public function defAction() {
        
    }

}
