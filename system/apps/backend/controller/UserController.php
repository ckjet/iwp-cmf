<?php

/**
 * {module_name} actions.
 *
 * @package    IWP
 * @subpackage user
 * @author     Vasiliy.Razumov[1248783@gmail.com]
 * @version    $Id: controller 432 2015-04-30 17:22:58Z Vasiliy.Razumov $
 */

class UserController extends BaseController {

    public function initialize() {
        if ($this->dispatcher->getActionName() != 'logon') {
            $this->setTitle('Управление доступами');
        }
        parent::initialize();
        if (!$this->getUser()->getId() && $this->dispatcher->getActionName() !== 'logon') {
            return $this->response->redirect('/user/logon.adm');
        }
    }

    public function indexAction() {
        $vars = array();
        $query_string = $this->request->getQuery();
        foreach ($query_string as $k => $v) {
            if ($k != 'page' && $k != '_url') {
                $vars[$k] = $v;
            }
        }
        $this->view->pager_query = sizeof($vars) ? '&' . http_build_query($vars) : '';
        $page = (int) $this->request->getQuery('page', 'int');
        $admin = new IwpAdministrator();
        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder(array(
            'builder' => $admin->getList(),
            'limit' => 10,
            'page' => $page
        ));
        $this->view->pager = new PagerPlugin($paginator->getPaginate(), 10);
    }

    public function editAction() {
        $id = (int) $this->request->getQuery('_id');
        $this->view->item = IwpAdministrator::findFirst($id);
        $this->view->bc_title = 'Новый доступ';
        if ($this->view->item->id) {
            $this->view->bc_title = 'Редактирование доступа <b>' . $this->view->item->login . '</b>';
        } else {
            $empty = new stdClass();
            $empty->id = '';
            $empty->login = '';
            $empty->email = '';
            $empty->level = '';
            $this->view->item = $empty;
        }
    }
    
    public function saveAction() {
        $item_id = (int) trim($this->request->getPost('item_id'));
        $login = trim($this->request->getPost('login'));
        $password = trim($this->request->getPost('password'));
        $email = trim($this->request->getPost('email'));
        $level = (int) trim($this->request->getPost('level'));
        if(!$item = IwpAdministrator::findFirst($item_id)) {
            $item = new IwpAdministrator();
        }
        $item->login = $login;
        $item->email = $email;
        $item->level = $level;
        if($password) {
            $item->password = md5($password);
        }
        $item->save();
        return $this->response->redirect('/user.adm');
    }
    
    public function rmAction() {
        $item_id = (int) trim($this->request->getQuery('_id'));
        if($item = IwpAdministrator::findFirst($item_id)) {
            $item->delete();
        }
        return $this->response->redirect('/user.adm');
    }

    public function logonAction() {
        if ($this->request->isAjax() == true) {
            $this->response->setHeader('Content-type', 'application/json; charset=utf8');
            $data['success'] = false;
            $login = trim($this->request->getPost('login'));
            $password = trim($this->request->getPost('password'));
            $admin = new IwpAdministrator();
            if (!$login) {
                $data['error'] = 'Не введен логин';
            } elseif (!$password) {
                $data['error'] = 'Не введен пароль';
            } elseif (!$user = $admin->getAuth($login, $password)) {
                $data['error'] = 'Логин или пароль введены не верно';
            } else {
                $data['success'] = true;
                array_walk($user, function($value, $key) {
                    $this->getUser()->setVar($key, $value);
                });
                $data['url'] = '/index.adm';
            }
            $this->response->setContent(json_encode($data));
            return $this->response;
        } else {
            $this->setTitle('Авторизация в системе');
        }
    }

    public function logoutAction() {
        $this->getUser()->logout();
        return $this->response->redirect('/user/logon.adm');
    }

}
