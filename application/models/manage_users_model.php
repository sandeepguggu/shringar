<?php
class Manage_users_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getGroup($dropDown = false)
    {
        $q = $this->db->query("select * from `group`");
        if ($q->num_rows() > 0) {
            $resultData = $q->result_array();
            if($dropDown === TRUE){
                $ddData = array();
                foreach($resultData as $i => $val){
                    $ddData[$val['id']] = $val['title'];
                }
                return $ddData;
            }
            return $resultData;
        }
        return false;
    }

    public function addGroupPermission($groupId, $tabs)
    {
        $q = $this->db->query("select * from `group_tab_permission` where `group_id` = ?", array($groupId));
        if ($q->num_rows() > 0) {
            $sql = "UPDATE `group_tab_permission` SET `tab_id`= ? WHERE `group_id`=?";
            $this->db->query($sql, array($tabs, $groupId));
            if ($this->db->affected_rows() <= 0) {
                $p['status'] = false;
                $p['msg'] = 'Database Error in UpdateGroupPermission';
                return $p;
            }
        }
        else{
            $sql = "INSERT INTO `group_tab_permission` (`group_id`, `tab_id`) VALUES(?,?)";
            $this->db->query($sql, array($groupId, $tabs));
            if ($this->db->affected_rows() <= 0) {
                $p['status'] = false;
                $p['msg'] = 'Database Error in AddGroupPermission';
                return $p;
            }
        }
        $p['status'] = true;
        $p['msg'] = 'Group permission is inserted';
        return $p;
    }

    public function getGroupPermission($groupId)
    {
        $q = $this->db->query("select * from `group_tab_permission` where `group_id` = ? ", array($groupId));
        if ($q->num_rows() > 0) {
            $resultData = $q->row_array();
            return $resultData;
        }
        return false;
    }

    public function createGroup($groupTitle, $groupDes, $groupIde)
    {
        $sql = "INSERT INTO `group` (`title`, `identifier`, `description`) VALUES(?,?,?)";
        $this->db->query($sql, array($groupTitle, $groupIde, $groupDes));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error in AddGroupPermission';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'Group is created';
        return $p;
    }

    public function checkGroup($groupIde)
    {
        $q = $this->db->query("select * from `group` where `identifier` = ? and deleted = 0", array($groupIde));
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function createUser($username, $password, $firstname, $lastname, $phone, $managerId)
    {
        $name = $firstname .' '. $lastname;
        $username = strtolower($username);
        $sql = "INSERT INTO `users` (`username`, `password`, `name`, `phone`, `manager_id`) VALUES(?,?,?,?,?)";
        $this->db->query($sql, array($username, $password, $name, $phone, $managerId));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error in createUser';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'User is created';
        $p['userId'] = $this->db->insert_id();
        return $p;
    }

    public function updateUser($userId, $firstName, $lastName, $phone, $curUserId)
    {
        $name = $firstName .' '. $lastName;
        $sql = "UPDATE `users` SET `name`= ?, `phone`= ?, `manager_id`= ? WHERE `id`=?";
        $this->db->query($sql, array($name, $phone, $curUserId, $userId));
        $p['status'] = true;
        $p['msg'] = 'User details is successfully';
        return $p;
    }

    public function checkUsername($username)
    {
        $username = strtolower($username);
        $q = $this->db->query("select * from `users` where `username` = ? and `deleted` = 0", array($username));
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function insertUserToGroup($groupId, $userId)
    {
        $sql = "INSERT INTO `user_group` (`user_id`, `group_id`) VALUES(?,?)";
        $this->db->query($sql, array($userId, $groupId));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error in AddGroupPermission';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'User inserted into group successfully';
        return $p;
    }

    public function updateUserToGroup($groupId, $userId)
    {
        $sql = "UPDATE `user_group` SET `group_id`=? WHERE `user_id`=?";
        $this->db->query($sql, array($groupId, $userId));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Error in updating User group from Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'User details updated successfully';
        return $p;
    }

    public function deleteUser($userId)
    {
        $sql = "SELECT * FROM `users` WHERE `id`=?";
        $res = $this->db->query($sql, array($userId));
        if ($res->num_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'User not available';
            return $p;
        }
        $sql = "UPDATE `users` SET `deleted`= '1' WHERE `id`=?";
        $this->db->query($sql, array($userId));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Error in Deleting User from Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'User is Successfully deleted from Database';
        return $p;
    }

    public function getUserData($userId)
    {
        $q = $this->db->query("select * from `users` INNER JOIN user_group ON users.id = user_group.user_id where users.id = ? and users.deleted=0", array($userId));
        if ($q->num_rows() > 0) {
            $resultData = $q->row_array();
            return $resultData;
        }
        return false;
    }

    public function getGroupData($groupId)
    {
        $q = $this->db->query("select * from `group` where id = ? and deleted=0", array($groupId));
        if ($q->num_rows() > 0) {
            $resultData = $q->row_array();
            return $resultData;
        }
        return false;
    }

    public function updateGroup($groupId, $grpTitle, $grpDes)
    {
        $sql = "UPDATE `group` SET `title`= ?, `description`= ? WHERE `id`=?";
        $this->db->query($sql, array($grpTitle, $grpDes, $groupId));
        $p['status'] = true;
        $p['msg'] = 'Group details is updated successfully';
        return $p;
    }

    public function deleteGroup($groupId)
    {
        $sql = "SELECT * FROM `group` WHERE `id`=?";
        $res = $this->db->query($sql, array($groupId));
        if ($res->num_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Group not available';
            return $p;
        }
        $sql = "UPDATE `group` SET `deleted`= '1' WHERE `id`=?";
        $this->db->query($sql, array($groupId));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Error in Deleting group from Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'Group is Successfully deleted from Database';
        return $p;
    }

    public function getTabsTree()
    {
        $q = $this->db->query("select * from `tabs` ORDER BY `index`");
        $resultData = $q->result_array();
        return $resultData;
    }

    public function getTabs($arrUserMenu = array()){
        $result = $this->getTabsTree();
        $refs = array();
        $list = array();
        foreach($result as $i => $data){
            if(!empty($arrUserMenu))
            {
                foreach($arrUserMenu as $j => $key){
                    if($key == $data['id']){
                        $thisref = &$refs[ $data['id'] ];
                        $thisref['p_id'] = $data['p_id'];
                        $thisref['title'] = $data['title'];
                        $thisref['identifier'] = $data['identifier'];
                        $thisref['url'] = $data['url'];
                        $thisref['index'] = $data['index'];
                        $thisref['class_css'] = $data['class_css'];
                        $thisref['selected'] = 0;
                        if ($data['p_id'] == 0) {
                            $list[ $data['id'] ] = &$thisref;

                        } else {
                            $refs[ $data['p_id'] ]['children'][ $data['id'] ] = &$thisref;
                        }
                    }
                }
            }else{
                $thisref = &$refs[ $data['id'] ];
                $thisref['p_id'] = $data['p_id'];
                $thisref['title'] = $data['title'];
                $thisref['identifier'] = $data['identifier'];
                $thisref['url'] = $data['url'];
                $thisref['index'] = $data['index'];
                $thisref['class_css'] = $data['class_css'];

                if ($data['p_id'] == 0) {
                    $list[ $data['id'] ] = &$thisref;
                } else {
                    $refs[ $data['p_id'] ]['children'][ $data['id'] ] = &$thisref;
                }
            }
        }
        return $list;
    }

    public function setUserMenu($userId)
    {
        $q = $this->db->query("select * from `users` INNER JOIN user_group ON users.id = user_group.user_id INNER JOIN group_tab_permission ON user_group.group_id = group_tab_permission.group_id where users.id = ? and users.deleted=0", array($userId));
        if ($q->num_rows() > 0) {
            $resultData = $q->row_array();
            $arrUserMenu = explode(',',$resultData['tab_id']);
            $tabTree = $this->getTabs($arrUserMenu);
            $_SESSION['userTree'] = $tabTree;
            return $tabTree;
        }
    }

    //$this->manage_users->getUserMenu(1, 'goldsmith');
    public function getUserMenu($identifier = null)
    {
        if (!empty($_SESSION['userTree'])) {
            $tabTree = $_SESSION['userTree'];
            if(isset($identifier)){
                $this->getMark($tabTree, $identifier);
                return $tabTree;
            }else{
                return $tabTree;
            }
        }
    }

    public function getMark(&$arrMenu, $identifier)
    {
        foreach($arrMenu as $key => $val){
            if($identifier == $arrMenu[$key]['identifier']){
                $arrMenu[$key]['selected'] = 1;
                return true;
            }
            else {
                if(isset($arrMenu[$key]['children']))
                    $flag = $this->getMark($arrMenu[$key]['children'], $identifier);
                else
                    continue;
            }
            if($flag){
                $arrMenu[$key]['selected'] = 1;
            }
        }
    }
    public function isAccessAllowed($identifier)
    {
        if (!empty($_SESSION['userTree'])) {
            $tabTree = $_SESSION['userTree'];
            if(isset($identifier)){
                return $this->menuSearch($tabTree, $identifier);
            }else{
                return false;
            }
        }
        return false;
    }

    public function menuSearch($arrMenu, $identifier)
    {
        foreach($arrMenu as $key => $val){
            if($arrMenu[$key]['identifier'] == $identifier){
                return true;
            }
            else {
                if(isset($arrMenu[$key]['children']))
                    $flag = $this->menuSearch($arrMenu[$key]['children'], $identifier);
                else
                    continue;
            }
            if($flag){
                return true;
            }
        }
        return false;
    }
}