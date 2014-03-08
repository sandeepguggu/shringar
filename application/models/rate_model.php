<?php
/**
 * Description of rate_model
 *
 * @author Sandeep
 */
class rate_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function addMetalRate($item_specific_id, $price)
    {
        $p = array();
        if ($item_specific_id == '' || $price == '') {
            $p['status'] = false;
            $p['msg'] = 'Empty Values in Metal Rate Entries';
            return $p;
        }

        $sql = "INSERT INTO `rate` (`item_specific_id`, `updated_at`, `price`) VALUES(?,NOW(),?)";
        $this->db->query($sql, array($item_specific_id, $price));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error occured while adding Metal Rate to Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'Metal Rate is Successfully added to Database';
        return $p;
    }

    public function setRate($item_entity_id, $item_specific_id, $price, $unit = 'g')
    {
        $p = array();
        if ($item_specific_id == '' || $price == '') {
            $p['status'] = false;
            $p['msg'] = 'Empty Values in Rate Entries';
            return $p;
        }
        $sql = "INSERT INTO `rate` (`item_entity_id`, `item_specific_id`, `updated_at`, `price`, `unit`) VALUES(?,?,NOW(),?,?)";
        $this->db->query($sql, array($item_entity_id, $item_specific_id, $price, $unit));
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error occured while adding Rate to Database';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'Rate is Successfully added to Database';
        return $p;
    }

    public function getHeader()
    {
        $header = '';
        $sql = "SELECT mr.`price` AS price FROM 
            `rate` mr, `metal` m
            WHERE m.`name`='Gold' AND m.`purity_carat`='24'
            ORDER BY mr.`updated_at` DESC LIMIT 1";
        $res = $this->db->query($sql);
        if ($res->num_rows() == 1) {
            $row = $res->row_array();
            $header .= 'Gold : <b>Rs. &nbsp;' . $row['price'] . ' /-</b>';
        } else {
            $header .= 'Gold : <b>No Data</b>';
        }

        $sql = "SELECT mr.`price` AS price FROM 
            `rate` mr, `metal` m
            WHERE m.`name`='Silver' AND m.`purity_carat`='100'
            ORDER BY mr.`updated_at` DESC LIMIT 1";
        $res = $this->db->query($sql);
        if ($res->num_rows() == 1) {
            $row = $res->row_array();
            $header .= '&nbsp;Silver : <b>Rs. &nbsp;' . $row['price'] . ' /-</b>';
        } else {
            $header .= '&nbsp; Silver : <b>No Data</b>&nbsp;';
        }
        return $header;
    }

    public function getMetalRate($item_specific_id)
    {
        if ($item_specific_id == '') {
            return false;
        }

        $sql = "SELECT * FROM `rate` WHERE `item_specific_id`=? ORDER BY updated_at DESC LIMIT 1";
        $res = $this->db->query($sql, array($item_specific_id));
        if ($res->num_rows() != 1) {
            return false;
        }
        $res = $res->row_array();
        return $res['price'];
    }

    public function getRate($item_entity_id, $item_specific_id)
    {
        if ($item_entity_id == '' || $item_specific_id == '') {
            return false;
        }
        $sql = "SELECT * FROM `rate` WHERE `item_specific_id`=? AND `item_entity_id`=? ORDER BY updated_at DESC LIMIT 1";
        $res = $this->db->query($sql, array($item_specific_id, $item_entity_id));
        if ($res->num_rows() != 1) {
            return false;
        }
        $res = $res->row_array();
        return $res['price'];
    }
}
/*END OF FILE*/