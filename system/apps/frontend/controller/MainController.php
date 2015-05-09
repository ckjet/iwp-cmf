<?php

/**
 * main actions.
 *
 * @package    IWP
 * @subpackage main
 * @author     Vasiliy.Razumov[1248783@gmail.com]
 * @version    $Id: controller 432 2015-04-30 17:22:58Z Vasiliy.Razumov $
 */
class MainController extends BaseController {
    
    /**
     * Executes index action
     *
     */
    public function indexAction() {
        $this->tag->setTitle('Module main created');
    }
}