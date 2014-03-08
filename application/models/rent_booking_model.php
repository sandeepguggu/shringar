<?php

class Rent_Booking_Model extends CI_Model {

    public function __construct() {
        $this->name = 'rent_booking';
        $this->load->database();
    }

    public function insert($data) {
        if ($data['delivery_date'] == '' || $data['noofdays'] == '' || $data['rent_amount'] == '') {
            return false;
        }
        $date = $data['delivery_date'];
        $q = $this->db->query("insert into ".$this->name." (`customer_id`,`delivery_date`,`noofdays`,`total_rent`,`deposit`,`balance`) values (?,STR_TO_DATE('$date', '%m/%d/%Y'),?,?,?,?)", array($data['cname'], $data['noofdays'], $data['rent_amount'], $data['deposit'], $data['balance'], $data['ordertype']));
        return $this->db->insert_id();
    }
    
    public function update($data) {

         $insert_array = array(
                        'delivery_date'     => $data['delivery_date'],
                        'noofdays'          => $data['noofdays'],
                        'total_rent'        => $data['rent_amount'],
                        'deposit'           => $data['deposit'],
                        'total_negotiation' => $data['total_negotiation'],
                        'bill_amount'        => $data['bill_total'],
                        'ordertype'         => $data['ordertype']
                        );
        $this->db->where('id', $data['bid']);
        return $this->db->update($this->name, $insert_array);
        
    }
	
    public function getDataById($bookingId,$type){
        if($bookingId != '') {
            $q = $this->db->query("SELECT * FROM ".$this->name." WHERE id =".$bookingId." AND ordertype = ".$type);
            $resultSet =  $q->row_array();
            return $resultSet;
        }
    }
    
    public function getAllBookings($id){
        if($id != '') {
            $q = $this->db->query("SELECT a.*,b.fname, b.lname 
                                   FROM 
                                        ".$this->name." as a,
                                        customers as b
                                   WHERE  
                                        a.ordertype = ".$id."
                                   AND
                                        a.customer_id = b.id");
            $resultSet =  $q->result_array();
            return $resultSet;
        }
        
    }
    
    public function getDataByDate($from, $to){
        $q = $this->db->query("SELECT sum(`total_rent`) as rent, sum(`total_negotiation`) as negotiatedAmt FROM ".$this->name." 
                                WHERE delivery_date BETWEEN 
                                    '$from[1]' 
                                AND '$to[1]' AND ordertype = 3");

        $resultSet[] =  $q->row_array();
        $p = $this->db->query("SELECT 
                                    sum(c.quantity) as cnt, 
                                    b.name as name, 
                                    sum(c.rent_price) as rent1,
                                    noofdays
                               FROM 
                                    rent_booking a, 
                                    rent_components b, 
                                    rent_booking_component c 
                               WHERE 
                                    delivery_date BETWEEN '$from[1]' AND '$to[1]' 
                               AND 
                                    a.id = c.booking_id 
                               AND 
                                    c.component_id = b.id 
                               AND 
                                    a.ordertype = 3 
                               GROUP BY 
                                    c.component_id");
        
        $resultSet[] =  $p->result_array();
        return $resultSet;
    }

}