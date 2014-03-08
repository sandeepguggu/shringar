<?php
/**
 * File Name: class_model.php
 * Author: Rajat
 * Date: 4/16/12
 * Time: 12:32 PM
 */
class class_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        //$this->load->model('Attribute_Model', 'attribute');
    }

    public function add($name, $parent_id, $sort_order = 0, $user_id, $attributes = array())
    {
        if ($name == '' || $parent_id == ''|| $user_id == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `class` WHERE `name` = ? AND `parent_id` = ?", array($name, $parent_id));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if (1) {
                $q = $this->db->query("UPDATE `class` SET `name` = ?, `parent_id` = ?, `sort_order` = ?, `user_id` = ?, `deleted` = 0 WHERE `id` = ?", array($name, $parent_id, $sort_order, $user_id, $res['id']));
                if ($this->db->affected_rows() > 0) {
                    foreach ($attributes as $attribute) {
                        $this->addClassAttribute($res['id'], $attribute['id']);
                    }
                    return $res['id'];
                } else {
                    return $res['id'];
                }
            } else {
                return false;
            }
        }
        $q = $this->db->query("insert into `class` (`name`,`parent_id`,`sort_order`,`user_id`) values (?,?,?,?)", array($name, $parent_id, $sort_order, $user_id));
        $class_id = $this->db->insert_id();
        if ($this->db->affected_rows() > 0) {
            foreach ($attributes as $attribute) {
                $this->addClassAttribute($class_id, $attribute['id']);
            }
            return $class_id;
        }
    }

    public function update($id, $name, $parent_id, $sort_order, $attributes = array(), $removeAttr = array())
    {
        if ($id == '' || $name == '' || $parent_id == '' || $sort_order == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `class` WHERE `name` = ?", array($name));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($id != $res['id'])
                return false;
        }
        if (!empty($removeAttr)) {
            foreach ($removeAttr as $data) {
                $this->removeClassAttribute($res['id'], $data['id']);
            }
        }
        if (!empty($attributes)) {
            foreach ($attributes as $attribute) {
                $this->addClassAttribute($res['id'], $attribute['id']);
            }
        }
        $q = $this->db->query("update `class` SET `name` = ?, `parent_id` = ?, `sort_order` = ? WHERE `id` = ? ", array($name, $parent_id, $sort_order, $id));
        return true;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `class` where `id` = ?", array($id));
        $q = $q->row_array();
        $q['attributes'] = $this->getAttributes($id);
        return $q;
    }

    public function getProductClassById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select `sort_order`, `name` AS `class_name` FROM `class` WHERE `id` = ?", array($id));
        return $q->row_array();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `class` SET `deleted` = '1' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getAll($root = 0)
    {
        $q = $this->db->query("select * from `class`  where  `deleted` = 0 AND `parent_id` = 0 ORDER BY `id` ASC ");
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }
     
    public function getAllSubClasses($root_id, $details = 1)
    {
        //This function will return all the sub classes of a class, with or without details
        $classes = $this->getAll($root_id);
        $sub_classes_ids = array();
        $sub_classes_ids[] = $root_id;
        $sub_classes = array();
        if ($classes && is_array($classes) && count($classes) > 1) {
            foreach ($classes as $sub_class) {
                if (in_array($sub_class['parent_id'], $sub_classes_ids)) {
                    $sub_classes[] = $sub_class;
                    $sub_classes_ids[] = $sub_class['id'];
                }
            }
        }
        if ($details == 1) {
            return $sub_classes;
        } else {
            return $sub_classes_ids;
        }
    }

    public function getParents($class_id)
    {
        $this->db->select('id, name, parent_id');
        $this->db->order_by('id', 'desc');
        $older_classes = $this->db->get_where('class', array('id <=' => $class_id))->result_array();
        $parents = array();
        $token_class = $older_classes[0];
        $parents[] = $token_class;
        foreach ($older_classes as $older_class) {
            if ($token_class['id'] == 0) {
                break;
            }
            if ($older_class['id'] == $token_class['parent_id']) {
                $parents[] = $older_class;
                $token_class = $older_class;
            }
        }
        return array_reverse($parents);
    }

    public function accumulateStock($classes, $sorted = 'ASC')
    {
        //$classes must be ordered by ids in ASC or DESC
        $id_indexed_classes = array();
        foreach ($classes as $class) {
            $id_indexed_classes[$class['id']] = $class;
        }
        if ($sorted == 'DESC') {
            $id_indexed_classes = array_reverse($id_indexed_classes);
        }
        if ($sorted == 'ASC') {
            $classes = array_reverse($classes);
        }
        foreach ($classes as $class) {
            if (isset($id_indexed_classes[$class['parent_id']])) {
                if (!isset($id_indexed_classes[$class['parent_id']]['stock'])) {
                    $id_indexed_classes[$class['parent_id']]['stock'] = 0;
                }
                $id_indexed_classes[$class['parent_id']]['stock'] += $id_indexed_classes[$class['id']]['stock'];
            }
        }
        return $id_indexed_classes;
    }

    public function getClassTree($root = 0, $classes = array())
    {
        if (!is_array($classes) || count($classes) < 1) {
            $q = $this->db->query("select `id`, `name`, `parent_id` from `class` WHERE `id` > 0 AND `deleted` = 0 ORDER BY `parent_id`, `name` ASC");
            $classes = $q->result_array();
        }
        echo json_encode($classes);exit;
        $class_tree = array();
        foreach ($classes as &$class) {
            if ($class['parent_id'] == $root) {
                $class_tree[] = &$class;
            }
            foreach ($classes as &$val_class) {
                if ($val_class['parent_id'] == $class['id']) {
                    if (!isset($class['sub'])) {
                        $class['sub'] = array();
                    }
                    $class['sub'][] = &$val_class;
                }
            }
        }
        return $class_tree;
    }

    public function getAllByParent($parent_id)
    {
        $q = $this->db->query("select * from `class` WHERE `id` > 1 AND `parent_id` = ? ORDER BY `sort_order` ASC", array($parent_id));
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

    public function addClassAttribute($class_id, $attribute_id, $force_new = 0)
    {
        if ($force_new == -1) {
            if ($this->db->query("UPDATE `class_attribute` SET `deleted` = 0 WHERE `attribute_id` = ? AND `class_id` = ?", array($attribute_id, $class_id))) {
                return TRUE;
            }
        }
        $q = $this->db->query("insert into `class_attribute` (`attribute_id`, `class_id`, `created_at`) values (?, ?, NOW())", array($attribute_id, $class_id));
        return $this->db->insert_id();
    }

    public function removeClassAttribute($class_id, $attribute_id)
    {
        //return $this->db->query("UPDATE `class_attribute` SET `deleted` = 1 WHERE `attribute_id` = ? AND `class_id` = ?", array($attribute_id, $class_id));
        return $this->db->query("DELETE FROM `class_attribute` WHERE `attribute_id` = ? AND `class_id` = ?", array($attribute_id, $class_id));
    }

    public function getAttributes($class_id)
    {
        $q = $this->db->query("SELECT ca.`attribute_id` as id, a.name as name, a.level as level, a.display_name as display_name" .
            " FROM `class_attribute` ca, attribute a WHERE ca.class_id = ? AND a.id = ca.attribute_id", array($class_id));
        return $q->result_array();
    }
}