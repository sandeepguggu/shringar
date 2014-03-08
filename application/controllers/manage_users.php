<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class manage_users extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('form_validation');
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            log_message('debug', 'Log in problem ');
            redirect('login?error_msg=' . urlencode("Please Login"));
        }
        $this->ajax = false;
        $this->json = false;
        if ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) || isset($_REQUEST['tabs']) && $_REQUEST['tabs'] == 1) {
            $this->ajax = true;
        }
        if (isset($_REQUEST['json']) && $_REQUEST['json'] == 1) {
            $this->json = true;
        }
        $this->load->model('manage_users_model', 'manage_users');
    }

    public function index()
    {
        $params = array('output' => print_r($_SESSION, true));
        $this->user();
        //log_message('error', 'this log');
        //$this->_my_output('index', $params);

        //$this->menuItem['mainMenu'] = array();
        //$this->menuItem['subMenu'] = array();
        //$menuData = $this->getTabs(0,0);
        //echo "<pre>";
        //print_r($menuData);
    }

    public function user()
    {
        $this->load->library('datagrid', array('db' => &$this->db));

        $fields = array("ID" => "u.id as id", "Username" => "u.username as username", "Name" => "u.name as name", "Phone" => "u.phone as phone", "Group" => "grp.title as grp");
        $table = " `users` u, `user_group` ugrp, `group` grp";
        $where = " where u.deleted = 0 and u.id = ugrp.user_id and ugrp.group_id = grp.id";
        $actions = array(
            "<i class='icon-pencil icon-white'></i>" => array("url" => site_url('manage_users/editUser?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            "<i class='icon-trash icon-white'></i>" => array("url" => site_url('manage_users/deleteUser?ajax=1'), "css" => "btn btn-danger fancybox action-btn")
        );
        $orderby = " order by u.id DESC";
        $p = array();
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $p['tab'] = 'manage_users';
        $this->_my_output('user', $p);
    }

    public function deleteUser()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['error'] = true;
            $p['msg'] = "Missing Id";
            $this->_my_output('message', $p);
            return;
        }

        $r = $this->manage_users->deleteUser($id);
        if ($r['status'] == false) {
            $p['error'] = true;
            $p['msg'] = "User not available";
            $this->_my_output('message', $p);
            return;
        }
        $p['error'] = false;
        $p['msg'] = "User is successfully deleted";
        $this->_my_output('message', $p);
    }

    public function createUser()
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|xss_clean|min_length[10]|max_length[12]');
        $this->form_validation->set_rules('username', 'Username', 'required|xss_clean|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('groups', 'Groups', 'required|is_natural');
        $this->data['message'] = '';
        if ($this->form_validation->run() == true) {
            $firstName = $this->input->post('first_name');
            $lastName = $this->input->post('last_name');
            $phone = $this->input->post('phone');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $group = $this->input->post('groups');
            $p = array();
            if ($this->manage_users->checkUsername($username)) {
                $p['status'] = 'error';
                $p['msg'] = "Username is already exists";
                echo json_encode($p);
                return;
            } else {
                $curUserId = $_SESSION['user']['id'];
                $res = $this->manage_users->createUser($username, $password, $firstName, $lastName, $phone, $curUserId);
                if ($res['status'] == true) {
                    $insertedUserId = $res['userId'];
                    $this->manage_users->insertUserToGroup($group, $insertedUserId);
                    $p['status'] = 'success';
                    $p['msg'] = "User is created successfully";
                    echo json_encode($p);
                    return;
                } else {
                    $this->data['message'] = '<p>' . $res['msg'] . '</p>';
                    $p['status'] = 'error';
                    $p['msg'] = $res['msg'];
                    echo json_encode($p);
                    return;
                }
            }
        }
        $this->data['message'] .= validation_errors();

        $this->data['first_name'] = array('name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name'),
        );
        $this->data['last_name'] = array('name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name'),
        );
        $this->data['phone'] = array('name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone'),
        );
        $this->data['username'] = array('name' => 'username',
            'id' => 'username',
            'type' => 'text',
            'value' => $this->form_validation->set_value('username'),
        );
        $this->data['password'] = array('name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'value' => '',
        );
        $this->data['password_confirm'] = array('name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password',
            'value' => '',
        );
        $this->data['groups'] = $this->manage_users->getGroup(TRUE);
        $this->_my_output('create_user', $this->data);
    }

    public function group()
    {
        $this->load->library('datagrid', array('db' => &$this->db));

        $fields = array("ID" => "id", "Title" => "title", "Identifier" => "identifier", "Description" => "description");
        $table = "`group`";
        $where = " where deleted = 0";
        $actions = array(
            "<i class='icon-cog icon-white'></i>" => array("url" => site_url('manage_users/changeGroupPermission?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            "<i class='icon-pencil icon-white'></i>" => array("url" => site_url('manage_users/editGroup?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            "<i class='icon-trash icon-white'></i>" => array("url" => site_url('manage_users/deleteGroup?ajax=1'), "css" => "btn btn-danger fancybox action-btn")
        );
        $orderby = " order by id DESC";
        $p = array();
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $p['tab'] = 'manage_access_groups';
        $this->_my_output('group', $p);
    }

    public function editUser()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['status'] = 'error';
            $p['msg'] = 'Missing Id';
            echo json_encode($p);
            return;
        }
        $userId = $id;
        $this->form_validation->set_rules('first_name', 'First Name', 'required|xss_clean');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|xss_clean');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required|xss_clean|min_length[10]|max_length[12]');
        $this->form_validation->set_rules('groups', 'Groups', 'required|is_natural');
        $this->data['message'] = '';
        if ($this->form_validation->run() == true) {
            $firstName = $this->input->post('first_name');
            $lastName = $this->input->post('last_name');
            $phone = $this->input->post('phone');
            $group = $this->input->post('groups');
            $curUserId = $_SESSION['user']['id'];
            $res = $this->manage_users->updateUser($userId, $firstName, $lastName, $phone, $curUserId);
            if ($res['status'] == true) {
                $this->manage_users->updateUserToGroup($group, $userId);
                $p['status'] = 'success';
                $p['msg'] = 'User is updated successfully';
                echo json_encode($p);
                return;
            } else {
                $this->data['message'] = '<p>' . $res['msg'] . '</p>';
                $p['status'] = 'error';
                $p['msg'] = $res['msg'];
                echo json_encode($p);
                return;
            }
        }
        $userData = $this->manage_users->getUserData($userId);
        $name = explode(' ', $userData['name']);
        $groupId = $userData['group_id'];
        if ($userData == false) {
            $p['error'] = true;
            $p['msg'] = "User not available, invalid id";
            $this->_my_output('message', $p);
            return;
        }
        $this->data['message'] .= validation_errors();

        $this->data['first_name'] = array('name' => 'first_name',
            'type' => 'text',
            'value' => $name[0],
            'class' => 'required'
        );
        $this->data['last_name'] = array('name' => 'last_name',
            'type' => 'text',
            'value' => $name[1],
            'class' => 'required'
        );
        $this->data['phone'] = array('name' => 'phone',
            'type' => 'text',
            'value' => $userData['phone'],
            'class' => 'required digits',
            'minlength' => '10',
            'maxlength' => '12'
        );
        $this->data['username'] = array('name' => 'username',
            'readonly' => 'readonly',
            'type' => 'text',
            'value' => $userData['username']
        );
        $this->data['userId'] = $userId;
        $this->data['groupId'] = $groupId;
        $this->data['groups'] = $this->manage_users->getGroup(TRUE);
        $this->_my_output('edit_user', $this->data);
    }

    public function createGroup()
    {
        $this->form_validation->set_rules('group_name', 'Group Name', 'required|xss_clean');
        $this->form_validation->set_rules('group_description', 'Group Description');
        $this->form_validation->set_rules('group_identifier', 'Group Identifier', 'required|xss_clean');
        $this->data['message'] = '';
        if ($this->form_validation->run() == true) {
            $grpTitle = $this->input->post('group_name');
            $grpDes = $this->input->post('group_description');
            $grpIde = $this->input->post('group_identifier');
            if ($this->manage_users->checkGroup($grpIde)) {
                $p['status'] = 'error';
                $p['msg'] = 'Group identifier is already exist';
                echo json_encode($p);
                return;
            } else {
                $this->manage_users->createGroup($grpTitle, $grpDes, $grpIde);
                $p['status'] = 'success';
                $p['msg'] = 'Group is created successfully';
                echo json_encode($p);
                return;
            }

        }
        $this->data['message'] .= validation_errors();

        $this->data['group_name'] = array('name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name'),
            'class' => 'required'
        );
        $this->data['group_description'] = array('name' => 'group_description',
            'id' => 'group_description',
            'type' => 'textarea',
            'rows' => '5',
            'value' => $this->form_validation->set_value('group_description')
        );
        $this->data['group_identifier'] = array('name' => 'group_identifier',
            'id' => 'group_identifier',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_identifier'),
            'class' => 'required'
        );
        $this->_my_output('create_group', $this->data);
    }

    public function editGroup()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['error'] = true;
            $p['msg'] = "Missing Id";
            $this->_my_output('message', $p);
            return;
        }
        $groupId = $id;
        $this->form_validation->set_rules('group_name', 'Group Name', 'required|xss_clean');
        $this->form_validation->set_rules('group_description', 'Group Description');
        $this->form_validation->set_rules('group_identifier', 'Group Identifier', 'required|xss_clean');
        $this->data['message'] = '';
        if ($this->form_validation->run() == true) {
            $grpTitle = $this->input->post('group_name');
            $grpDes = $this->input->post('group_description');
            $this->manage_users->updateGroup($groupId, $grpTitle, $grpDes);
            $p['status'] = 'success';
            $p['msg'] = 'Group is updated successfully.';
            echo json_encode($p);
            return;
        }

        $groupData = $this->manage_users->getGroupData($groupId);
        if ($groupData == false) {
            $p['status'] = 'error';
            $p['msg'] = 'User not available, invalid id';
            echo json_encode($p);
            return;
        }

        $this->data['message'] .= validation_errors();

        $this->data['group_name'] = array('name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $groupData['title'],
            'class' => 'required'
        );
        $this->data['group_description'] = array('name' => 'group_description',
            'id' => 'group_description',
            'type' => 'textarea',
            'rows' => '5',
            'value' => $groupData['description']
        );
        $this->data['group_identifier'] = array('name' => 'group_identifier',
            'id' => 'group_identifier',
            'type' => 'text',
            'readonly' => 'readonly',
            'value' => $groupData['identifier'],
            'class' => 'required'
        );
        $this->data['groupId'] = $groupId;
        $this->_my_output('edit_group', $this->data);
    }

    public function deleteGroup()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['error'] = true;
            $p['msg'] = "Missing Id";
            $this->_my_output('message', $p);
            return;
        }

        $r = $this->manage_users->deleteGroup($id);
        if ($r['status'] == false) {
            $p['error'] = true;
            $p['msg'] = "Group not available";
            $this->_my_output('message', $p);
            return;
        }
        $p['error'] = false;
        $p['msg'] = "Group is successfully deleted";
        $this->_my_output('message', $p);
    }

    public function changeGroupPermission()
    {
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['error'] = true;
            $p['msg'] = "Missing Id";
            $this->_my_output('message', $p);
            return;
        }
        $groupData = $this->manage_users->getGroupData($id);
        $this->data['groupName'] = $groupData['title'];
        $this->data['groupId'] = $groupData['id'];
        $fullTabs = $this->manage_users->getTabs(0, 0, true);
        $this->data['fullMenu'] = $fullTabs;
        $arrGroupTabs = $this->manage_users->getGroupPermission($id);
        $this->data['groupTab'] = explode(',', $arrGroupTabs['tab_id']);
        $this->data['groups'] = $this->manage_users->getGroup(TRUE);
        /*$this->form_validation->set_rules('groups', 'Groups', 'required|is_natural');
        if ($this->form_validation->run() == true) {
            $fullTabs = $this->manage_users->getTabs(0, 0, true);
            $this->data['fullMenu'] = $fullTabs;
            $this->data['submitId'] = 'submitGrpData';
            $groupId = $this->input->post('groups');
            if ($this->input->post('submitId') == 'submitGrpData') {
                $tabs = $this->input->post('tabsPer');
                $this->manage_users->addGroupPermission($groupId, implode(',', $tabs));
                $this->data['sucMesg'] = '<p>Group permission updated successfully</p>';
            }
            $arrGroupTabs = $this->manage_users->getGroupPermission($groupId);
            $this->data['groupTab'] = explode(',', $arrGroupTabs['tab_id']);
        }
        else {
            $this->data['message'] = validation_errors();
            $this->data['submitId'] = 'displayGrpData';
        }
        $this->data['groups'] = $this->manage_users->getGroup(TRUE);*/
        $this->_my_output('group_permission', $this->data);
    }

    public function saveGroupPermissions()
    {
        $groupId = isset($_REQUEST['groupId']) ? $_REQUEST['groupId'] : '';
        if ($groupId == '') {
            $p['error'] = true;
            $p['msg'] = "Missing Id";
            $this->_my_output('message', $p);
            return;
        }
        $fullTabs = $this->manage_users->getTabs(0, 0, true);
        $this->data['fullMenu'] = $fullTabs;

        $tabs = $this->input->post('tabsPer');
        $this->manage_users->addGroupPermission($groupId, implode(',', $tabs));

        $p['status'] = 'success';
        $p['msg'] = 'Group permission updated successfully.';
        echo json_encode($p);
        return;
    }

    public function _my_output($file = 'manage_users', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = isset($params['tab']) ? $params['tab'] : $file;
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('manage_users/' . $file, $params, true);
        $p['menu'] = $this->manage_users->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}
