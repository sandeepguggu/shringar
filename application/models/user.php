<?php
class User extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model('Manage_users_model', 'manage_users');
    }

    public function login($username, $password)
    {
        $q = $this->db->query("select * from `users` where `username` = ? AND `password` = ?", array($username, $password));
        if ($q->num_rows()) {
            $r = $q->row_array();
            $_SESSION['login'] = true;
            $_SESSION['user'] = $r;
            return $r;
        }
        return false;
    }

    public function logout()
    {
        $_SESSION['login'] = false;
        unset($_SESSION['user']);
        unset($_SESSION['userTree']);
    }

    public function loggedInUserId()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return '';
        }
        return $_SESSION['user']['id'];
    }

    public function getUserId()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return '';
        }
        return $_SESSION['user']['id'];
    }

    public function getBranch()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            return '';
        }
        return $_SESSION['user']['branch_id'];
    }

    public function getBranchId()
    {
        return $this->getBranch();
    }

    public function getUserAccessLevel()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['access_level'])) {
            return '0';
        }
        return $_SESSION['user']['access_level'];
    }

    public function isAccessAllowed($identifier)
    {
        if (!empty($_SESSION['userTree'])) {
            $tabTree = $_SESSION['userTree'];
            if (isset($identifier)) {
                return $this->manage_users->menuSearch($tabTree, $identifier);
            } else {
                return false;
            }
        }
        return false;
    }

    public function add($user_name, $password, $name, $phone, $manager_id, $access_level, $created_by)
    {
        $p = array();
        $sql = "SELECT * FROM `users` WHERE `username`=?";
        $res = $this->db->query($sql, array($user_name));
        if ($res->num_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'User Name is already Taken';
            return $p;
        }
        $sql = "INSERT INTO `users` (`username`, `password`, `name`, `manager_id`, `access_level`, `created_by`) VALUES(?,?,?,?,?,?)";
        $this->db->query($sql, array($user_name, $password, $name, $manager_id, $access_level, $created_by));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error in User Registration';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'User is Successfully added to Database';
        return $p;
    }

    public function changePassword($id, $old_password, $new_password)
    {
    }

    public function delete($id)
    {
        $p = array();
        $sql = "SELECT * FROM `users` WHERE `id`=?";
        $res = $this->db->query($sql, array($id));
        if ($res->num_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Oops! The user is you passed is not exist in Database';
            return $p;
        }
        $sql = "UPDATE `users` SET `deleted`= '1' WHERE `id`=?";
        $this->db->query($sql, array($id));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Error in Deleting User from Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'User is Successfully deleted from Database';
        return $p;
    }
}