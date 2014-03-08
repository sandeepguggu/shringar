<?php 
class Scheme_invoice extends CI_Model {
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

 function submitTransaction ($scheme_user_id,$transaction,$userid,$installment,$paid_amount)
 {
   //debugbreak();
	 if(empty($transaction['amt_card'])) { $transaction['amt_card']=0;}
	$total = $transaction['amt_cash'] + $transaction['amt_card'];
	$by_cash=(!empty($transaction['amt_cash']))?$transaction['amt_cash']:0; 
	$by_card=(!empty($transaction['amt_card']))?$transaction['amt_card']:0;
	 $cardno =(!empty($transaction['card_no']))?$transaction['card_no']:0;
	 $data = array(
	"scheme_user_id"=>$scheme_user_id,
	"amount"=>$total,
	"by_cash"=>$by_cash,
	"by_card"=>$by_card,
	"installment_number"=>$installment,
	"card_last_digits"=>$cardno,
	"flow"=>"in",
	"user_id"=>$userid,
	"paid_amount"=>$paid_amount
	);
  $this->db->insert("scheme_transaction",$data);
 $id = $this->db->insert_id();
 //$this->db->query("update scheme_transaction set paid_amount = paid_amount + ? where id = ?",array($total,$id));
 // $this->db->query("update scheme_transaction set installment_number = installment_number + 1 where id =?",$id);
 }
}
?>