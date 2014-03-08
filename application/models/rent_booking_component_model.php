<?php

class Rent_Booking_Component_Model extends CI_Model {

    public function __construct() {
        $this->name = 'rent_booking_component';
        $this->load->database();
    }

    public function insert($data) {
        if ($data['bookingId']== '' || $data['componentId'] == '') {
            return false;
        }
        $q = $this->db->query("insert into `rent_booking_component` (`booking_id`,
                                `product_id`,`component_id`,`rent_price`,`quantity`) values (?,?,?,?,?)", 
                                array($data['bookingId'], $data['productId'], 
                                $data['componentId'],$data['rent_price'], $data['quantity']));
        return $this->db->insert_id();
    }
    
    public function update($data) {

         $insert_array = array(
                        'booking_id'    => $data['bookingId'],
                        'product_id'    => $data['productId'],
                        'component_id'  => $data['componentId'],
                        'rent_price'    => $data['rent_price'],
                        'quantity'      => $data['quantity'],
                        'negotiated_amt' => $data['negotiated_amt'],
                        );
        $this->db->where('id', $data['cid']);
        return $this->db->update($this->name, $insert_array);
        
    }
    
    public function getDataByBookingId($bookingId) {

        /*if($bookingId != '') {
            $q = $this->db->query("SELECT
                                        *
                                   FROM 
                                        rent_booking_component
                                   WHERE 
                                        booking_id =".$bookingId."
                                ");
            $resultSet =  $q->result_array();
            return $resultSet;
        }*/

        
        if($bookingId != '') {
            $q = $this->db->query("SELECT
                                        a.id as bid,
                                        c.id as product_id,
                                        c.product_name as product_name, 
                                        a.quantity as quantity,
                                        a.rent_price as rent_price
                                   FROM 
                                        ".$this->name." as a, 
                                        rent_product as c
                                   WHERE 
                                        a.booking_id =".$bookingId."
                                   AND 
                                        a.product_id = c.id ORDER BY a.id");
            $resultSet =  $q->result_array();
            return $resultSet;
        }
        
    }
}