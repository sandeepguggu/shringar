<?php
/**
 * Add Metal to Databse
 *
 * @author Sandeep
 */
class metal_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
    * Add Metal Item to Metal Master Table
    */
    public function add($name, $karat, $fineness, $unit='g', $type, $category_id, $is_old = 0,  $low_threshold=0, $high_threshold=-1) {
        $p = array();
        if($name == '' || $karat == '' || $fineness == '' || $type == '' || $category_id == '') {
            $p['status'] = false;
            $p['msg'] = 'Empty Values in Metal Entries';
            return $p;
        }

        $sql = "SELECT * FROM `metal` WHERE `name`=?";
        $res = $this->db->query($sql, array($name));
        //log_message('error', $res->num_rows());
        if($res->num_rows() > 0) {
            $p['status'] = false;
            $p['msg'] = 'Duplicate Metal Entry';
            return $p;
        }

        $sql = "INSERT INTO `metal` (`name`, `karat`, `fineness`, `type`,`category_id`,`unit`, `low_threshold`, `high_threshold`, `is_old`) values(?,?,?,?,?,?,?,?,?)";
        $res = $this->db->query($sql, array($name, $karat, $fineness, $type, $category_id, $unit, $low_threshold, $high_threshold, $is_old));
        if($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error occured while adding Metal to Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'Metal is Successfully Added to Database';
        return $p;
    }

    /*
    * Update Metal Item to Metal Master Table
    */
    public function update($id, $name, $purity_carat, $purity_percent, $unit='g', $low_threshold=0, $high_threshold=-1) {
        $p = array();
        if($name == '' || $purity_carat == '' || $purity_percent == '' || $id == '') {
            $p['status'] = false;
            $p['msg'] = 'Empty Values in Metal Entries';
            return $p;
        }

        $sql = "SELECT * FROM `metal` WHERE `name`=? AND `purity_carat`=? AND `purity_percent`=?";
        $res = $this->db->query($sql, array($name, $purity_carat, $purity_percent));
        log_message('error', $res->num_rows());
        if($res->num_rows() > 0) {
            $p['status'] = false;
            $p['msg'] = 'Duplicate Metal Entry';
            return $p;
        }

        $sql = "UPDATE `metal` SET `name`=?, `purity_carat`=?, `purity_percent`=?, `unit`=?, `low_threshold`=?, `high_threshold`=? WHERE `id`=?";
        $res = $this->db->query($sql, array($name, $purity_carat, $purity_percent, $unit, $low_threshold, $high_threshold, $id));

        $p['status'] = true;
        $p['msg'] = 'Metal is Successfully Updated';
        return $p;
    }

    public function getById($id) {
        if($id == '') {
            return false;
        }

        $sql = "SELECT * FROM `metal` WHERE `id`=?";
        $res = $this->db->query($sql, array($id));
        if($res->num_rows() <= 0) {
            return false;
        }
        return $res->row_array();
    }

    /*
    * Retrieve All Metal Items
    */
    public function getAll() {
        $sql = "SELECT * FROM `metal`";
        $res = $this->db->query($sql);
        if($res->num_rows() <= 0) {
            return FALSE;
        }
        return $res->result_array();
    }

    /*
    * Get Metal Rate
    */

    public function suggestItem($term){
        if($term == ''){
            return false;
        }
        $sql = "select o.*,o.`name` as `value` from `metal` o where o.`name` like '%".($term)."%' AND o.`deleted` = '0'";

        $q = $this->db->query($sql);
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }

    public function suggestOldItem($term){
        if($term == ''){
            return false;
        }
        $sql = "select o.*,o.`name` as `value` from `metal` o where o.`name` like '%".($term)."%' AND o.`is_old` = 1 AND o.`deleted` = '0'";

        $q = $this->db->query($sql);
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }

    public function deleteById($id){
        // Test of products, if no products then only allow deleting
        $r = $this->getMetalById($id);
        if(isset($r['id'])){
            $this->db->query("UPDATE `metal` SET `deleted` = '1' where `id` = ?", array($r['id']));
            if($this->db->affected_rows() <= 0){
                return false;
            }
        }
        return $r;
    }

    public function getComponentsById($id){
        return array();
    }
}
/*END OF FILE*/