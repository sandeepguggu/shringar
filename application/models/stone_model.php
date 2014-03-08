<?php

/**
 * Description of stone_model
 *
 * @author Sandeep
 */
class stone_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /*
     *  Add Stone to Master Table
     */

    public function getById($id) {
        if ($id == '') {
            return false;
        }

        $sql = "SELECT * FROM `stone` WHERE `id`=?";
        $res = $this->db->query($sql, array($id));
        if ($res->num_rows() <= 0) {
            return false;
        }
        return $res->row_array();
    }

    public function add($name, $type, $category_id) {
        $p = array();
        if ($name == '' || $type == '' || $category_id == '') {
            $p['status'] = false;
            $p['msg'] = 'Empty Values in Stone Entries';
            return $p;
        }
        $sql = "INSERT INTO `stone` (`name`, `type`, `category_id`) VALUES (?,?,?)";
        $this->db->query($sql, array($name, $type, $category_id));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error occured while adding Stone to Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'Stone is Successfully added to Database';
        return $p;
    }

    //    public function _convert_to_carat($weight, $weight_unit) {
    //        if($weight_unit == 'carat') {
    //            return $weight;
    //        } else if($weight_unit == 'cent') {
    //
	//        }
    //    }
    /*
     * Retrieve All Stone Items
     */
    public function getAll() {
        $sql = "SELECT * FROM `stone`";
        $res = $this->db->query($sql);
        if ($res->num_rows() <= 0) {
            return FALSE;
        }
        return $res->result_array();
    }

    public function suggestItem($term) {
        if ($term == '') {
            return false;
        }
        $sql = "select o.*,o.`name` as `value` from `stone` o where o.`name` like '%" . ($term) . "%' AND o.`deleted` = '0'";

        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    /*    public function getRate($id){
      if($id == '') {
      return false;
      }

      $sql = "SELECT `rate_per_gram` FROM `stone` WHERE `id`=?";
      $res = $this->db->query($sql, array($id));
      if($res->num_rows() <= 0) {
      return false;
      }
      $array =  $res->row_array();
      return $array['rate_per_gram'];
      } */

    public function suggestOldItem($term) {
        if ($term == '') {
            return false;
        }
        $sql = "select o.*,o.`name` as `value` from `stone` o where o.`name` like '%" . ($term) . "%' AND o.`is_old` = 1 AND o.`deleted` = '0'";

        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function getComponentsById($id) {
        return array();
    }

}

?>
