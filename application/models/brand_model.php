<?php
class Brand_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function add($name, $user_id, $description = '')
    {
        if ($name == '' || $user_id == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `brand` WHERE `name` = ?", array($name));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($res['deleted'] == '1') {
                $q = $this->db->query("UPDATE `brand` SET `deleted` = '0', `description` = ? WHERE `id` = ?", array($description, $res['id']));
                if ($this->db->affected_rows() > 0) {
                    return $res['id'];
                } else {
                    return false;
                }
            } else
                return $res['id'];
        } else {
            $q = $this->db->query("insert into `brand` (`name`,`user_id`, `description`) values (?,?,?)", array($name, $user_id, $description));
            return $this->db->insert_id();
        }
    }

    public function update($id, $name, $description = '')
    {
        if ($id == '' || $name == '') {
            return false;
        }
        $q = $this->db->query("SELECT * FROM `brand` WHERE `name` = ?", array($name));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($id != $res['id']) {
                return false;
            }
        }
        $q = $this->db->query("update `brand` set `deleted` = '0', `name` = ?, `description` = ? WHERE `id` = ? ", array($name, $description, $id));
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
        $q = $this->db->query("select * from `brand` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `brand` SET `deleted` = '1' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function suggest($term)
    {
        $brands = array();
        if ($term == '') {
            return false;
        }
        $sql = "select `id` , `name` FROM `brand` WHERE `name` like '%" . ($term) . "%' AND `deleted` = 0";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            $brands = $q->result_array();
        }
        return $brands;
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `brand` ORDER BY `name` ASC");
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }
}