<?php
/**
 * File Name: product_sku.php
 * Author: Rajat
 * Date: 5/9/12
 * Time: 3:52 PM
 */
class Product_sku extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->database();
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
        if ($this->json === true) {
            $this->ajax = true;
        }
        /*        if ($this->ajax === false) {
              redirect('purchases');
          }*/
        $this->load->model('Item_entity_Model', 'item_entity');
        $this->load->model('Category_Model', 'category');
        $this->load->model('Class_Model', 'class');
        $this->load->model('brand_Model', 'brand');
        $this->load->model('User', 'user');
        $this->load->model('metal_model', 'metal');
        $this->load->model('stone_model', 'stone');
        $this->load->model('ornament_model', 'ornament');
        $this->load->model('old_ornament_model', 'old_ornament');
        $this->load->model('rate_model', 'rate');
        $this->load->model('product_header_model', 'product_header');
        $this->load->model('transaction_model', 'transaction');
        $this->load->library('productLib', array());
        $this->load->library('barcode', array());
        $this->load->model('Attribute_Model', 'attribute');
        $this->load->model('inventory_Model', 'inventory');
        $this->load->model('Product_sku_Model', 'product_sku');
    }

    public function suggest()
    {
        $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
        if ($term == '') {
            return;
        }
        $products = array();
        $products = $this->product_sku->suggest($term);
        foreach ($products as &$product) {
            $product['label'] = $product['name'];
            $product['value'] = '';
        }
        echo json_encode($products);
    }

    public function get_by_id($id = '', $html = 1)
    {
        $stock = isset($_REQUEST['stock']) ? $_REQUEST['stock'] : 0;
        if ($id == '') {
            $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        }
        if ($id == '') {
            return False;
        }
        $products = array();
        $products['sku'] = array();
        $products['sku'][] = $this->product_sku->getById($id);
        if ($stock == 1) {
            foreach ($products['sku'] as &$sku) {
                $temp = $this->inventory->getStockValueByItem(26, $sku['id']);
                $sku['stock'] = $temp['stock'];
                $sku['mrp_value'] = $temp['value'];
                unset($temp);
            }
        }
        if ($html == 1) {
            $this->load->view('product/view_sku', array('output' => $products['sku'][0]));
        } else {
            echo json_encode($products);
        }
    }

    public function get_by_trans_id()
    {
        //$stock = isset($_REQUEST['stock']) ? $_REQUEST['stock'] : 0;
       /* if ($id == '') {
            $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        }*/

        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            return False;
        }

        $trans = array();
        $trans = $this->transaction->getById($id);
        $id = $trans['id'];

        $products = array();
        $products['sku'] = array();
        $products['sku'][] = $this->product_sku->getById($id);
        foreach ($products['sku'] as &$sku) {
            $temp = $this->inventory->getStockValueByItem(26, $sku['id']);
            $sku['stock'] = $temp['stock'];
            $sku['mrp_value'] = $temp['value'];
            unset($temp);
        }        
        $this->load->view('product/view_sku', array('output' => $products['sku'][0]));
    }

    public function get_by_header($header_id)
    {
        $stock = isset($_REQUEST['stock']) ? $_REQUEST['stock'] : 0;
        $header_id = trim($header_id);
        $products = array();
        $products['sku'] = $this->product_sku->getByHeaderId($header_id);
        if ($stock == 1) {
            foreach ($products['sku'] as &$sku) {
                $temp = $this->inventory->getStockValueByItem(26, $sku['id']);
                $sku['stock'] = $temp['stock'];
                $sku['mrp_value'] = $temp['value'];
                unset($temp);
            }
        }
        $products['header'] = $this->product_header->getById($header_id, 1);
        //log_message('error', 'IN sku controller :: '.print_r($products, 1));
        if (count($products)) {
        }
        echo json_encode($products);
    }

    public function get_by_barcode($barcode)
    {
        if ($this->barcode->isValidBarcode($barcode)) {
            $this->get_by_custom_barcode($barcode);
        } else {
            $this->get_by_mfg_barcode($barcode);
        }
    }

    public function get_by_custom_barcode($barcode)
    {
        $stock = isset($_REQUEST['stock']) ? $_REQUEST['stock'] : 0;
        $id_array = $this->barcode->decomposeBarcode($barcode);
        if ($id_array['item_entity_id'] == 26) {
            $product = $this->get_by_id($id_array['item_specific_id'], 0);
        } elseif ($id_array['item_entity_id'] == 25) {
            $product = $this->get_by_header($id_array['item_specific_id']);
        } else {
            return False;
        }
        //echo json_encode($product);
    }

    public function get_by_mfg_barcode($barcode)
    {
        $stock = isset($_REQUEST['stock']) ? $_REQUEST['stock'] : 0;
        $products['header'] = $this->product_header->getByMfgBarcode($barcode, 1);
        if (!is_array($products['header']) || count($products['header']) < 1) {
            return False;
        }
        if ($stock == 1) {
            $temp = $this->inventory->getStockValueByItem($this->item_entity->getEntityId('product_header'), $products['header']['id']);
            $products['header']['stock'] = $temp['stock'];
            $products['header']['mrp_value'] = $temp['value'];
            unset($temp);
        }
        $products['sku'] = $this->product_sku->getByHeaderId($products['header']['id']);
        //$products = $this->product_sku->getByAttribute('mfg_barcode', $barcode);
        if ($stock == 1) {
            foreach ($products['sku'] as &$sku) {
                $temp = $this->inventory->getStockValueByItem(26, $sku['id']);
                $sku['stock'] = $temp['stock'];
                $sku['mrp_value'] = $temp['value'];
                unset($temp);
            }
        }
        echo json_encode($products);
    }
   
}

/*END OF FILE*/