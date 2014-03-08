<?php

class Category_Model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function add($name, $parent_id, $vat_percentage, $user_id)
    {
        if ($name == '' || $parent_id == '' || $vat_percentage == '' || $user_id == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `category` WHERE `name` = ?", array($name));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($res['deleted'] == '1') {
                $q = $this->db->query("UPDATE `category` SET `deleted` = '0', `name` = ?, `parent_id` = ?, `vat_percentage` = ?, `user_id` = ? WHERE `id` = ?", array($name, $parent_id, $vat_percentage, $user_id, $res['id']));
                if ($this->db->affected_rows() > 0)
                    return $res['id'];
                else
                    return false;
            } else
                return false;
        }
        $q = $this->db->query("insert into `category` (`name`,`parent_id`,`vat_percentage`,`user_id`) values (?,?,?,?)", array($name, $parent_id, $vat_percentage, $user_id));
        return $this->db->insert_id();
    }

    public function update($id, $name, $parent_id, $vat_percentage)
    {
        if ($id == '' || $name == '' || $parent_id == '' || $vat_percentage == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `category` WHERE `name` = ?", array($name));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($id != $res['id'])
                return false;
        }
        $q = $this->db->query("update `category` SET `deleted` = '0', `name` = ?, `parent_id` = ?, `vat_percentage` = ? WHERE `id` = ? ", array($name, $parent_id, $vat_percentage, $id));
        if ($this->db->affected_rows() <= 0) {
            return false;
        }
        return true;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `category` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function getProductCategoryById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select `vat_percentage`, `name` AS `category_name` FROM `category` WHERE `id` = ?", array($id));
        return $q->row_array();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `category` SET `deleted` = '1' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `category` WHERE `id` > 0 AND `deleted` = 0 ORDER BY `name` ASC");
        if ($q->num_rows() > 0) {
            return $q->result_array();
            /*
              $result = array();
              foreach($q->result_array() as $r){
              $result[] = $r;
              }
              //print_r($result);
              return $result; */
        }
        return false;
    }

    public function getAllvatpercentages()
    {
        $data = $this->db->query("select DISTINCT vat_percentage from category where vat_percentage != 0 ORDER by vat_percentage DESC ")->result_array();
        return $data;
    }

}