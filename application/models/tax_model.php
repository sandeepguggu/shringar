<?php
/**
 * File Name: tax_model.php
 * Author: Rajat
 * Date: 4/17/12
 * Time: 11:48 AM
 */
class tax_Model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function add($name, $display_name, $rate_value, $user_id, $min_value=0,  $min_applicable_amt=0, $rate_type='percent')
    {
        $q = $this->db->query("insert into `tax` (`name`, `display_name`, `rate_type`, `rate_value`, `min_applicable_amt`, `min_value`, `user_id` `updated_at`)".
            " values (?, ?, NOW())", array($name, $display_name, $rate_type, $rate_value, $user_id, $min_value,  $min_applicable_amt));
        return $this->db->insert_id();
    }

    public function delete($id)
    {
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `tax` SET `deleted` = '1' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function suggest($term)
    {
        $taxes = array();
        //$taxes = $this->product_header->gettaxes($term);
        if ($term == '') {
            return false;
        }
        $sql = "select `id` , `name`, `level` FROM `tax` WHERE `name` like '%" . ($term) . "%' AND `deleted` = 0";

        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            $taxes_secondary = $q->result_array();
            $taxes = array_merge($taxes, $taxes_secondary);
        }
        return $taxes;

    }
}