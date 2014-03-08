<?php
/**
 * File Name: Master.php
 * Author: Rajat
 * Date: 3/13/12
 * Time: 12:07 AM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Master extends CI_Controller
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
        $this->load->model('Product_Model', 'product');
        $this->load->model('Vendor_Model', 'vendor');
        $this->load->model('Po_Model', 'po');
        $this->load->model('Item_entity_Model', 'item_entity');
        $this->load->model('class_model', 'class');
        $this->load->model('brand_model', 'brand');
        $this->load->model('category_model', 'category');
        $this->load->model('product_header_model', 'product_header');
        $this->load->library('Barcode', array());
    }

    public function index($input = '', $source = 'default')
    {
    }

    public function bc($input)
    {
        //this will be the main function to handle master input field requests
        //$barcode_id = '4x0';
        $mfg_product_models = array('ornament_product');
        $input = strtolower(trim($input));
        if (strlen($input) > 16 && substr($input, 0, 2) == '4x') {
            //input is a custom barcode
            //break it down
            //$item_entity_id = intval(substr($input, strlen($barcode_id), $item_entity_id_length));
            //$item_specific_id = intval(substr($input, strlen($barcode_id) + $item_entity_id_length, $item_specific_id_length));
            //get the item_entity_id from barcode pieces
            //get the model_name from item_entity
            //$item_entity = $this->item_entity->getEntityById($item_entity_id);
            return $this->barcode->getByBarcode($input);
        } elseif (ctype_alpha($input)) {
            //input can be customer name / product name
            //search
        } elseif (ctype_digit($input)) {
            //input can be manufacturer's barcode or customer phone number
            //check for the lenght of the string
            //if length is 10
            //most probably phone number
            //check in customer phone number if not present check in barcodes
            //else length not 10, check in barcodes, if not present check in phone number
        } else {
            //input can still be manufacturers barcode
            //check in barcodes if not found, check in product names
            //check in all products as name
            //otherwise heuristics to be applied
        }
    }

    public function export_to_excel()
    {
        ini_set('memory_limit', '-1');
        $query = isset($_REQUEST['query']) ? urldecode($_REQUEST['query']) : '';
        $headers = isset($_REQUEST['headers']) ? urldecode($_REQUEST['headers']) : '';
        $file_name = isset($_REQUEST['file']) ? urldecode($_REQUEST['file']) : 'default';
        $total_amount = isset($_REQUEST['total_amount']) ? urldecode($_REQUEST['total_amount']) : '';
        $headers = json_decode($headers);
        $data = $this->db->query($query);
        $data = $data->result_array();
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
            //$sheet->setCellValue("A1", "Opening Stock =" . $data['0']['Quantity']);
            //$sheet->setCellValue("C1", "Closing Stock =" . $data[sizeof($data) - 1]['Quantity']);
            if($total_amount != '')
                    $sheet->setCellValue("C1", "Total Amount =" . $total_amount);
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

    

    public function read_excel()
    {
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/PHPExcel_IOFactory');
        //$objExcel = new PHPExcel();
        $inputFileType = 'Excel5';
        $inputFileName = 'e:\example.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
        var_dump($objPHPExcel);
    }

    public function csv_read()
    {
        $fieldseparator = ",";
        $lineseparator = '\n';
        $csvfile = 'e:\b.csv';
        if (!file_exists($csvfile)) {
            echo "File not found. Make sure you specified the correct path.\n";
            exit;
        }
        $file = fopen($csvfile, "r");
        if (!$file) {
            echo "Error opening data file.\n";
            exit;
        }
        $size = filesize($csvfile);
        if (!$size) {
            echo "File is empty.\n";
            exit;
        }
        $csvcontent = fread($file, $size);
        fclose($file);
        $lines = 0;
        $queries = "";
        $linearray = array();
        foreach (preg_split($lineseparator, $csvcontent) as $line) {
            $lines++;
            $line = trim($line, " \t");
            $line = str_replace("\r", "", $line);
            $line = str_replace("'", "\'", $line);
            $linearray = explode($fieldseparator, $line);
            //validation of the row to be placed here
            //
            //add brand
            $brand_id = $this->brand->add(trim($linearray[0]));
            //add class
            $parent_id = 26;
            $user_id = 1;
            //$name, $parent_id, $sort_order = 0, $user_id
            $class_id = $this->class->add(trim($linearray[4]), $parent_id, 0, 1);
            //add product header
            //$name, $description, $tax_category_id, $class_id, $brand_id, $user_id, $attributes = array(), $mfg_barcode = '', $product_desc_id = ''
            $description = '';
            $tax_category_id = 11;
            $attributes = array();
            $mfg_barcode = trim($linearray[2]);
            $name = trim($linearray[1]);
            $product_header_id = $this->product_header->add($name, $description, $tax_category_id, $class_id, $brand_id, $user_id, $attributes, $mfg_barcode);
            //$linemysql = implode("','", $linearray);
        }
    }

    public function csv_read_new($name)
    {
        $name = trim($name);
        $csvfile = 'e:\\' . $name . '.csv';
        if (!file_exists($csvfile)) {
            echo "File not found. Make sure you specified the correct path.\n";
            exit;
        }
        $file = fopen($csvfile, "r");
        if (!$file) {
            echo "Error opening data file.\n";
            exit;
        }
        $size = filesize($csvfile);
        if (!$size) {
            echo "File is empty.\n";
            exit;
        }
        //$csvcontent = fread($file, $size);
        //fclose($file);
        $lines = 0;
        $queries = "";
        while ($csv_line = fgetcsv($file, 1024)) {
            $user_id = 1;
            //for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
            $brand_id = $this->brand->add(trim($csv_line[0]), $user_id);
            //add class
            $parent_id = 133;
            //$name, $parent_id, $sort_order = 0, $user_id
            $class_id = $this->class->add(trim($csv_line[4]), $parent_id, 0, 1);
            //add product header
            //$name, $description, $tax_category_id, $class_id, $brand_id, $user_id, $attributes = array(), $mfg_barcode = '', $product_desc_id = ''
            $description = '';
            $tax_category_id = 20;
            $attributes = array();
            $mfg_barcode = trim($csv_line[2]);
            $name = trim($csv_line[1]);
            $product_header_id = $this->product_header->add($name, $description, $tax_category_id, $class_id, $brand_id, $user_id, $attributes, $mfg_barcode);
            echo $product_header_id . "\n";
            ob_flush();
            // }
        }
        fclose($file);
    }
}
