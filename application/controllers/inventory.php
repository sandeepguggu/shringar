<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Inventory extends CI_Controller
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
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('item_entity_model', 'item_entity');
        $this->load->model('rate_model', 'rate');
        $this->load->helper('form');
        $this->load->library('barcode', array());
        $this->load->model('class_Model', 'class');
        $this->load->model('category_Model', 'category');
        $this->load->model('Product_header_Model', 'product_header');
        $this->load->model('product_sku_model', 'product_sku');
        $this->load->model('brand_model', 'brand');
        $this->load->library('productLib', array());
        $this->load->model('manage_users_model', 'manageUsers');
        $this->load->model('category_model', 'category');
        $this->load->helper('url');
        //$this->load->helper(array('dompdf', 'file'));
    }

    public function index()
    {
        $d = array('output' => print_r($_SESSION, true));
        //$this->_my_output('index', $d);
        $this->stock();
    }

    function stock($class_id = 0, $item_entity_id = 26)
    {
        $sub_classes = $this->class->getAllSubClasses($class_id);
        foreach ($sub_classes as &$sub_class) {
            $sub_class['stock'] = $this->inventory->getClassSpecificStock($sub_class['id'], $item_entity_id);
            if (is_null($sub_class['stock'])) {
                $sub_class['stock'] = 0;
            }
        }
        $stocked_classes = $this->class->accumulateStock($sub_classes, 'ASC');
        // echo json_encode($stocked_classes);exit;
        $stocked_tree = $this->class->getClassTree($class_id, $stocked_classes);
        $params = array();
        $params['tab'] = 'inventory_stock';
        $params['class_tree'] = $stocked_tree;
        $params['display_root'] = $class_id;
        $params['parents'] = $this->class->getParents($class_id);
        $brands = $this->brand->getAll();
        $params['brands'] = $brands;
        $this->_my_output('stock', $params);
    }

    public function stock_grid($class_id = 0, $item_entity_id = 26)
    {
        $p = array();
        $brand_id = isset($_REQUEST['brand_id']) ? $_REQUEST['brand_id'] : 0;
        $destination = isset($_REQUEST['destination']) ? $_REQUEST['destination'] : '';
        $classes = $this->class->getAllSubClasses($class_id, 0);
        $id_string = $classes[0];
        $p['parents'] = $this->class->getParents($class_id);
        foreach ($classes as $class_id) {
            $id_string .= ', ' . $class_id;
        }
        $this->load->library('datagrid', array('db' => &$this->db));
        /*        $q = $this->db->query("SELECT SUM(cs.quantity) AS stock, (SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)) AS value FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND  ps.header_id = ph.id GROUP BY ph.brand_id", array($item_entity_id));*/
        $fields = array("ID" => "b.id as id", "BRAND NAME" => "b.name AS name", "QUANTITY" => "ROUND(SUM(cs.quantity), 3) AS Quantity", "MRP VALUE" => "ROUND((SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)), 2) AS mrp_value");
        $table = " central_stock cs, product_sku ps, product_header ph, products_description pd, class cl, brand b ";
        $where = " WHERE cs.`item_entity_id` = {$item_entity_id} AND cs.item_specific_id = ps.id AND ps.`header_id` = ph.`id` AND ph.`product_desc_id` = pd.`id` AND ph.`class_id` = cl.id AND cl.id IN ({$id_string}) AND ph.brand_id = b.id";
        if ($brand_id != 0) {
            $where .= ' AND ph.brand_id = ' . $brand_id;
        }
        $where .= ' GROUP BY b.id ';
        $actions = array();
        /*
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('brand/view_brand?ajax=1'), "css" => "btn btn-primary fancybox action-btn")
        );
        */
        $orderby = " ORDER BY b.name ASC";
        $p['name'] = 'Test';
        $config = array();
        if ($destination != '') {
            $config['destination'] = $destination;
        }
        $config['checkbox'] = 0;
        $config['count_distinct'] = 'b.id';
        $config['excel'] = 0;
        $config['total'] = array('Total Quantity' => 'Quantity', 'Total MRP Value' => 'mrp_value');
        //$config['total_display'] = array('total_mrp' => 'Total MRP Value', 'total_quantity' => 'Total Quantity');
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 20, 1, $config);
        echo json_encode($p);
    }

    function displayInventory()
    {
        //debugbreak();
        $p['dropdown'] = $this->item_entity->getEntityById($_GET['id']);
        $d['editprice'] = $d['barcode'] = 0;
        $where = "";
        $where = "a.item_entity_id =" . $this->input->get('id');
        list($p['count'], $d['inventory']) = $this->inventory->getInventory($where, '', '');
        $i = 0;
        $op_id = $this->item_entity->getEntityId('ornament_product');
        if ($_GET['id'] != $op_id) {
            foreach ($d['inventory'] as $inv) {
                $type = $inv['name'];
                $d['inventory'][$i][$type]['rate'] = $this->rate->getRate($inv['item_entity_id'], $inv['item_specific_id']);
                $i++;
            }
            $d['editprice'] = 1;
            $d['barcode'] = 0;
        } else {
            foreach ($d['inventory'] as $inv) {
                $d['inventory'][$i]['barcode'] = $this->barcode->getBarcode($inv['item_entity_id'], $inv['item_specific_id']);
                $i++;
            }
            $d['barcode'] = 1;
        }
        $d['srch'] = 0;
        $p['html'] = $this->load->view('inventory/inventory', $d, true);
        $this->_my_output('index', $p);
    }

    public function delete()
    {
        //   debugbreak();
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this->_my_output('error', $p);
            return;
        }
        $r = $this->inventory->deleteById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->output('error', $p);
            return;
        }
        $p['msg'] = "Successfully Deleted, Record Id " . $r['id'];
        $this->output('success', $p);
    }

    public function output($file = 'index', $params = array())
    {
        //  debugbreak();
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $this->load->view('inventory/' . $file, $params);
    }

    function search()
    {
        //debugbreak();
        $p = $d = array();
        $p['dropdown'] = $this->item_entity->getEntityById($_GET['id']);
        //$where = "id ='".$_GET['id']."'";
        $tbl = $this->item_entity->getEntityById($_GET['id']);
        $d['inventory'] = $this->inventory->search($_GET, $tbl['name']);
        $i = 0;
        foreach ($d['inventory'] as $inv) {
            $type = $inv['name'];
            $d['inventory'][$i][$type]['rate'] = $this->rate->getRate($inv['item_entity_id'], $inv['item_specific_id']);
            $i++;
        }
        $d['srch'] = 1;
        // $d['editprice'] =0;
        if ($p['dropdown']['name'] == "metal" || $p['dropdown']['name'] == "stone") {
            $d['editprice'] = 1;
            $d['barcode'] = 0;
        } else {
            $d['editprice'] = 0;
            $d['barcode'] = 1;
        }
        $p['html'] = $this->load->view('inventory/inventory', $d, true);
        $this->_my_output('index', $p);
    }

    function price()
    {
        if (!empty($_POST)) {
            $this->inventory->price($_POST);
            redirect(site_url() . "/inventory/index");
            } else {
            $data['pricedetails'] = $this->inventory->price($_GET);
            $this->load->view("inventory/editprice", $data);
        }
    }

  /*  public function vat_report($page = 0) {

        $to = '';
        $from = '';

        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = site_url('inventory/vat_report');
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;        
        
 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    
        // get distinct vat_percentages as an array 
        $result = $this->category->getAllvatpercentages();
        $vat_percentages = array();
        foreach($result as $record) {
            array_push($vat_percentages, $record['vat_percentage']);
        } 

      if (isset($_REQUEST['reports_date_from']) && trim($_REQUEST['reports_date_from']) != '') {
               // input string will be something like 06/13/2012 04:06
             $from = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_from'])));         
        }
        if (isset($_REQUEST['reports_date_to']) && trim($_REQUEST['reports_date_to']) != '') {
             $to = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_to'])));           
        } 



        $config['total_rows'] = count($this->bill->getAllBillItems($from, $to));
        $this->pagination->initialize($config);

        $total_amount  = $this->bill->getTotalAmountForVatReport($from, $to);

       $bills = $this->bill->getAllBillItems($from, $to, $config['per_page'], ($page + 0));       
       $p['links'] = $this->pagination->create_links();

       if(!$bills) {
            $p['vat_report'] = 'No Records';
       } else {   

            // calculating vat and gross sales for each bill
            foreach($bills as $i => $bill) {
                foreach($vat_percentages as $vat) {
                    $bill['gross sales @ '.$vat] = 0.00;
                    $bill['vat @ '.$vat] = 0.00;
                    $gross_sales[$vat] = isset($gross_sales[$vat]) ? $gross_sales[$vat] : 0.00;
                    $vat_amount[$vat] = isset($vat_amount[$vat]) ? $vat_amount[$vat] : 0.00;
                }  

                $bill_item_ids = $this->bill->getBillItemIds($bill['id']);                   
                foreach ($bill_item_ids as $key => $value) {                    
                    $bill_item = $this->bill->getVatPercentage($value['id']);                                                       

                    if(in_array($bill_item['vat_percentage'], $vat_percentages)) {
                        $gross_sale = ((100 - $bill_item['vat_percentage']) / 100 ) * $bill_item['final_amount'];                        
                        $vat = ($bill_item['vat_percentage'] / 100) * $bill_item['final_amount']; 
                        $gross_sales[$bill_item['vat_percentage']] += $gross_sale;
                        $vat_amount[$bill_item['vat_percentage']] += $vat;                                              
                        $bill['gross sales @ '.$bill_item['vat_percentage']] += $gross_sale;
                        $bill['vat @ '.$bill_item['vat_percentage']] += $vat;
                    }                    
                }

                $bills[$i] = $bill;                  
            } 

            $p['vat_report'] = $bills;                
        }

       // print_r($p);
       // die();
        $p['gross_sales'] = $gross_sales;
        $p['vat_amount'] = $vat_amount;
        $p['total_amount'] = $total_amount;
        $p['total'] = $config['total_rows'];
        $p['tab'] = 'vat_report';        
        $p['vat_percentages'] = $vat_percentages;
        $this->_my_output('vat_report', $p);      

    } */

    /* public function get_vat_excel_report() {

            $to = '';
            $from = '';
        
            // get distinct vat_percentages as an array 
            $result = $this->category->getAllvatpercentages();
            $vat_percentages = array();
            foreach($result as $record) {
                array_push($vat_percentages, $record['vat_percentage']);
            } 

           if (isset($_REQUEST['reports_date_from']) && trim($_REQUEST['reports_date_from']) != '') {
               // input string will be something like 06/13/2012 04:06
              $from = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_from'])));         
            }
            if (isset($_REQUEST['reports_date_to']) && trim($_REQUEST['reports_date_to']) != '') {
                 $to = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_to'])));           
            } 

            $bills = $this->bill->getAllBillItems($from, $to);    
            $total_amount  = $this->bill->getTotalAmountForVatReport($from, $to);
   

            // calculating vat and gross sales for each bill
            foreach($bills as $i => $bill) {
                foreach($vat_percentages as $vat) {
                    $bill['gross sales @ '.$vat] = 0.00;
                    $bill['vat @ '.$vat] = 0.00;   
                }  

                $bill_item_ids = $this->bill->getBillItemIds($bill['id']);                   
                foreach ($bill_item_ids as $key => $value) {
                    $bill_item = $this->bill->getVatPercentage($value['id']);                                                      
                                   
                    if(in_array($bill_item['vat_percentage'], $vat_percentages)) {
                        $gross_sale = ((100 - $bill_item['vat_percentage']) / 100 ) * $bill_item['final_amount'];                        
                        $vat = ($bill_item['vat_percentage'] / 100) * $bill_item['final_amount'];                                               
                        $bill['gross sales @ '.$bill_item['vat_percentage']] += $gross_sale;
                         $bill['vat @ '.$bill_item['vat_percentage']] += $vat;
                    }                    
                }

                $bills[$i] = $bill;                  
            }  

            $file_name = "vat ";  
            $headers = array("BILL NO / REF NO", "DATE", "TOTAL SALES");                 
            foreach($vat_percentages as $vat) {
                $gross_sale = "GROSS SALES @ ".$vat;
                $gross_vat = "VAT @ ".$vat;
                array_push($headers, $gross_sale);
                array_push($headers, $gross_vat);
            }

            $this->export_vat_report_to_excel($file_name, $headers, $bills, $total_amount);

    } */
 
   /* public function export_vat_report_to_excel($file_name, $headers, $data, $total_amount) {

            $this->load->library('PHPExcel');
            $this->load->library('PHPExcel/PHPExcel_IOFactory');
            $objExcel = new PHPExcel();
            $objExcel->setActiveSheetIndex(0);
            $sheet = $objExcel->getActiveSheet();
            $i = 0;
            $result = array();
            foreach ($data as $res) {
                $result[$i] = $res;
                $i++;
            }
            if ($result) {
                $is_header_set = true;
                $body_cells_start_index = ($is_header_set) ? 3 : 2;
                //TODO - to make it generic, need to make this configurable
                $sheet->setCellValue("A1", "Total Sales =" . $total_amount);
                //$sheet->setCellValue("C1", "Closing Stock =" . $data[sizeof($data) - 1]['Quantity']);
                if ($is_header_set && isset($headers) && is_array($headers) && count($headers)) {
                    $index = 2;
                    $start_column = 'A';
                    foreach ($headers as $key => $header)
                        $sheet->setCellValue(chr(ord($start_column) + $key) . "$index", $header);
                }
                $values = $result;
                foreach ($values as $row_key => $row) {
                    $key_index = 0;
                    $count_row = count($row);
                    foreach ($row as $key => $value) {
                        $sheet->setCellValue(chr(ord($start_column) + $key_index) . ($row_key + $body_cells_start_index), $value);
                        $key_index++;
                    }
                    $last = $row_key + $body_cells_start_index;
                }
                ob_end_clean();
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="' . $file_name . "report.xls");
                header('Cache-Control: max-age=0');                
                $objWriter = PHPExcel_IOFactory::createWriter($objExcel, "Excel5");
                $objWriter->save('php://output');
            } else {
                echo "No Records to Export";
            }
            /************************************************
            configuration object :
             *
             * $summary = true/false
             * summary_row = first/last
             * summary [] = {0 =>{value = 'quantity', $data_row => '1'},
             * {value= 'closing stock', $data_row = 0}}
             *************************************************/
        //    return;
   // }

   /* public function vat_report_index() {
        $p = array();       
        $p['tab'] = 'vat_report';
        $this->_my_output('vat_report', $p);   
    }*/
  public function sales_report_index()
  {
         $p = array();      
        $p['tab'] = 'sales_report';
        $this->_my_output('sales_report', $p);   
  }
    public function sales_report() {       
      
       //loading the datagrid library
       $this->load->library('datagrid', array('db' => &$this->db));

        $fields = array("DATE OF SALES" => "bill.created_at as date", "BILL NO / REF NO" => "bill.id as id", "CUSTOMER NAME" => "users.name as name", "AMOUNT" => "bill.final_amount AS amount" , 
            "CASH SALES" => "bill.paid_by_cash as cash", "CREDIT CARD SALES" => "bill.paid_by_card as card", "TOTAL VAT" => "bill.vat_amount as vat");
           
        $table = " `bill` bill , `users` users";
        $where = " WHERE bill.`user_id` = users.`id` ";//" AND bill.`exchange`=0 ";
     
        if (isset($_REQUEST['from']) && trim($_REQUEST['from']) != '') {
            // input string will be something like 06/13/2012 04:06

          $mysql_date = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['from'])));
          $where .= ' AND bill.created_at >=\'' . $mysql_date . '\'';
        }
        if (isset($_REQUEST['to']) && trim($_REQUEST['to']) != '') {
             $mysql_date = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['to'])));
            $where .= ' AND bill.created_at <=\'' . $mysql_date . '\'';
        }
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('billing/get_bill_items_by_id?ajax=1'), "css" => "btn btn-primary view_items fancybox action-btn")
        );
        $orderby = " ORDER BY bill.id ASC";       
        $config = array();
        $config['checkbox'] = 0;
        $config['count_distinct'] = '';
        $config['excel'] = 1;
        $config['total_amount'] = 1;
        $config['total_vat'] = 1;
        $config['total_amount_field'] = "final_amount";
        $config['total_vat_field'] = "bill.vat_amount";

        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 20, 1, $config);
        if (isset($_REQUEST['ajax_reports']) && $_REQUEST['ajax_reports'] == 1) {
            echo $p['grid'];
            return;
        }
        $p['brands'] = $this->brand->getAll();
        $p['class_tree'] = $this->class->getClassTree();
        $p['tab'] = 'sales_report';
        $this->_my_output('sales_report', $p);   

    }   

    public function brand_sales_report_index() {

        $p = array();      
        $p['tab'] = 'brand_sales_report';
        $p['brands'] = $this->brand->getAll();
        $this->_my_output('brand_sales_report', $p);   
    }

    public function brand_sales_report() {       
      
        $to = '';
        $from = '';
        $brand_id = 0;

        $this->load->library('pagination');
        $config = array();
        $config["base_url"] = site_url('inventory/brand_sales_report');
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;             
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;    
        

        if (isset($_REQUEST['reports_date_from']) && trim($_REQUEST['reports_date_from']) != '') {
               // input string will be something like 06/13/2012 04:06
             $from = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_from'])));         
        }
        if (isset($_REQUEST['reports_date_to']) && trim($_REQUEST['reports_date_to']) != '') {
             $to = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_to'])));           
        } 
        if (isset($_REQUEST['reports_brand_id']) && trim($_REQUEST['reports_brand_id']) != '' && $_REQUEST['reports_brand_id'] != 0) {   
            $brand_id = $_REQUEST['reports_brand_id'];         
        }
        
        $res = $this->bill->countBillItemsByBrandId($from, $to, $brand_id);
        $config['total_rows'] = $res['cnt'];
        $this->pagination->initialize($config);

        $data  = $this->bill->getTotalAmountForBrandSalesReport($from, $to, $brand_id);

       $bill_items = $this->bill->getAllBillItemsByBrandId($from, $to, $brand_id, $config['per_page'], ($page + 0));       
       $p['links'] = $this->pagination->create_links();

       $p['brand_sales_report'] = $bill_items;

       //echo "count = ".count($bill_items);
       //print_r($bill_items);
        $p['total_quantity'] = $data['total_quantity'];    
        $p['total_amount'] = $data['total_amount'];
        $p['total_vat'] = $data['total_vat'];
        $p['total'] = $config['total_rows'];
        $p['brands'] = $this->brand->getAll();
        $p['tab'] = 'brand_sales_report';               
        $this->_my_output('brand_sales_report', $p);     
    } 


     public function get_brand_sales_excel_report() {

            $to = '';
            $from = '';
        
           
           if (isset($_REQUEST['reports_date_from']) && trim($_REQUEST['reports_date_from']) != '') {
               // input string will be something like 06/13/2012 04:06
             $from = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_from'])));         
            }
            if (isset($_REQUEST['reports_date_to']) && trim($_REQUEST['reports_date_to']) != '') {
                 $to = date("Y-m-d H:i:s",strtotime(trim($_REQUEST['reports_date_to'])));           
            } 
            if (isset($_REQUEST['reports_brand_id']) && trim($_REQUEST['reports_brand_id']) != '' && $_REQUEST['reports_brand_id'] != 0) {   
                $brand_id = $_REQUEST['reports_brand_id'];         
            }

            $bill_items = $this->bill->getAllBillItemsByBrandId($from, $to, $brand_id);       

            $file_name = "brand_sales";  
            $headers = array("BILL ITEM NO / REF NO", "DATE", "PRODUCT NAME", "BRAND", "QTY", "AMOUNT", "VAT");      
            $total_amount  = $this->bill->getTotalAmountForBrandSalesReport($from, $to, $brand_id);                       

            $this->export_brand_sales_report_to_excel($file_name, $headers, $bill_items, $total_amount);

    }

    public function export_brand_sales_report_to_excel($file_name, $headers, $data, $total_amount) {

            $this->load->library('PHPExcel');
            $this->load->library('PHPExcel/PHPExcel_IOFactory');
            $objExcel = new PHPExcel();
            $objExcel->setActiveSheetIndex(0);
            $sheet = $objExcel->getActiveSheet();
            $i = 0;
            $result = array();
            foreach ($data as $res) {
                $result[$i] = $res;
                $i++;
            }
            if ($result) {
                $is_header_set = true;
                $body_cells_start_index = ($is_header_set) ? 3 : 2; 
                $sheet->setCellValue("A1", "Total Amount =" . $total_amount);               
                if ($is_header_set && isset($headers) && is_array($headers) && count($headers)) {
                    $index = 2;
                    $start_column = 'A';
                    foreach ($headers as $key => $header)
                        $sheet->setCellValue(chr(ord($start_column) + $key) . "$index", $header);
                }
                $values = $result;
                foreach ($values as $row_key => $row) {
                    $key_index = 0;
                    $count_row = count($row);
                    foreach ($row as $key => $value) {
                        $sheet->setCellValue(chr(ord($start_column) + $key_index) . ($row_key + $body_cells_start_index), $value);
                        $key_index++;
                    }
                    $last = $row_key + $body_cells_start_index;
                }
                ob_end_clean();
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="' . $file_name . "report.xls");
                header('Cache-Control: max-age=0');                
                $objWriter = PHPExcel_IOFactory::createWriter($objExcel, "Excel5");
                $objWriter->save('php://output');
            } else {
                echo "No Records to Export";
            }
            /************************************************
            configuration object :
             *
             * $summary = true/false
             * summary_row = first/last
             * summary [] = {0 =>{value = 'quantity', $data_row => '1'},
             * {value= 'closing stock', $data_row = 0}}
             *************************************************/
            return;
    }  
  
    public function reports($item_entity_id = 26, $excel = 0)
    {
        if (isset($_REQUEST['excel']) && $_REQUEST['excel'] == 1) {
            $excel = 1;
        }

        $barcode_config = $this->barcode->getConfiguration();
        $id = $barcode_config['id'];
        $item_specific_id_length = $barcode_config['item_specific_id_length'];
        $item_entity_id_length = $barcode_config['item_entity_id_length'];
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "tr.id as id", "NAME" => "pd.name AS name", "QUANTITY" => "tr.quantity AS Quantity", "CATEGORY" => "cl.name as class_name",
            "BARCODE" => 'CONCAT("' . $id . '", RIGHT(CONCAT("000000", ' . $item_entity_id . ') , ' . $item_entity_id_length . '),RIGHT(CONCAT("0000000000000000", ph.id) , ' . $item_specific_id_length . ')) as barcode');
        $table = " `transaction` tr, central_stock cs, product_sku ps, product_header ph, products_description pd, class cl ";
        $where = " WHERE tr.`central_stock_id` = cs.`id` AND cs.`item_entity_id` = 26 AND cs.item_specific_id = ps.id AND ps.`header_id` = ph.`id` AND ph.`product_desc_id` = pd.`id` AND ph.`class_id` = cl.id ";

        if (isset($_REQUEST['brand_id']) && trim($_REQUEST['brand_id']) != '' && $_REQUEST['brand_id'] != 0) {
            $where .= ' AND ph.brand_id =' . $_REQUEST['brand_id'];
        }
        if (isset($_REQUEST['class_id']) && trim($_REQUEST['class_id']) != '' && $_REQUEST['class_id'] != 0) {
            //if multiple classes is to be considered, get all the classes a product falls into, and match against the classes-subclasses array
            $sub_classes = $this->class->getAllSubClasses(trim($_REQUEST['class_id']), 0);
            $sub_classes_string = implode(',', $sub_classes);
            $sub_classes_string = '(' . $sub_classes_string . ')';
            $where .= ' AND ph.class_id IN ' . $sub_classes_string;
        }
        if (isset($_REQUEST['from']) && trim($_REQUEST['from']) != '') {
            // input string will be something like 06/13/2012 04:06
            $format = 'm/d/Y h:i';
            $from_string = trim($_REQUEST['from']);
            $date_time = date_create_from_format($format, $from_string);
            $mysql_date = date_format($date_time, 'Y-m-d H:i:s');
            $where .= ' AND tr.created_at >=\'' . $mysql_date . '\'';
        }
        if (isset($_REQUEST['to']) && trim($_REQUEST['to']) != '') {
            $format = 'm/d/Y H:i';
            $to_string = trim($_REQUEST['to']);
            $date_time = date_create_from_format($format, $to_string);
            $mysql_date = date_format($date_time, 'Y-m-d H:i:s');
            $where .= ' AND tr.created_at <=\'' . $mysql_date . '\'';
        }
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('product_sku/get_by_trans_id?ajax=1'), "css" => "btn btn-primary fancybox action-btn")
        );
        $orderby = " ORDER BY tr.id ASC";
        $config = array();
        $config['checkbox'] = 0;
        $config['count_distinct'] = '';
        $config['excel'] = 1;
        $config['total_quantity'] = 1;
        $config['total_quantity_field'] = "tr.quantity";


        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 20, 1, $config);
        if (isset($_REQUEST['ajax_reports']) && $_REQUEST['ajax_reports'] == 1) {
            echo $p['grid'];
            return;
        }
        $p['brands'] = $this->brand->getAll();
        $p['class_tree'] = $this->class->getClassTree();
        $p['tab'] = 'inventory_reports';
        $this->_my_output('reports', $p);
    }

    function getProd_names()
    {
        $entityid = $_GET['id'];
        list($p['html'], $data['report']) = $this->inventory->getProd_names($entityid);
        $p['inv'] = $this->load->view("inventory/inv_trans_report", $data, true);
        $this->_my_output('inventory_report', $p);
    }

    function get_entity_name($id)
    {
        $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
        $data = $this->inventory->InventoryReportData(trim($term), $id);
        $tmp = array();
        //$tmp['checkbox'] = 'Boolean&nbsp;<input type="radio" name="type" value="1"/>&nbsp;&nbsp;&nbsp;SubItem&nbsp;<input type="radio" name="type" value="2"/>';
        if (!empty($data)) {
            foreach ($data as $r) {
                $tmp['specific_id'] = $r['specific_id'];
                $tmp['entity_id'] = $id;
                $tmp['label'] = $r['name'];
                $tmp['value'] = $r['name'];
                //$i++;
                $params[] = $tmp;
            }
            //$params[] = $tmp  ;
            echo json_encode($params);
        } else {
            echo json_encode($tmp);
        }
    }

    function get_ornament_name()
    {
        //debugbreak();
        $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
        $data = $this->inventory->getOrnamentName($term);
        $tmp = array();
        if (!empty($data)) {
            $tmp['ornament_id'] = $data['id'];
            $tmp['label'] = $data['name'];
            $params[] = $tmp;
            echo json_encode($params);
        }
    }

    function split_date($date)
    {
        $reportdate = explode("To", urldecode($date));
        if (!empty($reportdate[1])) {
            $frm = $reportdate[0];
            $to = date('Y-m-d', strtotime('+1 day', strtotime($reportdate[1])));
        } else {
            $frm = $reportdate[0];
            $to = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return array($frm, $to);
    }

    public function get_detailed_stock_by_class($class_id, $item_entity_id)
    {
        $sub_classes = $this->class->getAllSubClasses($class_id, 0);
        $detailed_stock = $this->inventory->getDetailedStockByClasses($sub_classes, $item_entity_id);
        if (is_null($detailed_stock)) {
            log_message('error', 'DETAILED STOCK NULL, inventory controller');
        }
        $params = array();
        $params['stock'] = $detailed_stock;
        $params['parents'] = $this->class->getParents($class_id);
        $this->_my_output('detailed_stock', $params);
    }

    public function display_detailed_stock($class_id = 0, $item_entity_id = 26)
    {
       //debugbreak();
        $p = array();
        $classes = $this->class->getAllSubClasses($class_id, 0);
        $id_string = $classes[0];
        $p['parents'] = $this->class->getParents($class_id);
        foreach ($classes as $class_id) {
            $id_string .= ', ' . $class_id;
        }
        $brand = isset($_REQUEST['brand_id']) ? $_REQUEST['brand_id'] : 0;
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "ph.id as id", "PRODUCT NAME" => "pd.name AS name", "QUANTITY" => "SUM(cs.quantity) AS Quantity", "MRP VALUE" => "ROUND((SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)), 2)", "CLASSIFICATION CATEGORY" => "cl.name as class_name", "BRAND" => "b.name as brand_name");
        $table = " central_stock cs, product_sku ps, product_header ph, products_description pd, class cl, brand b";
        $where = " WHERE cs.`item_entity_id` = {$item_entity_id} AND cs.item_specific_id = ps.id AND ps.`header_id` = ph.`id` AND ph.`product_desc_id` = pd.`id` AND b.`id` = ph.`brand_id` AND ph.`class_id` = cl.id AND cl.id IN ({$id_string})";
        if ($brand > 0) {
            $where .= " AND ph.`brand_id` = {$brand}";
        }
        $where .= " GROUP BY ph.id ";
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('product/view_product_header?ajax=1'), "css" => "btn btn-primary fancybox action-btn")
        );
        $orderby = " ORDER BY pd.name ASC";
        $config = array();
        $config['checkbox'] = 0;
        $config['count_distinct'] = 'ph.id';
        $config['excel'] = 1;
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 20, 1, $config);
        $brands = $this->brand->getAll();
        $p['brands'] = $brands;
        $totals = $this->inventory->calculatetotals($brand);
        $p['price'] = $totals['price']; 
         $p['quantity'] = $totals['quantity']; 
        $this->_my_output('stock', $p);
    }
    public function showProdGrid($header_id)
    {
    // debugbreak();
         $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "ph.id as id", "PRODUCT NAME" => "pd.name AS name", "QUANTITY" => "SUM(cs.quantity) AS Quantity", "MRP VALUE" => "ROUND((SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)), 2)", "CLASSIFICATION CATEGORY" => "cl.name as class_name", "BRAND" => "b.name as brand_name");
        $table = " central_stock cs, product_sku ps, product_header ph, products_description pd, class cl, brand b";
        $where = " WHERE cs.`item_entity_id` = 26 AND cs.item_specific_id = ps.id AND ps.`header_id` = ph.`id` AND ph.`product_desc_id` = pd.`id` AND b.`id` = ph.`brand_id` AND ph.`class_id` = cl.id";
        if ($header_id > 0) {
            $where .= " AND ps.`header_id` = {$header_id}";
        }
      //  $where .= " GROUP BY ph.id ";
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('product/view_product_header?ajax=1'), "css" => "btn btn-primary fancybox action-btn")
        );
        $orderby = " ORDER BY pd.name ASC";
        $config = array();
        $config['checkbox'] = 0;
        $config['count_distinct'] = 'ph.id';
        $config['excel'] = 1;
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 20, 1, $config);
     //   $brands = $this->brand->getAll();
    //    $p['brands'] = $brands;
       // $totals = $this->inventory->calculatetotals($brand);
     //   $p['price'] = $totals['price']; 
       //  $p['quantity'] = $totals['quantity']; 
       // $this->_my_output('stock', $p);
        echo $p['grid'];
    }
    public function opening_stock()
    {
        $params = array();
        $params['tab'] = 'opening_stock';
        $this->_my_output('opening_stock', $params);
    }

    public function submit_opening_stock()
    {
       //debugbreak();
        $params = array();
        $branch_id = isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : $this->user->getBranch();
        $products = array();
        foreach ($_REQUEST['item_id'] as $p) {
            $item_entity_id_array = explode('_', $p);
            $row_count = isset($item_entity_id_array[2]) ? $item_entity_id_array[2] : '0';
            $item_entity_id_absolute = $item_entity_id_array[0];
            $id = $item_entity_id_array[1];
            $entity = $this->item_entity->getEntityById($item_entity_id_absolute);
            $name = $entity['name'];
            $tmp = $this->{$name}->getById($id);
            $tmp['model_name'] = $name;
            //$tmp['po_box'] = isset($_REQUEST['no_of_box_' . $p]) ? $_REQUEST['no_of_box_' . $p] : 1;
            $tmp['quantity'] = isset($_REQUEST['quantity_' . $p]) ? $_REQUEST['quantity_' . $p] : 1;
            $tmp['weight'] = isset($_REQUEST['weight_' . $p]) ? $_REQUEST['weight_' . $p] : 1;
            $tmp['max_discount'] = isset($_REQUEST['max_discount_' . $p]) ? $_REQUEST['max_discount_' . $p] : 100;
            $tmp['price'] = isset($_REQUEST['price_' . $p]) ? $_REQUEST['price_' . $p] : 0;
            $category = $this->category->getProductCategoryById($tmp['category_id']);
            $tmp['vat_rate'] = $category['vat_percentage'];
            $tmp['sub_total'] = $tmp['price'] * $tmp['quantity'] * $tmp['weight'];
            $tmp['item_entity_id'] = $item_entity_id_absolute;
            $tmp['item_specific_id'] = $id;
            if (isset($entity['is_header']) && $entity['is_header']) {
                $tmp['header_product_id'] = $entity['product_entity_id'];
                $header_entity_array = $this->item_entity->getEntityById($tmp['header_product_id']);
                $tmp['header_product'] = $header_entity_array['name'];
            }
            if ($row_count > 0) {
                if (isset($_REQUEST['sub_item_id_' . $row_count]) && is_array($_REQUEST['sub_item_id_' . $row_count])) {
                    foreach ($_REQUEST['sub_item_id_' . $row_count] as $sub_item_id) {
                        $sub_id_array = explode('_', $sub_item_id);
                        $sub_item_entity_id = $sub_id_array[0];
                        $sub_item_specific_id = $sub_id_array[1];
                        $sub_item_quantity = isset($_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count] : 1;
                        $sub_weight = isset($_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count] : 0;
                        $sub_rate = isset($_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count] : 0;
                        $sub_price = $sub_item_quantity * $sub_weight * $sub_rate;
                        $sub_entity = $this->item_entity->getEntityById($sub_item_entity_id);
                        $type = $sub_entity['display_name'];
                        $tmp['sub_total'] += $sub_price;
                        $sub_item_specific_details = $this->{$sub_entity['name']}->getById($sub_item_specific_id);
                        $tmp['items'][] = array('item_entity_id' => $sub_item_entity_id, 'item_specific_id' => $sub_item_specific_id, 'type' => $type, 'name' => $sub_item_specific_details['name'],
                            'row_count' => $row_count, 'quantity' => $sub_item_quantity, 'weight' => $sub_weight, 'price' => $sub_price, 'rate' => $sub_rate);
                    }
                }
                $tmp['attributes'] = array();
                if (isset($_REQUEST['attribute_id_' . $p])) {
                    foreach ($_REQUEST['attribute_id_' . $p] as $attribute_id) {
                        $attribute['read_only'] = isset($_REQUEST['attribute_type_' . $p . '_' . $attribute_id]) ? trim($_REQUEST['attribute_type_' . $p . '_' . $attribute_id]) : 0;
                        if ($attribute['read_only'] == 1) {
                            continue;
                        }
                        $attribute['id'] = $attribute_id;
                        $attribute['name'] = trim($_REQUEST['attribute_name_' . $p . '_' . $attribute_id]);
                        $attribute['display_name'] = trim($_REQUEST['attribute_display_name_' . $p . '_' . $attribute_id]);
                        $attribute['value'] = trim($_REQUEST['attribute_value_' . $p . '_' . $attribute_id]);
                        $attribute['level'] = isset($_REQUEST['attribute_level_' . $p . '_' . $attribute_id]) ? trim($_REQUEST['attribute_level_' . $p . '_' . $attribute_id]) : '';
                        if ($attribute['level'] == '' || is_null($attribute['level']) || $attribute['level'] == 'null') {
                            //calculate the level and set here
                            if ($attribute_id < 0) {
                                $attribute['level'] = 1;
                            } else {
                                $attribute['level'] = 2;
                            }
                        }
                        $tmp['attributes'][] = $attribute;
                    }
                }
            }
            $products[$p] = $tmp;
        }
        $po_products = array();
        $params = array();
        $params['date'] = date('d-m-Y');
        foreach ($products as &$product) {
            if (!isset($product['rate'])) {
                $product['rate'] = $product['price'];
            }
            if (isset($product['header_product']) && !is_null($product['header_product']) && $product['header_product'] != '') {
                $item_specific_id = false;
                if (!$item_specific_id) {
                    //add($header_id,  $vendor_id, $user_id,$max_discount = 100, $attributes = array(), $image_path = '', $tracking_level = '', $mfg_barcode = '')
                    $item_specific_id = $this->{$product['header_product']}->add($product['item_specific_id'], -1, $this->user->getUserId(), $product['max_discount'], $product['attributes']);
                }
                if (!$item_specific_id) {
                    $item_specific_id = $this->{$product['header_product']}->add($product['item_specific_id'], $product['weight'], $product['items']);
                }
                $product['item_specific_id'] = $item_specific_id;
                $product['item_entity_id'] = $product['header_product_id'];
            }
            $product['barcode'] = $this->barcode->getBarcode($product['item_entity_id'], $product['item_specific_id']);
        }
        $params['selected_products'] = $products;
        $this->db->trans_begin();
        $grn_json = json_encode($params);
        foreach ($products as &$product) {
            if (isset($product['items']) && count($product['items']) > 0 && isset($product['header_product'])) {
                $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, $product['quantity'], $product['weight'], 1, '', $this->user->loggedInUserId(), 'O.S.E.');
            } else {
                $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, $product['quantity'], $product['weight'], '', '', $this->user->loggedInUserId(), 'O.S.E.');
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $params['msg'] = "Failed!";
            $params['status'] = 'error';
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $params['msg'] = 'Added Successfully!!';
            $params['status'] = 'success';
        }
        echo json_encode($params);
//        debugbreak();
    }

    public function  stock_ledger_report()
    {
        //debugbreak();
        $p = array();
        if (empty($_REQUEST['from']) && empty($_REQUEST['to'])) {
            $p['tab'] = 'stock_ledger';
            $this->_my_output('stock_ledger', $p);
        } else {
            if (isset($_REQUEST['from']) && trim($_REQUEST['from']) != '') {
                // input string will be something like 06/13/2012 04:06
                $format = 'm/d/Y h:i';
                $from_string = trim($_REQUEST['from']);
                $date_time = date_create_from_format($format, $from_string);
                $from = date_format($date_time, 'Y-m-d H:i(worry)');
            }
            if (isset($_REQUEST['to']) && trim($_REQUEST['to']) != '') {
                $format = 'm/d/Y H:i';
                $to_string = trim($_REQUEST['to']);
                $date_time = date_create_from_format($format, $to_string);
                $to = date_format($date_time, 'Y-m-d H:i(worry)');
            }
            $data['report'] = $this->inventory->StockLedgerReport($from, $to);
            $data['tax'] = $this->category->getAllvatpercentages();
            // debugbreak();
            if ($_REQUEST['xml'] != 1) {
                $p['html'] = $this->load->view('inventory/stock_ledger_report', $data, true);
                echo $p['html'];
            } else {
                $this->excel_ledger_file($data);
            }
        }
    }

    public function excel_ledger_file($data)
    {
        // debugbreak();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/PHPExcel_IOFactory');
        $objExcel = new PHPExcel();
        $objExcel->setActiveSheetIndex(0);
        $sheet = $objExcel->getActiveSheet();
        $i = 0;
        //  debugbreak();
        if ($data) {
            $report = $data['report'];
            $tax = $data['tax'];
            $excel = array();
            foreach ($report as $rep) {
                $items = $rep['items'];
                foreach ($items as $item) {
                    $excel[$i]['id'] = $rep['id'];
                    $excel[$i]['date'] = substr($rep['created_at'], 0, 10);
                    $excel[$i]['name'] = $rep['fname'] . ' ' . $rep['lname'];
                    $excel[$i]['item_name'] = $item['name'];
                    $excel[$i]['qty'] = $item['quantity'];
                    $excel[$i]['price'] = $item['price'];
                    foreach ($tax as $ta) {
                        if ($ta['vat_percentage'] == $item['vat_percent']) {
                            $excel[$i]['sales@' . $ta['vat_percentage']] = !empty($item['final_amount']) ? $item['final_amount'] : 0;
                        } else {
                            $excel[$i]['sales@' . $ta['vat_percentage']] = 0;
                        }
                        if ($ta['vat_percentage'] == $item['vat_percent']) {
                            $excel[$i]['vat@' . $ta['vat_percentage']] = !empty($item['vat']) ? $item['vat'] : 0;
                        } else {
                            $excel[$i]['vat@' . $ta['vat_percentage']] = 0;
                        }
                    }
                    $excel[$i]['invoice_value'] = $item['final_amount'];
                    // debugbreak();
                    $i++;
                }
            }
            $is_header_set = true;
            $headers = array("INV-NO", "DATE", "PARTY", "ITEM NAME", "QTY", "RATE",);
            // debugbreak();
            foreach ($tax as $t) {
                array_push($headers, "SALES@" . $t['vat_percentage'] . "%", "VAT@" . $t['vat_percentage'] . "%");
            }
            array_push($headers, 'INVOICE VALUE');
            //  foreach($data['report'])
            $body_cells_start_index = ($is_header_set) ? 3 : 2;
            if ($is_header_set && isset($headers) && is_array($headers) && count($headers)) {
                $index = 1;
                $start_column = 'A';
                foreach ($headers as $key => $header) {
                    $sheet->setCellValue(chr(ord($start_column) + $key) . "$index", $header);
                }
            }
            // debugbreak();
            $values = $excel;
            foreach ($values as $row_key => $row) {
                $key_index = 0;
                $count_row = count($row);
                foreach ($row as $key => $value) {
                    //   echo chr(ord($start_column)+$key_index).($row_key+$body_cells_start_index)."<br />";
                    $sheet->setCellValue(chr(ord($start_column) + $key_index) . ($row_key + $body_cells_start_index), $value);
                    $key_index++;
                }
                $last = $row_key + $body_cells_start_index;
            }
            //  debugbreak();
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="Report.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($objExcel, "Excel5");
            $objWriter->save('php://output');
        } else {
            echo "No Records to Export";
        }
    }
  public function vat_report_index() {
        $p = array();       
        $p['tab'] = 'vat_report';
        $this->_my_output('vat_report', $p);   
    }
    
    public function get_vat_report($from ='',$to='',$page='')
        {
            //debugbreak();
            $branch = '';
           
            $from_date = !empty($from) ? urldecode($from): 0;
            $from_date = (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date'])) ? $_REQUEST['from_date']: (!empty($from_date) ? $from_date : 0);
            $from_date = !empty($from_date) ? date("Y-m-d H:i:s",strtotime(trim($from_date))) : 0;

            $to = !empty($to) ? urldecode($to): 0;
            $to_date = (isset($_REQUEST['to_date']) && !empty($_REQUEST['to_date'])) ? $_REQUEST['to_date']:(!empty($to) ? $to : 0);
            $to_date = !empty($to_date) ? date("Y-m-d H:i:s",strtotime(trim($to_date))) : 0; 
           
            $count = $this->bill->getTotalCountonSales($from_date ,$to_date);  
            //var_dump($data);  
            if($count > 0 && $count != false )
            {
               // $count = $data;

                //debugbreak();
                $branch = $from_date.'","'.$to_date;
                $page_data = $this->create_pagination($count,$branch,$page);
                // debugbreak();
                $p['pagination'] = $page_data['pagination'];
                $p['limit'] = $page_data['limit']; $p['offset']=$page_data['offset'];  
                $p['data'] = $this->bill->getVatReport($from_date ,$to_date, $p['limit'], $p['offset']);  
                // debugbreak();
                $p['count'] = $count;
                $p['grid'] = $this->load->view("inventory/vat_report_table",$p,true);
                echo $p['grid'];
            }
            else
            {
                $p['grid'] = "No results found";
                echo $p['grid'];
            }

        }
   public function vat_report_excel($from , $to)
   {
         //  debugbreak();
         //   $prodarray = array();

            $from = str_replace('-','/',$from);
            $to = str_replace('-','/',$to);

            $from = !empty($from) ? date("Y-m-d H:i:s",strtotime(trim($from))) : '';
            $to = !empty($to) ? date("Y-m-d H:i:s",strtotime(trim($to))) : '';

            //$branch_id = !empty($branch)? $branch : (!empty($_REQUEST['id'])? $_REQUEST['id']:'');
            $data_report = $this->bill->getVatReport($from,$to);
//            debugbreak();
            if(isset($data_report['bill'])) {
                $k = 0;
                $data = $data_report['bill'];
                $vat_percentages = $data_report['vat_percentages'];
                
                $this->load->library('PHPExcel');
                $this->load->library('PHPExcel/PHPExcel_IOFactory');
                $objExcel = new PHPExcel();      
                $objExcel->setActiveSheetIndex(0);  
                $sheet = $objExcel->getActiveSheet();
                
                $i = 0;
             //   if($prodarray) { 
                    $is_header_set    =     true;
                    $headers    =    array("BILL NO / REF NO","DATE","TOTAL SALES");
                   foreach($vat_percentages as $vat)
                   {
                       if($vat['vat_percentage'] > 0){
                        array_push($headers , "GROSS SALES @".$vat['vat_percentage'],"VAT @".$vat['vat_percentage']);
                       }else{
                            array_push($headers , "EXEMPTED");
                       } 
                   }
                    
                    $body_cells_start_index    =    ($is_header_set) ? 3 : 2;
                    if($is_header_set && isset($headers) && is_array($headers) && count($headers)){
                        $index        =    2;
                        $start_column    =    'A';

                        foreach($headers as $key => $header)
                            $sheet->setCellValue(chr(ord($start_column)+$key)."$index",$header);
                    }

                    $values        =     $data;
                    foreach($values as $row_key => $row){
                        $key_index    =    0;
                        $count_row  = count($row);
                        foreach($row as $key => $value){
                            //   echo chr(ord($start_column)+$key_index).($row_key+$body_cells_start_index)."<br />";
                            $sheet->setCellValue(chr(ord($start_column)+$key_index).($row_key+$body_cells_start_index), $value);
                            $key_index++;
                        }
                        $last = $row_key + $body_cells_start_index;
                    }
                    //  debugbreak();
                    if (ob_get_length() > 0) {  
                        ob_end_clean();             
                    }
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename="VAT REPORT -'.$from.'-'.$to.'.xls"');
                    header('Cache-Control: max-age=0');
                    $objWriter    = PHPExcel_IOFactory::createWriter($objExcel, "Excel5");      
                    $objWriter->save('php://output');
             //   }
            } else{
                $this->load->library('PHPExcel');
                $this->load->library('PHPExcel/PHPExcel_IOFactory');
                $objExcel = new PHPExcel();      
                $objExcel->setActiveSheetIndex(0);  
                $sheet = $objExcel->getActiveSheet();

                $is_header_set    =     true;
                $headers    =   "No Records";
                $body_cells_start_index    =    ($is_header_set) ? 3 : 2;
                // $append = array("open"=>$data['0']['quantity_before'],"close"=>$data[sizeof($data['report'])-1]['quantity_after']);
                //$append_col = 'A';
                // $sheet->setCellValue("A1","Opening Stock =".$data['0']['quantity_before']); 
                //   $sheet->setCellValue("C1","Closing Stock =".$data[sizeof($data)-1]['quantity_after']);
                if($is_header_set && isset($headers) && is_array($headers) && count($headers)){
                    $index        =    2;
                    $start_column    =    'A';

                    foreach($headers as $key => $header)
                        $sheet->setCellValue(chr(ord($start_column)+$key)."$index",$header);
                }
                //  debugbreak();
                if (ob_get_length() > 0) {  
                    ob_end_clean();             
                }
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment; filename="Empty Purchase Returns report-'.date("Y-m-d H:i:s").'.xls"');
                header('Cache-Control: max-age=0');
                $objWriter    = PHPExcel_IOFactory::createWriter($objExcel, "Excel5");      
                $objWriter->save('php://output');
            }
    }
    function create_pagination($count ,$branch,$page)
        {
            if($count >0){
                $cnt   = $count;
                $page_numbering = 1;
                $offset   =  0;
                $limit   = 20;
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
                    $max_pagination_indices  = 10;
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
                        $html   .=' <li class="prev"><a  onclick=\'paginated_report("'.urldecode($branch).'","1")\'>First</a></li>';
                        $html   .=' <li class="prev"><a  onclick=\'paginated_report("'.urldecode($branch).'","'.$_GET['page'].'")\'>&larr; Previous</a></li>';
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
                            $html .= '<a  onclick=\'paginated_report("'.urldecode($branch).'","'.$i.'")\'>'.$i.'</a>';
                            //$html .= '<a href="'.$_SERVER['PHP_SELF'].'?'.$qs.'">'.$i.'</a>';
                            $html  .=  '</li>';  
                        }
                    }

                    if($cur_page >= $pages){
                        $html .= '<li class="next disabled"><a href="#">Next &rarr;</a></li>';
                    }else{
                        $_GET['page']  = $cur_page + 1;
                        $qs    = http_build_query($_GET);
                        $html   .= ' <li class="next"><a  onclick=\'paginated_report("'.urldecode($branch).'","'.$_GET['page'].'")\'>Next &rarr;</a></li>'; 
                        //$html .= ' <li class="next"><a href="'.$_SERVER['PHP_SELF'].'?'.$qs.'">Next &rarr;</a></li>';
                        $html   .= ' <li class="next"><a  onclick=\'paginated_report("'.urldecode($branch).'","'.trim(ceil($cnt/$limit)).'")\'>Last &rarr;</a></li>';
                    }
                    $html .= '</ul>';
                    $html .= '</div>';
                }
                $data['pagination']     = (isset($html))?$html:'';
                $data['limit'] = $limit; $data['offset'] =$offset;
                return $data;

            }
        } 
    public function _my_output($file = 'inventory', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = isset($params['tab']) ? $params['tab'] : '';
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('inventory/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}

/*END OF FILE*/
