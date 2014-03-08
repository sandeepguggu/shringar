<?php
class Bill_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function create($user_id, $paid_cash, $paid_card, $paid_scheme, $customer_id, $discount_type, $discount_value, $vat_amount, $total_amount, $final_amount, $status, $full_json)
    {
        $sql = "insert into `bill` (`user_id`, `paid_by_cash`, `paid_by_card`, `paid_by_scheme`, `customer_id`, `discount_type`, `discount_value`, `vat_amount`, `total_amount`, `final_amount`, `status`, `full_json`)" .
        " values (?,?,?,?,?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($user_id, $paid_cash, $paid_card, $paid_scheme, $customer_id, $discount_type, $discount_value, $vat_amount, $total_amount, $final_amount, $status, $full_json));
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function add_item($bill_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $vat, $discount, $final_amount)
    {
        $sql = "insert into `bill_items`(`bill_id`, `item_entity_id`, `item_specific_id`, `quantity`, `weight`, `price`, `vat`, `discount`, `final_amount`) values (?,?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($bill_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $vat, $discount, $final_amount));
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `bill` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function getItems($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `bill_items` where `bill_id` = ?", array($id));
        return $q->result_array();
    }

    public function getByItemID($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `bill_items` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("delete from `bill` where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function deleteByBillId($id)
    {
        $q = $this->db->query("update `bill` set `exchange`=1 where `id` = ?", array($id));
        if ($this->db->affected_rows() <= 0) 
            return false;
        $q = $this->db->query("update `bill_items` set `exchange`=1 where `bill_id` = ?", array($id));
        if ($this->db->affected_rows() <= 0) 
            return false;
        return $r;
    }

    public function getlatestbillid()
    {

        $data = $this->db->query("select id from bill order by id DESC LIMIT 1");
        $id = $data->row_array();
        return $id['id']; 
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `bill`");
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function latestInvoices() {
        $sql = "SELECT b.*, CONCAT(`c`.`fname`,' ', `c`.`lname`) c_name , `c`.`phone` c_phone from `customers` c, `bill` b
        WHERE `c`.`id` = `b`.`customer_id` ORDER BY b.created_at DESC LIMIT 0, 20 ";            

        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function suggest($term)
    {
        if ($term == '') {
            return false;
        }
        $sql = "SELECT b.*, CONCAT(`c`.`fname`,' ', `c`.`lname`) c_name , `c`.`phone` c_phone from `customers` c, `bill` b
        WHERE  
        `c`.`id` = `b`.`customer_id` 
        AND 
        `b`.`id` ='".trim($term)."'";

        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function createCreditNote($bill_id, $user_id, $amount = 0, $parent_id = 0, $full_json)
    {
        $sql = "INSERT INTO credit_note (user_id, refund_bill_id, amount, parent_id, full_json)
        VALUES ('{$user_id}', '{$bill_id}', '{$amount}', '{$parent_id}', '{$full_json}')";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function addItemToCreditNote($credit_note_id, $item_entity_id, $item_specific_id, $quantity, $price, $vat, $discount, $final_amount)
    {
        $sql = "insert into `credit_note_item`(`credit_note_id`, `item_entity_id`, `item_specific_id`, `quantity`, `price`, `vat`, `discount`, `final_amount`) values (?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($credit_note_id, $item_entity_id, $item_specific_id, $quantity, $price, $vat, $discount, $final_amount));
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function useCreditNote($id, $bill_id, $amount)
    {
        $sql = "UPDATE credit_note SET used='1', used_bill_id='{$bill_id}', used_amount='{$amount}'
        WHERE id='{$id}'";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function redeemCreditNote($credit_note_id, $bill_id)
    {
        $amount = $this->getCreditNoteAmount($credit_note_id);
        if ($amount > 0) {
            $this->useCreditNote($credit_note_id, $bill_id, $amount);
        }
        return $amount;
    }

    public function getCreditNoteAmount($credit_note_id)
    {
        $this->db->select('amount, used_amount');
        $amount = $this->db->get_where('credit_note', array('id' => $credit_note_id))->row_array();
        $amount = $amount['amount'] - $amount['used_amount'];
        return $amount;
    }

    public function updateItemCreditNote($bill_id, $item_id, $returned_qty = 0)
    {
        $sql = "UPDATE bill_items SET `returned_qty` = {$returned_qty}
        WHERE id='{$item_id}' AND bill_id='{$bill_id}'";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getDetailsByCreditID($credit_note_id)
    {
        $sql = "SELECT *
        FROM  credit_note
        LEFT JOIN bill ON credit_note.refund_bill_id = bill.id
        WHERE credit_note.id = '{$credit_note_id}'
        LIMIT 0 , 30";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return '';
        }
    }

    public function getCreditNote($credit_note_id)
    {
        $sql = "SELECT *
        FROM  credit_note
        WHERE credit_note.id = '{$credit_note_id}'
        LIMIT 0 , 30";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return '';
        }
    }

    public function finalizeCreditNote($id, $amount, $manager_user_id = 0, $full_json = '')
    {
        $update_data = compact('amount', 'manager_user_id', 'full_json');
        $this->db->where('id', $id);
        $this->db->update('credit_note', $update_data);
        return $id;
    }

    public function invoiceReport($date)
    {
        $data = $this->db->query("select a.*,b.fname,b.lname  from bill a
        LEFT JOIN customers b on a.customer_id = b.id 
        where a.created_at >= ? and a.created_at < ?",
        array($date[0], $date[1]))->result_array();
        return $data;
    }

    public function getBillItemsByBillId($id) {
        $sql = "SELECT `bill_items`.`id` as id, `products_description`.`name` as name, `class`.`name` as class, `brand`.`name` as brand, `bill_items`.`final_amount` as amount, `bill_items`.`quantity`, `bill_items`.`returned_qty`  FROM 
        `bill_items` LEFT JOIN `product_sku` ON `bill_items`.`item_specific_id` = `product_sku`.`id` 
        LEFT JOIN `product_header` ON `product_sku`.`header_id` = `product_header`.`id` 
        LEFT JOIN `products_description` ON `product_header`.`product_desc_id` =  `products_description`.`id` 
        LEFT JOIN `class` ON  `class`.`id` = `product_header`.`class_id` 
        LEFT JOIN brand on `brand`.`id` = `product_header`.`brand_id` 
        WHERE `bill_items`.`bill_id` = ? ";
        $data = $this->db->query($sql,array($id));

        if($data->num_rows() > 0)
        {
            return $data->result_array();

        }
        return false;
    }

    public function getBillItemsByBillId2($id) {
        $sql = "SELECT `bill_items`.`id` as id, `products_description`.`name` as name, `class`.`name` as class, `brand`.`name` as brand, `bill_items`.`final_amount` as amount  FROM 
        `bill_items` LEFT JOIN `product_sku` ON `bill_items`.`item_specific_id` = `product_sku`.`id` 
        LEFT JOIN `product_header` ON `product_sku`.`header_id` = `product_header`.`id` 
        LEFT JOIN `products_description` ON `product_header`.`product_desc_id` =  `products_description`.`id` 
        LEFT JOIN `class` ON  `class`.`id` = `product_header`.`class_id` 
        LEFT JOIN brand on `brand`.`id` = `product_header`.`brand_id` 
        WHERE `bill_items`.`bill_id` = ? AND `bill_items`.`exchange` = 0 ";
        $data = $this->db->query($sql,array($id));

        if($data->num_rows() > 0)
        {
            return $data->result_array();

        }
        return false;
    }

    public function getAllBillItems($from = '', $to = '', $limit = 0, $start = 0) {
        $sql = "SELECT b.id, b.created_at, b.total_amount FROM bill b";

        if(($from != '') AND ($to != ''))
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) ";

        if($limit != 0)
            $sql .= " LIMIT ?, ?";



        $data = $this->db->query($sql, array($start, $limit));
        if($data->num_rows() > 0) {        
            return $data->result_array();
        }

        return false;                
    }


    public function getTotalAmountForVatReport($from = '', $to = '')   {
        $sql = "SELECT SUM(b.final_amount) as amount FROM bill b";

        if(($from != '') AND ($to != ''))
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) ";

        $res = $this->db->query($sql);

        if(!$res->num_rows())
            return false;

        $res = $res->row_array();
        return $res['amount'];
    }


    public function countBillItemsByBrandId ($from = '', $to = '', $brand_id = 0) {

        $sql = "SELECT count(*) `cnt` FROM 
        bill b LEFT JOIN bill_items bi ON b.id = bi.bill_id
        LEFT JOIN product_sku ps ON bi.item_specific_id = ps.id
        LEFT JOIN product_header ph ON ps.header_id = ph.id
        LEFT JOIN products_description pd ON ph.product_desc_id = pd.id                        
        LEFT JOIN brand br ON ph.brand_id = br.id";

        if(($from != '') AND ($to != '') AND ($brand_id == 0)) //only dates are set
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) ";  
        elseif(($from == '') AND  ($to == '') AND ($brand_id != 0)) //only brand is set
            $sql .= " WHERE br.id = '".$brand_id."'";
        else
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) AND  br.id = '".$brand_id."'";   //both dates and brand are set

        $data = $this->db->query($sql);

        if($data->num_rows() > 0) {        
            return $data->row_array();
        }

        return false;                
    }


    public function getTotalAmountForBrandSalesReport($from, $to, $brand_id) {

        $sql = "SELECT SUM(bi.final_amount) AS total_amount, SUM(bi.quantity) AS total_quantity, SUM(bi.vat) AS total_vat FROM 
        bill b LEFT JOIN bill_items bi ON b.id = bi.bill_id
        LEFT JOIN product_sku ps ON bi.item_specific_id = ps.id
        LEFT JOIN product_header ph ON ps.header_id = ph.id
        LEFT JOIN products_description pd ON ph.product_desc_id = pd.id                        
        LEFT JOIN brand br ON ph.brand_id = br.id";

        if(($from != '') AND ($to != '') AND ($brand_id == 0)) //only dates are set
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) ";  
        elseif(($from == '') AND  ($to == '') AND ($brand_id != 0)) //only brand is set
            $sql .= " WHERE br.id = '".$brand_id."'";
        else
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) AND  br.id = '".$brand_id."'";   //both dates and brand are set

        $data = $this->db->query($sql);

        if(!$data->num_rows()) {        
            return false;
        }

        return $data->row_array();

    }


    public function getAllBillItemsByBrandId($from, $to, $brand_id = 0, $limit = 0, $start = 0) {
        $sql = "SELECT  bi.id, b.created_at,  pd.name as product_name, br.name as brand_name, bi.quantity, bi.final_amount, bi.vat FROM 
        bill b LEFT JOIN bill_items bi ON b.id = bi.bill_id
        LEFT JOIN product_sku ps ON bi.item_specific_id = ps.id
        LEFT JOIN product_header ph ON ps.header_id = ph.id
        LEFT JOIN products_description pd ON ph.product_desc_id = pd.id                        
        LEFT JOIN brand br ON ph.brand_id = br.id";

        if(($from != '') AND ($to != '') AND ($brand_id == 0)) //only dates are set
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) ";  
        elseif(($from == '') AND  ($to == '') AND ($brand_id != 0)) //only brand is set
            $sql .= " WHERE br.id = '".$brand_id."'";
        else
            $sql .= " WHERE ( b.created_at BETWEEN '".$from."' AND '".$to."' ) AND  br.id = '".$brand_id."'";   //both dates and brand are set



        $sql .= " ORDER BY bi.id ASC ";

        if($limit != 0)
            $sql .= " LIMIT ".$start. ", ".$limit;   

        //echo $sql;    

        $data = $this->db->query($sql);

        if($data->num_rows() > 0) {        
            return $data->result_array();
        }

        return false;         
    }

    public function getBillItemIds($id) {
        $sql = "Select id from bill_items WHERE bill_id = ?";
        $res = $this->db->query($sql, array($id));
        return $res->result_array();
    }

    public function getVatPercentage($id) {        
        $sql = "SELECT ct.vat_percentage, b.final_amount FROM 
        bill_items b LEFT JOIN product_sku ps ON b.item_specific_id = ps.id 
        LEFT JOIN product_header ph ON ps.header_id = ph.id 
        LEFT JOIN category ct ON ph.tax_category_id = ct.id WHERE b.id = ? ";
        $res = $this->db->query($sql, array($id));
        if(!$res->num_rows()) 
            return false;

        return $res->row_array();

    }


    public function getBillItemsInfo($id) {
        $sql = "SELECT b.id as id, pd.name as name, b.final_amount as final_amount, br.name as brand, cl.name as class, ct.vat_percentage as vat_percentage, b.vat as vat, (b.final_amount - b.vat) as gross_sale FROM
        bill_items b LEFT JOIN product_sku ps ON b.item_specific_id = ps.id
        LEFT JOIN product_header ph ON ps.header_id = ph.id
        LEFT JOIN products_description pd ON ph.product_desc_id = pd.id
        LEFT JOIN class cl ON ph.class_id = cl.id
        LEFT JOIN brand br ON ph.brand_id = br.id
        LEFT JOIN category ct ON ph.tax_category_id = ct.id
        WHERE b.bill_id = ?";

        $data = $this->db->query($sql,array($id));

        if(!$data->num_rows() > 0) {
            return false;
        }
        return $data->result_array();
    }

    public function record_count() {
        return $this->db->count_all('bill');
    }
    public function getTotalCountonSales($from , $to)
    {
        $where = '';
        if(!empty($from))
        {
            $where.="created_at >= '".$from."'";
        }
        if(!empty($to))
        {
            if(!empty($where))
            {
                $where.=" AND ";
            }
            $where.="created_at <= '".$to."'";
        }
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $this->db->select('id');
        $data = count($this->db->get('bill')->result_array());
        return $data;
    }
    public function getVatReport($from , $to , $limit ='' , $offset='')
    {
        $this->load->model('category_model','category'); 
        //debugbreak();
        $p = array();
        $where ="";
        if(!empty($from))
        {
            $where.="b.created_at >= '".$from."'";
        }

        if(!empty($to))
        {
            if(!empty($where))
            {
                $where.=" AND ";
            }
            $where.="b.created_at <= '".$to."'"; 
        }
        //  debugbreak();
        $vat_percentages = $this->category->getAllvatpercentages();
        $vat_percentages[sizeof($vat_percentages)]['vat_percentage'] = 0;
        if(!empty($where))
        {
            $this->db->where($where);
        }
        if(!empty($limit) || !empty($offset))
        {
            $this->db->limit($limit , $offset);
        }
        $this->db->select("b.id as bill_id ,b.created_at, b.total_amount as vat_inclusive_amount");
        $bill = $this->db->get('bill b');

        if($bill->num_rows() > 0)
        {
            $bill = $bill->result_array();
            $bill_items = array();
            foreach($bill as &$b)
            {
                $bill_items_data = $this->db->query("select b.price as unit_price , b.quantity , LTRIM(c.vat_percentage) as vat_percentage,ph.tax_category_id from bill_items b LEFT JOIN product_sku ps on ps.id = b.item_specific_id LEFT JOIN product_header ph on ph.id = ps.header_id LEFT JOIN category c on c.id = ph.tax_category_id where b.bill_id = ?",array($b['bill_id']))->result_array();

                //  debugbreak();
                foreach($vat_percentages as $vat)
                {
                    if($vat['vat_percentage'] > 0)
                    {
                        $b['gross_sales @'.trim($vat['vat_percentage'])] = 0;
                        $b['vat @'.trim($vat['vat_percentage'])] = 0;
                    }
                    else
                    {
                        $b['exempted'] = 0;
                    }
                }
                foreach($bill_items_data as $bid)
                {
                    if($bid['vat_percentage'] > 0)
                    {
                        $vat_exclusive_amt = 0;
                        $vat_exclusive_amt = round(($bid['unit_price'] * 100) / (100 + $bid['vat_percentage']));

                        $b['gross_sales @'.$bid['vat_percentage']] +=  round( (($bid['unit_price'] * 100) / (100 + $bid['vat_percentage'])) * $bid['quantity'],2 );    
                        $b['vat @'.$bid['vat_percentage']] += round( (($bid['vat_percentage'] * $vat_exclusive_amt)/100) * $bid['quantity'] ,2 );
                    }
                    else{
                        $b['exempted'] += $bid['unit_price'] * $bid['quantity'];
                    }
                }
            }
        }
        else{
            $p['status'] = false; 
            $p['msg'] = "No bill found between the selected date range";
            return $p;
        }
        $p['bill'] = $bill;
        $p['vat_percentages'] = $vat_percentages;
        return $p;
    }
    public function getAmountPaidforBill($id)
    {
           $data = $this->db->query("select paid_by_cash , paid_by_card , final_amount as total_amount from bill where id = ?",array($id))->row_array();
           return $data;
    }
    public function submitSplitBill($id , $card , $cash)
    {
            // $this->db->query("update bill set paid_by_cash = ? and paid_by_card = ? where id = ?",array($cash , $card , $id));
      $data = array("paid_by_cash"=>$cash,
                           "paid_by_card"=>$card
                           );
      $this->db->where('id',$id);
      $this->db->update('bill',$data);
    }
}
