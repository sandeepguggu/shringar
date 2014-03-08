<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Scheme extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url'));
		if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
			redirect('login?error_msg=' . urlencode("Please Login"));
		}
		$this->ajax = false;
		$this->json = false;

		if ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) || isset($_REQUEST['tabs']) && $_REQUEST['tabs'] == 1) {
			$this->ajax = true;
		}
		if (isset($_REQUEST['json']) && $_REQUEST['json'] == 1) {
			$this->json = true;
		}
		$this->load->model('User', 'user');
		$this->load->model('scheme_model', 'sm');
		$this->load->library('datagrid', array('db' => &$this->db));
		$this->load->library('barcode', array());
		//$this->load->library('NumbertoWords');
		$this->load->helper('url_helper');
		$this->load->helper('form');
		$this->load->model('inventory_model', 'im');
		$this->load->model('item_entity_model','item_entity');
		$this->load->model('rate_model','rm');
		$this->load->model('scheme_invoice','si');
	}

	public function index()
	{
		// debugbreak();
		$d = array('output' => print_r($_SESSION, true));
		$this->_my_output('index', $d);
	}

	public function schemes()
	{
		// debugbreak();
		$fields = array("ID" => "id", "NAME" => "name", "INSTALLMENT" => "min_installment", "TERMS" => "terms", "DURATION" => "duration_months");
		$table = " `scheme` ";
		$where = " WHERE `delete` = '0' ";
		$actions = array(
			"EDIT" => array("url" => site_url('scheme/edit?ajax=1'), "css" => "btn primary fancybox"),
			"DELETE" => array("url" => site_url('scheme/delete?ajax=1'), "css" => "btn danger fancybox")
		);
		$orderby = " order by `id` ASC";
		$p = array();
		$p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
		$this->_my_output('schemes', $p);
	}

	public function subscribe()
	{
	//debugbreak();
		if (!empty($_POST))
		 {
			$data = $_POST;
			if(!empty($_POST['entity_id'])) 
				{ 
					$entity_id=$_POST['entity_id']; $specific_id=$_POST['specific_id'];
					$data['per_gram_rate']= $this->rm->getRate($entity_id,$specific_id);
				}
			$receipt['data'] =   $this->sm->subscribe($data);
			$receipt['data']['amt_in_words'] = $this->convert_number($receipt['data']['amt_paid']);
			$receipt['data']['total_in_words'] = $this->convert_number($receipt['data']['total']);
			$item_entity_id = $this->item_entity->getEntityId('scheme');
			$receipt['data']['barcode'] = $this->barcode->getBarcode($item_entity_id, $receipt['data']['scheme_user_id']);
			$params = array();
			$params['html']=$this->load->view('schemes/scheme_receipt',$receipt,true);
			$params['output']['dropdown'] = $this->sm->getschemes_dropdown();
			$params['tab']="enroll";
			$this->_my_output('subscribe', $params);
		   // $this->load->view('schemes/subscribe',$params);
		}                                                           
	   else 
	   {
			$output = array();
			$output['dropdown'] = $this->sm->getschemes_dropdown();
			$this->_my_output('subscribe', $output);
		}
	}
	public function scheme_users()
	{
		// debugbreak();
		$output = array();
		$output['dropdown'] = $this->sm->getschemes_dropdown();
		$this->_my_output('scheme_users', $output);
	}

	public function get_enrolled_customers()
	{
		// debugbreak();
		$scheme_id = $_GET['id'];
		$data['schemes'] = $this->sm->get_enrolled_customers($scheme_id);
		$p['html'] = $this->load->view('schemes/enrolled_customers', $data, true);
		$this->_my_output('scheme_users', $p);

	}
   
	function getscheme()
	{
		// debugbreak();
		$data['id'] = $_GET['id'];
		$data['d'] = $this->sm->getschemes_dropdown($data['id']);
		if(!empty($data['d']['rate_item_entity_id'])&& !empty($data['d']['rate_item_specific_id']))
		{
		list($entity,$specifics) = $this->item_entity->getItemSpecifics($data['d']['rate_item_entity_id'],$data['d']['rate_item_specific_id']);
		$data['d']['rate_item_entity_name']=$entity['display_name'];
		$data['d']['rate_item_specific_name'] =$specifics['name']." ( ".$specifics['type']." )"; 
		}
		$html = $this->load->view('schemes/table', $data, true);
		echo $html;
	}

	public function add()
	{
		//debugbreak();
		$p = array();
		$this->_my_output('add_scheme', $p);
	}
	public function get_item_type()
	{
	   $p['entities'] = $this->item_entity->getAllItemEntities();
	   $html ="<option value='0'>--SELECT--</option>";
	   foreach($p['entities'] as $e) {$html.="<option value='".$e['id']."'>".$e['display_name']."</option>";}
	   echo json_encode($html); 
	}
   public function get_item_name()
   {
	//debugbreak();
	   $entity_id = $_GET['id'];
	  list($html,$data) = $this->im->getProd_names($entity_id);
	   echo json_encode($html); 
   } 
	public function add_to_db()
	{
	   // debugbreak();
		$msg = $this->sm->add($_POST);
		$output = $this->load->view('schemes/add_scheme', $msg, true);
		$c['output'] = $output;
		$this->_my_output('schemes', $c);
	}

 /* public function edit()
  {
   debugbreak();
	$data['id'] = $_GET['id'];
	$data['scheme']= $this->sm->getById($data['id']);
	$html = $this->load->view('schemes/add_scheme',$data,true);
	  
	  
  }    */
	public function pay_installment()
	{
	  //debugbreak();
		if (!empty($_POST)) {
			$scheme_user_id = $_POST['scheme_user_id'];
			$data = $this->sm->getById($_POST['scheme_user_id']);
			$terms = $data['terms'];
		   // $last_paid_date = $data['last_paid_date'];
			$last_paid_date = date("Y-m-d");
			$installments_paid = $data['installments_paid'];
			$next_payment_date = $data['next_payment_date'];
			$paid_amount = $data['paid_amount'];
			$accumulated_quantity = $data['accumulated_quantity'];
			$total_installments = $data['duration_months'];
		if(!empty($_POST['entity_id'])) 
				{ 
					$entity_id=$_POST['entity_id']; $specific_id=$_POST['specific_id'];
					$per_gram_rate= $this->rm->getRate($entity_id,$specific_id);
				}
		   
			$paid_amt =$this->sm->submitPayment($scheme_user_id, $last_paid_date, $installments_paid, $next_payment_date, $paid_amount, $terms, $_POST,$per_gram_rate,$accumulated_quantity,$total_installments);
			$this->si->submitTransaction($scheme_user_id, $_POST, $data['customer_id'],$installments_paid+1,$paid_amt);
			//$receipt['data'] =   $this->sm->subscribe($data);
		}

		else
		{
			$p = array();
			$data['scheme'] = $this->sm->getById($_GET['id']);
			$this->_my_output('pay_installment', $data);
		}
	}
 public function transaction_report($json='',$date='',$page=0)
  {
// debugbreak();
	 if(!empty($date))
	 { 
		$repdate = $this->split_date($date);
		$count = count($this->sm->getReport($repdate,'',''));
		if($count >0){
		 $cnt   = $count;
		 $page_numbering = 1;
		 $offset   =  0;
		 $limit   = 10;
		 $cur_page   =  (isset($page) && $page > 0)?$page:1;
		 if(isset($page) && $page > 1){
		  $offset  = $limit * ($page - 1); 
		 }
		 if($cnt > $limit){
			   // Display Pagenumbering
			   $tmp  = $cnt / $limit;
			   $tmp_i  = intval($tmp);
			   $tmp_f  = $tmp - $tmp_i;
			   if($tmp_f > 0){
				$tmp_i++;
			   }
			   $pages  = $tmp_i;
			   $max_pages = $pages;
			   $max_pagination_indices  = 3;
			   $max_directional_limit  = floor($max_pagination_indices/2);
			   if(($pages - $cur_page) > $max_directional_limit){
				$pages = $cur_page + $max_directional_limit;
			   }
			   
			   $start_c = 1;
			   if(($cur_page - $max_directional_limit) > 0){
				$start_c = $cur_page - $max_directional_limit;
			   }else{
				$pages += (($cur_page - $max_directional_limit) * -1);
			   }
			   
			   if($pages > $max_pages){
				$pages = $max_pages;
			   }
			   $html  = '<div class="pagination" style="height:20px">';
			   $html  .= '<ul>';
			   if($cur_page <= 1){
				$html .= ' <li class="prev disabled"><a href="#">&larr; Previous</a></li>';
			   }else{
				$_GET['page']  = $cur_page - 1;
				$qs    = http_build_query($_GET);
				$html   .=' <li class="prev"><a  onclick=\'reportondate("'.urldecode($date).'","'.$_GET['page'].'")\'>&larr; Previous</a></li>';
				//$html .= ' <li class="prev"><a href="'.$_SERVER['PHP_SELF'].'?'.$qs.'">&larr; Previous</a></li>';
			   }
			   for($i=$start_c; $i<=$pages; $i++){
				$_GET['page']  = $i;
				$qs    = http_build_query($_GET);
				if($cur_page == $i){
				 $html .= '<li class="active"><a href="#">';
				 $html .= $i;
				 $html .= '</a></li>'; 
				}else{
				 
				 $html  .=  '<li style="display:inline;margin-left:5px;">';
				 $html .= '<a  onclick=\'reportondate("'.urldecode($date).'","'.$i.'")\'>'.$i.'</a>';
				 //$html .= '<a href="'.$_SERVER['PHP_SELF'].'?'.$qs.'">'.$i.'</a>';
				 $html  .=  '</li>';  
				}
			   }
			   
			   if($cur_page >= $pages){
				$html .= '<li class="next disabled"><a href="#">Next &rarr;</a></li>';
			   }else{
				$_GET['page']  = $cur_page + 1;
				$qs    = http_build_query($_GET);
				$html   .= ' <li class="next"><a  onclick=\'reportondate("'.urldecode($date).'","'.$_GET['page'].'")\'>Next &rarr;</a></li>'; 
				//$html .= ' <li class="next"><a href="'.$_SERVER['PHP_SELF'].'?'.$qs.'">Next &rarr;</a></li>';
			   }
			   $html .= '</ul>';
			   $html .= '</div>';
			  }
			 $data['pagination']     = (isset($html))?$html:'';
			 }
		
		$data['report'] = $this->sm->getReport($repdate,$limit,$offset);
		$data['offset']=$offset;
		//$data['links']= $this->pagination->create_links();
		$p['html'] = $this->load->view("schemes/transaction_report",$data,true);
		echo json_encode($p['html']);
	 }
   else   
		{
		$p = array();
		$this->_my_output('report', $p);
	   }
   } 

   function split_date($date)
	{
		$reportdate = explode("To",urldecode($date));
		if(!empty($reportdate[1])) { $frm = $reportdate[0]; $to = $reportdate[1];}
		else {$frm = $reportdate[0]; $to = date ('Y-m-d' , strtotime ( '+1 day' , strtotime ( $date ) )); }
		return array($frm,$to);
	}
   
   public function get_schemes_by_customer($cid='',$sid='')
	{
	  //  debugbreak();
		$data = $this->sm->getSchemesByCustomer($cid,$sid);
		echo json_encode($data);
	} 
 public function _my_output($file = 'index', $params = array())
	{
		if ($this->json == true) {
			//log_message('error', "bill params". print_r($params , 1));
			echo json_encode($params);
			//log_message('error', "COMING Bill");
			return;
		}

		if ($this->ajax === false) {
			//$p =array();
			//$p['header'] = $this->rate->getHeader();
			$this->load->view('header');
		}

		//$this->load->view('billing/'.$file, $params);
		$p = array();
		$p['tab'] = isset($params['tab']) ? $params['tab'] : $file;
		$p['ajax'] = $this->ajax;
		$p['output'] = $this->load->view('schemes/' . $file, $params, true);
		$this->load->view('schemes/index', $p);

		if ($this->ajax === false) {
			$this->load->view('footer');
		}
	}

 public function convert_number($number) 
  { 
	if (($number < 0) || ($number > 999999999)) 
	{ 
	throw new Exception("Number is out of range");
	} 

	$Gn = floor($number / 1000000);  /* Millions (giga) */ 
	$number -= $Gn * 1000000; 
	$kn = floor($number / 1000);     /* Thousands (kilo) */ 
	$number -= $kn * 1000; 
	$Hn = floor($number / 100);      /* Hundreds (hecto) */ 
	$number -= $Hn * 100; 
	$Dn = floor($number / 10);       /* Tens (deca) */ 
	$n = $number % 10;               /* Ones */ 

	$res = ""; 

	if ($Gn) 
	{ 
		$res .= $this->convert_number($Gn) . " Million"; 
	} 

	if ($kn) 
	{ 
		$res .= (empty($res) ? "" : " ") . 
			$this->convert_number($kn) . " Thousand"; 
	} 

	if ($Hn) 
	{ 
		$res .= (empty($res) ? "" : " ") . 
		   $this->convert_number($Hn) . " Hundred"; 
	} 

	$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
		"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
		"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
		"Nineteen"); 
	$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
		"Seventy", "Eigthy", "Ninety"); 

	if ($Dn || $n) 
	{ 
		if (!empty($res)) 
		{ 
			$res .= " and "; 
		} 

		if ($Dn < 2) 
		{ 
			$res .= $ones[$Dn * 10 + $n]; 
		} 
		else 
		{ 
			$res .= $tens[$Dn]; 

			if ($n) 
			{ 
				$res .= "-" . $ones[$n]; 
			} 
		} 
	} 

	if (empty($res)) 
	{ 
		$res = "zero"; 
	} 

	return $res; 
  } 

} 
 ?>
