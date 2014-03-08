<?php

/**
 * Description of job_sheet_model
 *
 * @author Sandeep
 */
class Job_sheet_issued_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function issue($user_id, $goldsmith_id, $job_sheet_date, $delivery_date, $payment_type, $payment_amt, $payment_percent, $payment_date, $status, $comments) {
        $p = array();
        
        $sql = "INSERT INTO `jobsheet_issued` (`user_id`, `goldsmith_id`, `created_at`, `jobsheet_date`, `delivery_date`, `payment_type`,  `payment_amt`, `payment_percent`, `payment_date`, `status`, `comments`) VALUES(?,?,NOW(),?,?,?,?,?,?,?,?)";
        $this->db->query($sql, array($user_id, $goldsmith_id, $job_sheet_date, $delivery_date, $payment_type, $payment_amt, $payment_percent, $payment_date, $status, $comments));
        if($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg']    = 'Error in Database ';
            return $p;
        }
        $p['status'] = true;
        $p['msg']    = 'Job Sheet is Successfully Issued';
        $p['id']     = $this->db->insert_id();
        return $p;
    }
    
    public function issueItem($job_sheet_issued_id, $item_entity_id, $item_specific_id, $quantity, $flow, $job_charge, $job_type, $branch_id, $user_id) {
        $p = array();
        
        $sql = "INSERT INTO `jobsheet_issued_item` (`jobsheet_issued_id`, `item_entity_id`, `item_specific_id`, `quantity`, `flow`, `job_charge`, `job_type`, `branch_id`, `user_id` ) VALUES(?,?,?,?,?,?,?,?,?)";
        $this->db->query($sql, array($job_sheet_issued_id, $item_entity_id, $item_specific_id, $quantity, $flow, $job_charge, $job_type, $branch_id, $user_id));
        if($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'The Issued Item is not added';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'The Issued item is successfully Added';
        return $p;
    }
    
}

?>
