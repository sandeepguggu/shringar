<?php
/**
 * File Name: attribute_model.php
 * Author: Rajat
 * Date: 4/17/12
 * Time: 11:48 AM
 */
/**************************************
Field            Type
---------------  --------------------------
id               int(10) unsigned
name             varchar(20)
display_name     char(20)
level            int(11)
availability     enum('sku','header','both'
value_type       varchar(20)
criticality      tinyint(1)
multiple_of      float
min_value        varchar(10)
max_value        varchar(20)
default_value    varchar(20)
all_caps         tinyint(1)
all_small        tinyint(1)
numeric_allowed  tinyint(1)
special_allowed  tinyint(1)
editable         tinyint(1)
value_set        text
created_at       datetime
user_id          int(11)
deleted          tinyint(1)
 **************************************/
class attribute_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        //$this->load->model('Product_header_Model', 'product_header');
        $this->attributes = array();
    }

    public function add($name, $level = '', $display_name = '', $availability = '', $value_type = '', $criticality = '', $value_set = '', $case = '', $min_value = '', $max_value = '', $character_set = '', $default_value = '')
    {
        if ($name == '') {
            return False;
        }
        if ($level == '') {
            $level = 2;
        }
        if ($display_name == '') {
            $display_name = $name;
        }
        if ($availability == '') {
            $availability = 'both';
        }
        if ($value_type == '') {
            $value_type = 'text';
        }
        if ($criticality == '') {
            $criticality = 1;
        }
        if ($value_set == '') {
            // Will we need this?? Lets see
            $value_set = '';
        }
        $created_at = date('Y-m-d H:i:s');
        $q = $this->db->query("insert into `attribute` (`name`, `level`,`display_name`,`availability`,`value_type`, `criticality`, `value_set`, `case`, `min_value`, `max_value`, `character_set`, `default_value`,`created_at`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($name, $level, $display_name, $availability, $value_type, $criticality, $value_set, $case, $min_value, $max_value, $character_set, $default_value, $created_at));
        return $this->db->insert_id();
    }

    public function delete($id)
    {
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `attribute` SET `deleted` = '1' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getById($id)
    {
        $query = $this->db->get_where('attribute', array('id' => $id));
        return $query->row_array();
    }

    public function suggest($term)
    {
        $attributes = array();
        //$attributes = $this->product_header->getAttributes($term);
        if ($term == '') {
            return false;
        }
        $sql = "select `id` , `name`, `level`, `display_name` FROM `attribute` WHERE `name` like '%" . ($term) . "%' AND `deleted` = 0";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            $attributes_secondary = $q->result_array();
            $attributes = array_merge($attributes, $attributes_secondary);
        }
        return $attributes;
    }

    public function getAllPrimaryAttributes($sku = '')
    {
        $this->db->select('*');
        if ($sku == 1) {
            $q = $this->db->get_where('attribute', array('level' => 1, 'availability !=' => 'header'));
        } elseif ($sku == 0) {
            $q = $this->db->get_where('attribute', array('level' => 1, 'availability !=' => 'sku'));
        } else {
            $q = $this->db->get_where('attribute', array('level' => 1));
        }
        return $q->result_array();
    }

    public function getPrimaryAttributesName($sku = '')
    {
        $this->db->select('name');
        if ($sku == 1) {
            $q = $this->db->get_where('attribute', array('level' => 1, 'availability !=' => 'header'));
        } elseif ($sku == 0) {
            $q = $this->db->get_where('attribute', array('level' => 1, 'availability !=' => 'sku'));
        } else {
            $q = $this->db->get_where('attribute', array('level' => 1));
        }
        $q = $q->result_array();
        $return = array();
        foreach ($q as $att) {
            $return[] = $att['name'];
        }
        return $return;
    }

    public function getPrimaryAttributes($term = '')
    {
        if ($term == '') {
            $this->db->select('id, name, display_name, level');
            $q = $this->db->get_where('attribute', array('level' => 1));
            return $q->result_array();
        } else {
            $this->db->select('id, name, display_name, level');
            $this->db->where('attribute', array('level' => 1));
            $this->db->like('name', $term);
            $q = $this->db->get();
            return $q->result_array();
        }
    }

    public function getByName($name = '')
    {
        $attribute = array();
        $name = trim($name);
        if ($name == '') {
        } else {
            $this->db->select('id, name, display_name, level');
            $q = $this->db->get_where('attribute', array('name' => $name));
            //$q = $this->db->get();
            $attribute = $q->row_array();
        }
        return $attribute;
    }
}