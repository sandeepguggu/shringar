<?php

class Rent_Category_Model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function add($name, $parent_id, $user_id) {
        if ($name == '' || $parent_id == '' || $user_id == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `rent_category` WHERE `category_name` = ?", array($name));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($res['status'] == '1') {
                $q = $this->db->query("UPDATE `rent_category` SET `deleted` = '0', `category_name` = ?, `parent_id` = ?  WHERE `id` = ?", array($name, $parent_id, $res['id']));
                if ($this->db->affected_rows() > 0)
                    return $res['id'];
                else
                    return false;
            } else
                return false;
        }
        $q = $this->db->query("insert into `rent_category` (`category_name`,`parent_id`,`created_date`,`user_id`,`status`) values (?,?,?,?)", array($name, $parent_id, date('Y-m-d H:i:s'),$user_id),1);
        return $this->db->insert_id();
    }

    public function update($id, $category_name, $parent_id) {
        if ($id == '' || $category_name == '' || $parent_id == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `rent_category` WHERE `category_name` = ?", array($category_name));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($id != $res['id'])
                return false;
        }
        $q = $this->db->query("update `rent_category` SET `status` = '1', `category_name` = ?, `parent_id` = ? WHERE `id` = ? ", array($category_name, $parent_id,  $id));
        if ($this->db->affected_rows() <= 0) {
            return false;
        }
        return true;
    }

    public function getById($id) {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `rent_category` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function getProductCategoryById($id) {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select `vat_percentage`, `name` AS `category_name` FROM `category` WHERE `id` = ?", array($id));
        return $q->row_array();
    }

    public function deleteById($id) {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `rent_category` SET `status` = '0' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getAll() {
         $result = array();
        $q = $this->db->query("select * from `rent_category` WHERE `id` > 0 AND `status` = 1 ORDER BY `category_name` ASC");
        if ($q->num_rows() > 0) {
            //return $q->result_array();
              foreach($q->result_array() as $r){
              $result[] = $r;
              }
              return $result;
        }
        return false;
    }

}