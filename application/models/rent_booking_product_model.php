<?php

class Rent_Booking_Product_Model extends CI_Model {

    public function __construct() {
        $this->name = 'rent_booking_product';
        $this->load->database();
    }

    public function insert($data) {
        if ($data['bookingId']== '' || $data['productId'] == '') {
            return false;
        }
        $q = $this->db->query("insert into `rent_booking_product` (`booking_id`,`product_id`) values (?,?)", array($data['bookingId'], $data['productId']));
        return $this->db->insert_id();
    }
    
    public function getDataByBookingId($bookingId) {
        if($bookingId != '') {
            $q = $this->db->query("SELECT * FROM ".$this->name." WHERE id =".$bookingId);
            $resultSet =  $q->row_array();
            return $resultSet;
        }
    }
}