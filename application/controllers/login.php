<?php //debugbreak();
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller
{
    
    function __construct()
    {
      // debugbreak();
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('manage_users_model', 'manageUsers');
        date_default_timezone_set('Asia/Calcutta');
        $this->load->model('user', 'user');
    }

    public function index()
    {
       // debugbreak();
        $user_id = $this->user->loggedInUserId();
        if ($user_id != '' && $user_id >= 1) {
            redirect('invoice');
            return;
        }
        $this->_my_output();
    }

    public function user_logout()
    {
        $this->load->model('user', 'user');
        $this->user->logout();
        redirect("login");
    }

    public function user_login()
    {
        $success = false;
        $error_message = array();
        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : '';
        $params = array();
        $params["username"] = $username;
        if ($username == '') {
            $params["error_message"] = 'Missing Username';
            $this->_my_output($params);
            return;
        }
        if ($password == '') {
            $params["error_message"] = 'Missing Password';
            $this->_my_output($params);
            return;
        }
        $r = $this->user->login($username, $password);
        if (!isset($r['id'])) {
            $params["error_message"] = 'Invalid Username/Password';
            $this->_my_output($params);
            return;
        }
        $this->manageUsers->setUserMenu($this->user->getUserId());
        redirect('invoice');
        return;
    }

    public function _my_output($params = array())
    {
        $this->load->view('login/login', $params);
    }
}
/*END OF FILE*/