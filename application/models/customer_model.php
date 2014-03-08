<?php
class Customer_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function suggest($keyword)
    {
        $keyword = mysql_real_escape_string($keyword);
        $sql = "select * from `customers` where `fname` like '%" . $keyword . "%' OR `lname` like '%" . $keyword . "%' OR `phone` like '%" . $keyword . "%' limit 10";
        $r = $this->db->query($sql);
        return $r->result_array();
    }

    public function getCustomerByPhone($phone)
    {
        $sql = "select * from `customers` where `phone` = ?";
        $r = $this->db->query($sql, array($phone));
        return $r->row_array();
    }
 public function get_walkin_customer()
  {
     $data =  $this->db->query("select id , fname from customers where id = 1");
     return $data->row_array(); 
  }
    public function add($fname, $lname, $dob, $sex, $phone, $email, $sms, $building, $street, $area, $city, $pin, $state, $user_id)
    {
        if ($fname == '') {
            return false;
        }
        $q = $this->db->query("insert into `customers` (`fname`,`lname`,`dob`,`sex`,`phone`,`email`,`sms`,`building`,`street`,`area`, `city`, `pin`, `state`, `user_id`) values (?, ?, STR_TO_DATE('$dob', '%m/%d/%Y'), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($fname, $lname, $sex, $phone, $email, $sms, $building, $street, $area, $city, $pin, $state, $user_id));
        return $this->db->insert_id();
    }

    public function update($id, $fname, $lname, $dob, $sex, $phone, $email, $sms, $building, $street, $area, $city, $pin, $state)
    {
        if ($id == '' || $fname == '' || $phone == '') {
            return false;
        }
        $q = $this->db->query("update `customers` set `fname` = ?, `lname` =?, `dob`= STR_TO_DATE('$dob', '%m/%d/%Y'), `sex`=?, `phone` =?, `email`=?, `sms`=?, `building`=?, `street`=?, `area` =?, `city` =?, `pin`=?, `state` =? WHERE `id` = ? ", array($fname, $lname, $sex, $phone, $email, $sms, $building, $street, $area, $city, $pin, $state, $id));
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
        $q = $this->db->query("select * from `customers` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("delete from `customers` where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `customers`");
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function setLoyaltyPoints($customer_id, $loyalty_points, $valid_to = '')
    {
        //TODO update query on customer table to add loyalty points and validity


    }
    public function addLoyaltyPoints($customer_id, $points){

    }

    public function getLoyaltyPoints($customer_id)
    {
        $q = $this->db->query("select `loyalty_points` from `customers` WHERE `id` = ?", array($customer_id));
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return false;
    }

    public function getLoyaltyAmount($customer_id)
    {
        $q = $this->db->query("select `loyalty_points`, `loyalty_points_valid_till` from `customers` WHERE `id` = ?", array($customer_id));
        if ($q->num_rows() > 0) {
            $a = $q->row_array();
        }else{
            return 0;
        }
        $loyalty_points = $a['loyalty_points'];
        $config = $this->db->query("select * FROM `customer_loyalty_config` WHERE `name` = ?", array('loyalty'));
        if ($config->num_rows() > 0) {
            $c = $config->row_array();
        }
        // load configuration from customer_loyalty_config
        //get points from customer table

        //TODO later check validity
        $amount = ($c['value_rupees'] / $c['points']) * $loyalty_points;
        //apply conversion and return the value
        return $amount;
    }
    public function redeemLoyaltyAmount($customer_id, $amount = ''){
        //this function will redeem specific amount or the whole and return the amount
        if($amount == ''){
            $this->getLoyaltyAmount($customer_id);
            $this->setLoyaltyPoints($customer_id, 0);
        }else{
            //convert the amount into loyalty points and subtract that many from customer loyalty points
        }

    }
}