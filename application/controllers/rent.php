<?php
/**
 * Rent controller handles all features related to add/update/delete rented
 * product managing the tariff for rented products and reports related to all the
 * rent related transactions.
 *
 * @package controllers
 * @version 0.1.0
 * @copyright (c) 2012-2013 Langoor
 * @author Rama Chandra Gupta <ramag@langoor.net>
 *
 */

/**
 * Rent class
 *
 * @access public
 * @author Rama Chandra Gupta <ramag@langoor.net>
 *
 */

class Rent extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('url', 'form', 'html'));
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            log_message('debug', 'Log in problem ');
            redirect('login?error_msg=' . urlencode("Please  Login"));
        } // end:if

        $this->ajax = false;
        $this->json = false;

        if ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) || isset($_REQUEST['tabs']) && $_REQUEST['tabs'] == 1) {
            $this->ajax = true;
        }
        if (isset($_REQUEST['json']) && $_REQUEST['json'] == 1) {
            $this->json = true;
        }
        $this->load->database();
        $this->load->model('rent_category_model', 'rentCategory');
        $this->load->model('rent_product_model', 'rentProduct');
        $this->load->model('rent_components_model', 'rentComponents');
        $this->load->model('rent_product_component_relation_model', 'rentProductComponent');
        $this->load->model('rent_booking_model', 'rentBooking');
        $this->load->model('rent_component_stock_model', 'rentComponentStock');
        $this->load->model('customer_model', 'customer');
        $this->load->model('rent_booking_product_model', 'rentProductBooking');
        $this->load->model('rent_booking_component_model', 'rentComponentBooking');


        $this->load->library('datagrid', array('db' => &$this->db));
        $this->load->model('User', 'user');
        $this->load->model('manage_users_model', 'manageUsers');
    } // end: function __construct

    public function index()
    {
        $params = array('output' => print_r($_SESSION, true));
        $this->manageProducts();
        //$this->_my_output('index', $params);
    } //end: function index

    public function _my_output($file = 'rent', $params = array())
    {
        $p = array();
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = isset($params['tab']) ? $params['tab'] : $file;
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('rent/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    } //end: function _my_output()

    /**
     * Manage Components
     *
     * @access public
     * @return void
     */
    public function manageComponents()
    {

        $fields = array('ID' => 'p.id as id', 'NAME' => 'p.name as name',
            'Quantity' => 'p.quantity as quantity');
        $table = "rent_components p";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('rent/editComponent?ajax=1'), "css" => "btn btn-primary action-btn fancybox"),
            '<i class="icon-trash icon-white"></i>' => array("url" => site_url('rent/deleteComponent?ajax=1'), "css" => "btn btn-danger action-btn fancybox")
        );
        $where = 'where p.status = 1';
        $orderby = " order by p.`id` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $p['tab'] = 'rent_manage_components';
        $this->_my_output('manageComponent', $p);
    } //end: function manageComponents


    /**
     * Function to add rented products in the table rent_product
     *
     * @access public
     * @return boolean
     */
    public function addComponent()
    {

        $p = array();
        $p['class'] = $this->rentComponents->getAllComponents();
        $this->load->view('rent/addComponent', $p);
    } //end: function addProducts()

    /**
     * Function to add products in to table rent_product.
     *
     * @access  public
     * @return  void
     */
    public function addComponenttoDB()
    {
        $p = array();
        $product_name = isset($_REQUEST['product_name']) ? $_REQUEST['product_name'] : '';
        $data['name'] = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $data['quantity'] = isset($_REQUEST['quantity']) ? $_REQUEST['quantity'] : '';
        $data['rent_price'] = isset($_REQUEST['rent_price']) ? $_REQUEST['rent_price'] : '';


        if ($product_name  == '' || $data['name'] == '' || $data['rent_price'] == '' || $data['quantity'] == '') {
            $p['failed'] = "Missing Params";
            $this->_my_output('addProduct', $p);
            return;
        }

        $c_id = $this->rentComponents->add($data);
        $result = $this->rentProduct->getIdByName($product_name);
        foreach($result as $row)
            $p_id = $row['id'];
        $data['component_id'] = $c_id;
        $data['product_id'] = $p_id;
        $id = $this->rentProductComponent->add($data);
        if ($id !== false) {
            $p['success'] = "Successfully added! - ID:" . $id;
        } else {
            $p['failed'] = "Vendor Company is already exists!";
        }


        $this->_my_output('addComponent', $p);
    } // end: function addCategoryDB()

    /**
     * Function to edit the rent products in the table rent_product.
     *
     * @access public
     * @return void
     */
    public function editComponent()
    {
        $p = array();
        $id = $_REQUEST['id'];
        $p['component'] = $this->rentComponents->getById($id);
        $p['product'] = $this->rentProductComponent->getByComponentId($id);
        $this->load->view('rent/editComponent', $p);
    } //end : function editProduct()

    /**
     * Function to update the products & components in the rent_product &
     * rent_product_component table
     *
     * @access public
     * @return void
     */
    public function updateComponenttoDB()
    {
        $p = array();
        $data = array();
        $product_name = isset($_REQUEST['product_name']) ? $_REQUEST['product_name'] : '';
        $data['name'] = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $data['quantity'] = isset($_REQUEST['quantity']) ? $_REQUEST['quantity'] : '';
        $data['rent_price'] = isset($_REQUEST['rent_price']) ? $_REQUEST['rent_price'] : '';
        $data['id'] = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($product_name  == '' || $data['name'] == '' || $data['rent_price'] == '' || $data['quantity'] == '') {
            $p['failed'] = "Missing Params";
            $this->_my_output('addComponent', $p);
            return;
        }

        $c_id = $this->rentComponents->update($data);
        $result = $this->rentProduct->getIdByName($product_name);
        foreach($result as $row)
            $p_id = $row['id'];
        $data['component_id'] = $data['id'];
        $data['product_id'] = $p_id;
        //print_r($data); die();
        $id = $this->rentProductComponent->update($data);

        $this->_my_output('addComponent', $p);
    } //end: function updateProducttoDB


    /**
     * Function suggest_component
     */
    public function suggest_component()
    {

        $key = $_REQUEST['term'];
        $p['components'] = $this->rentComponents->getNameByKey($key);
        foreach ($p['components'] as $brand) {
            $brand['label'] = $brand['name'];
            $brand['quantity'] = $brand['quantity'];
            $brand['quantity'] = $brand['rent_price'];
            $params[] = $brand;
        }

        echo json_encode($params);
        return;
    }

    public function displayComponentById()
    {
        $p['name'] = $_REQUEST['name'];
        $p['components'] = $this->rentComponents->getNameByKey($p['name']);
        $this->load->view('rent/addProductComponent', $p);
    }

    /**
     * Add Products function is to add rented products
     *
     * @access public
     * @return void
     */
    public function manageProducts()
    {

        $fields = array('ID' => 'p.id as id', 'NAME' => 'p.product_name as name',
            'Description' => 'p.description as description');
        $table = "rent_product p";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('rent/editProduct?ajax=1'), "css" => "btn btn-primary action-btn fancybox"),
            '<i class="icon-trash icon-white"></i>' => array("url" => site_url('rent/deleteProduct?ajax=1'), "css" => "btn btn-danger action-btn fancybox")
        );
        $where = 'where p.status = 1';
        $orderby = " order by p.`id` ASC";
        $p['tab'] = 'rent_manage_products';
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $this->_my_output('manageProduct', $p);
    } //end: function addProducts

    /**
     * Display products function is to display all the rented products in the
     * database
     *
     * @access public
     * @return void
     */
    public function displayProducts()
    {

    } //end: function displayProducts()

    /**
     * Function to add rented products in the table rent_product
     *
     * @access public
     * @return boolean
     */
    public function addProduct()
    {

        $p = array();
        $p['class'] = $this->rentCategory->getAll();
        $this->load->view('rent/addProduct', $p);
    } //end: function addProducts()

    /**
     * Function to add products in to table rent_product.
     *
     * @access  public
     * @return  void
     */
    public function addProductoDB()
    {
        $p = array();
        $data['product_name'] = isset($_REQUEST['product_name']) ? $_REQUEST['product_name'] : '';
        $data['description'] = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        $data['rent_price'] = isset($_REQUEST['rent_price']) ? $_REQUEST['rent_price'] : '';
        $data['quantity'] = isset($_REQUEST['quantity']) ? $_REQUEST['quantity'] : '';
        $data['category_id'] = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '';
        //$data['deposit']        = isset($_REQUEST['deposit'])?$_REQUEST['deposit']:'';

        if ($data['product_name'] == '' || $data['rent_price'] == '' || $data['quantity'] == '' || $data['category_id'] == '') {
            $p['failed'] = "Missing Params";
            $this->_my_output('addProduct', $p);
            return;
        }

        $id = $this->rentProduct->add($data);
        if (isset($_REQUEST['component_name'])) {
            $componentName = $_REQUEST['component_name'];
            $componentQuantity = $_REQUEST['component_quantity'];
            $componentPrice = $_REQUEST['component_rentprice'];


            if (count($componentName) == count($componentQuantity)) {
                $totalComponents = count($_REQUEST['component_name']);
                for ($i = 0; $i < $totalComponents; $i++) {
                    $data = array();
                    $data['name'] = $componentName[$i];
                    $data['quantity'] = $componentQuantity[$i];
                    $data['rent_price'] = $componentPrice[$i];
                    $componentId = $this->rentComponents->add($data);

                    if ($componentId != '') {
                        $data = array();
                        $data['component_id'] = $componentId;
                        $data['product_id'] = $id;
                        $components[] = $this->rentProductComponent->add($data);
                    }
                }
            }
        //this loop is for creating attributes array
            foreach ($_REQUEST['components'] as $row) {
                $data = array();
                $data['component_id'] = $row;
                $data['product_id'] = $id;
                $components[] = $this->rentProductComponent->add($data);
            }
            if ($id !== false && count($components) == count($_REQUEST['components'])) {
                $p['success'] = "Successfully added! - ID:" . $id;
            } else {
                $p['failed'] = "Vendor Company is already exists!";
            }
        }
        $this->_my_output('addProduct', $p);
    } // end: function addCategoryDB()


    /**
     * Function to update the products & components in the rent_product &
     * rent_product_component table
     *
     * @access public
     * @return void
     */
    public function updateProducttoDB()
    {

        $p = array();
        $components = array();
        $data = array();
        $data['product_name'] = isset($_REQUEST['product_name']) ? $_REQUEST['product_name'] : '';
        $data['description'] = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        $data['rent_price'] = isset($_REQUEST['rent_price']) ? $_REQUEST['rent_price'] : '';
        $data['quantity'] = isset($_REQUEST['quantity']) ? $_REQUEST['quantity'] : '';
        $data['category_id'] = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '';
        $data['id'] = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $product_id = $data['id'];
        if ($data['product_name'] == '' || $data['rent_price'] == '' || $data['quantity'] == '' || $data['category_id'] == '') {
            $p['failed'] = "Missing Params";
            $this->_my_output('addProduct', $p);
            return;
        }

        $id = $this->rentProduct->update($data);

        if (isset($_REQUEST['component_name'])) {

            $componentName = $_REQUEST['component_name'];
            $componentQuantity = $_REQUEST['component_quantity'];
            $componentPrice = $_REQUEST['component_rentprice'];


            if (count($componentName) == count($componentQuantity)) {
                $totalComponents = count($_REQUEST['component_name']);
                for ($i = 0; $i < $totalComponents; $i++) {
                    $data = array();
                    $data['name'] = $componentName[$i];
                    $data['quantity'] = $componentQuantity[$i];
                    $data['rent_price'] = $componentPrice[$i];
                    $componentId = $this->rentComponents->add($data);

                    if ($componentId != '') {
                        $data = array();
                        $data['component_id'] = $componentId;
                        $data['product_id'] = $product_id;
                        $components[] = $this->rentProductComponent->add($data);
                    }
                }
            }
        }
        if (isset($_REQUEST['componentrids'])) {
            //this loop is for creating attributes array
            foreach ($_REQUEST['componentrids'] as $row) {
                $data = array();
                $data['id'] = $row;
                $data['product_id'] = $product_id;
                $this->rentProductComponent->update($data);
            }
        }
        if (isset($_REQUEST['components'])) {
            //this loop is for creating attributes array
            foreach ($_REQUEST['components'] as $row) {
                $data = array();
                $data['component_id'] = $row;
                $data['product_id'] = $product_id;
                $components[] = $this->rentProductComponent->add($data);
            }
        }
        if ($id !== false) {
            $p['success'] = "Successfully added! - ID:" . $id;
        } else {
            $p['failed'] = "Vendor Company is already exists!";
        }
        $this->_my_output('addProduct', $p);
    } //end: function updateProducttoDB

    /**
     * Function to edit the rent products in the table rent_product.
     *
     * @access public
     * @return void
     */
    public function editProduct()
    {
        $p = array();
        $id = $_REQUEST['id'];
        $p['product'] = $this->rentProduct->getById($id);
        $p['categories'] = $this->rentCategory->getAll();
        $p['components'] = $this->rentProductComponent->getAllByProductId($id);

        $this->load->view('rent/editProduct', $p);
    } //end : function editProduct()

    /**
     * Function to delete product from the rent_product table
     *
     * @access public
     * @return void
     *
     */
    public function deleteProduct()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this->_my_output('error', $p);
            return;
        }

        $r = $this->rentProduct->deleteById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['msg'] = "Successfully Deleted, Record Id " . $r['id'];
        $this->_my_output('success', $p);
    } //end:function deleteProductDB


    /**
     * Function to Add/Update/Delete categories of all the rented products and
     * its items.
     *
     * @access public
     * @return void
     */
    public function manageCategory()
    {

        $p = array();

        $fields = array("ID" => "a.id as id", "NAME" => "a.category_name as name", "PARENT" => "b.category_name as parent_name");
        $table = " rent_category a, rent_category b ";
        $where = " where a.parent_id = b.id AND a.id > 0 AND a.status = 1 ";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('rent/editCategory?ajax=1'), "css" => "btn btn-primary action-btn fancybox"),
            '<i class="icon-trash icon-white"></i>' => array("url" => site_url('rent/deleteCategory?ajax=1'), "css" => "btn btn-danger action-btn fancybox")
        );
        $orderby = " order by `a`.`category_name` ASC";

        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $p['tab'] = 'rent_manage_category';
        $this->_my_output('manageCategory', $p);


    } // end: function manageCategories()

    /**
     * Function to add categories to the rent_category table
     *
     * @access public
     * @return void
     *
     */
    public function addCategory()
    {
        $p = array();
        $p['class'] = $this->rentCategory->getAll();
        $this->load->view('rent/addCategory', $p);
    } // end: function addCategory()


    /**
     * Function to add categories in to table rent_categories.
     *
     * @access  public
     * @return  void
     */
    public function addCategoryDB()
    {
        $p = array();
        $category_name = isset($_REQUEST['category_name']) ? $_REQUEST['category_name'] : '';
        $parentId = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : '';

        if ($category_name == '' || $parentId == '') {
            $p['failed'] = "Missing Params";
            $this->_my_output('addCategory', $p);
            return;
        }

        $id = $this->rentCategory->add($category_name, $parentId, $this->user->loggedInUserId());
        if ($id !== false) {
            $p['success'] = "Successfully added! - ID:" . $id;
        } else {
            $p['failed'] = "Vendor Company is already exists!";
        }
        $this->_my_output('addCategory', $p);
    } // end: function addCategoryDB()

    /**
     * Function to edit the categories, updates the existing records.
     *
     * @access public
     * @return void
     */
    public function updateCategoryDB()
    {
        $p = array();
        $category_name = isset($_REQUEST['category_name']) ? $_REQUEST['category_name'] : '';
        $parentId = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : '';
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

        if ($category_name == '' || $parentId == '' || $id == '') {
            $p['failed'] = "Missing Params";
            $this->_my_output('error', $p);
            return;
        }

        if ($this->rentCategory->update($id, $category_name, $parentId)) {
            $p['success'] = "Updated - ID:" . $id;
        } else {
            $p['success'] = "Vendor is already exists or no changes to vendor Details!";
        }

        $p['autoclose'] = true;
        $this->_my_output('success', $p);
    } // end: function updateCateoryDB


    /**
     * Function to delete category from the rent_category table
     *
     * @access public
     * @return void
     *
     */
    public function deleteCategory()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this->_my_output('error', $p);
            return;
        }

        $r = $this->rentCategory->deleteById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['msg'] = "Successfully Deleted, Record Id " . $r['id'];
        $this->_my_output('success', $p);
    } //end:function deleteCategoryDB

    /**
     * Function to edit categories of the ren_category table
     *
     * @access public
     * @param $id integer
     * @return void
     */
    public function editCategory()
    {
        $p = array();
        $id = $_REQUEST['id'];
        $p['category'] = $this->rentCategory->getById($id);
        $p['categories'] = $this->rentCategory->getAll();
        $this->load->view('rent/editCategory', $p);
    }

    /**
     * Function to manage orders related to rent section
     *
     * @access public
     * @return void
     */
     public function booking()
    {
      //debugbreak();
        $p = array();
        $p['tab'] = 'rent_bookings';
        $this->_my_output('booking', $p);
        //$this->load->view('rent/booking', $p);

    }
    public function manageOrders()
    {
      //debugbreak();
        $p = array();
        $fields = array("ID" => "a.id as id", "NAME" => "b.product_name as name");
        $table = " rent_order a, rent_product b ";
        $where = " where a.rent_product_id = b.id AND a.status = 1 ";
        $actions = array(
            'Invoice' => array("url" => site_url('rent/invoice?ajax=0'), "css" => "btn btn-primary action-btn"),
            '<i class="icon-trash icon-white"></i>' => array("url" => site_url('rent/deleteOrder?ajax=1'), "css" => "btn btn-danger action-btn fancybox")
        );
        $orderby = " order by `a`.`id` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $p['tab'] = 'rent_bookings';
        $this->_my_output('booking', $p);
        //$this->load->view('rent/booking', $p);

    } //end: function manageOrders()

    /**
     * Function to display add an order in the table rent_order
     *
     * @access public
     * @return void
     */
    public function addOrder()
    {
        $p = array();
        $p['products'] = $this->rentProduct->getAllProducts();
        $this->load->view('rent/addOrder', $p);
    } //end: function addOrder()

    /**
     * Function to generate Invoice
     *
     * @access public
     * @return void
     */
    public function invoice()
    {
        $p = array();
        $p['categories'] = $this->rentCategory->getAll();
        $p['tab'] = 'rent_invoice';
        $this->_my_output('invoice', $p);
    } //end: function invoice

    /**
     * Function to  fetch product list for the ajax call
     *
     * @access public
     * @return string $json_data
     */
    public function select_product()
    {

        $key = $_REQUEST['term'];
        $p['products'] = $this->rentProduct->getNameByKey($key);
        foreach ($p['products'] as $brand) {
            $brand['label'] = $brand['name'];
            $params[] = $brand;
        }

        echo json_encode($params);
        return;
    } //end: function select_product

    public function displayProductDetailsById()
    {
        $p = array();

        $p['data'] = $this->rentProduct->getByName($_REQUEST['name']);
        //if ($p['data']['products']['id'] != '')
           // $p['components'] = $this->rentProductComponent->getAllByProductId($p['data']['products']['id']);
        $new_data['data'] = $p['data']; 

        $new_data['view_output'] = $this->load->view('rent/displayRecord', $p, true);
        
        echo json_encode($new_data);
        return;

    } 

    public function displayComponentDetailsById()
    {
        $p = array();

        $p['data'] = $this->rentProduct->getByName($_REQUEST['name']);
        //if ($p['data']['products']['id'] != '')
           // $p['components'] = $this->rentProductComponent->getAllByProductId($p['data']['products']['id']);
        if(isset($_REQUEST['component']))
            $p['component'] = $_REQUEST['component'];
        $new_data['view_output'] = $this->load->view('rent/displayRecord', $p, true);
        
        echo json_encode($new_data);
        return;

    }
    
    /**
     * Function to fetch the product using product id and displaying in the grid
     *
     * @access  public
     * @param   integer $product_id
     * @return  string  $returnValue
     */
    public function displayProductById()
    {
        $p = array();

        $p['data'] = $this->rentProduct->getByName($_REQUEST['name']);
        //if ($p['data']['products']['id'] != '')
           // $p['components'] = $this->rentProductComponent->getAllByProductId($p['data']['products']['id']);
        
        $this->load->view('rent/displayRecord', $p);


    } 

    public function addComponenttoBooking()
    {
        $p = array();

        $p['data'] = $this->rentProduct->getByName($_REQUEST['product_name']);
        //if ($p['data']['products']['id'] != '')
           // $p['components'] = $this->rentProductComponent->getAllByProductId($p['data']['products']['id']);
        //print_r($p['data']); die();
        $new_data['output'] = $this->load->view('rent/displayRecord', $p);
        echo json_encode($new_data);
        return;

    }

    /**
     * Function to fetch the components list using the product id from the
     * rent_components table
     *
     * @access public
     * @return String $returnValue
     */
    public function getComponentsByProductId()
    {

        $product_id = $_REQUEST['id'];
        $p['components'] = $this->rentComponent->getAllByProductId($product_id);
        $this->load->view('rent/componentList', $p);
    } //end : function getComponentsByProductId

    /**
     * Function to display the confirmation of invoice
     *
     * @access public
     * @return void
     */
    public function invoiceConfirmation()
    {
        $p = array();
        $p['data'] = $_REQUEST;

        $p['tab'] = 'bookings';
        $this->_my_output('invoiceConfirmation', $p);
    } //end: function invoiceConfirmation

    /**
     * function to submit the booking details in to the booking tables
     *
     * @access public
     */
    public function submitBooking()
    {
        $p = array();
        $components = array();
        $data = $_SESSION['bookingData'];

        $p['tab'] = 'bookings';
        $bookingData['cname'] = $data['customer_id'];
        $bookingData['delivery_date'] = $data['delivery_date'];
        $bookingData['noofdays'] = $data['return_date'];
        $bookingData['rent_amount'] = $data['total_rent'];
        $bookingData['deposit'] = $data['deposit'];
        $bookingData['balance'] = $data['balance'];
        $bookingData['ordertype'] = 1;
        //Inserting in to the rent booking table
        $bookingId = $this->rentBooking->insert($bookingData);

        if (isset($data['product_id'])) {
            foreach ($data['product_id'] as $key => $val) {
                $bookingComponent['bookingId'] = $bookingId;
                $bookingComponent['productId'] = $data['product_id'][$key];
                $bookingComponent['productName'] = $data['product_name'][$key];
                $bookingComponent['quantity'] = $data['product_quantity'][$key];
                $bookingComponent['rent_price'] = $data['product_price'][$key];
                $bookingComponent['componentId'] = '1';

                //Inserting in to the rent product booking table
                $componentBookingId = $this->rentComponentBooking->insert($bookingComponent);
            }
        }

        //inserting in to Booking Product table
        if ($bookingId != '') {
            $p['billInfo'] = $this->rentBooking->getDataById($bookingId, 1);
            $p['customerInfo'] = $this->customer->getById($p['billInfo']['customer_id']);
            $p['itemInfo'] = $this->rentComponentBooking->getDataByBookingId($bookingId);
        }
        $p['tab'] = 'bookings';
        $this->_my_output('submitBooking', $p);
    } // end: function submitBooking

    /**
     * Function to display the all bookins
     */
    public function viewBookings()
    {
      // debugbreak();
       $p['ordertype'] = $_REQUEST['ordertype'];
        $p['bookings'] = $this->rentBooking->getAllBookings($p['ordertype']);
        $p['html'] = $this->load->view('rent/viewBookings', $p);
       echo $p['html'];
    }

    public function viewBill()
    {
        $bookingId = $_REQUEST['id'];
        $p['ordertype'] = $_REQUEST['ordertype'];
        if ($bookingId != '') {
            $p['billInfo'] = $this->rentBooking->getDataById($bookingId, $p['ordertype']);
            $p['customerInfo'] = $this->customer->getById($p['billInfo']['customer_id']);
            $p['itemInfo'] = $this->rentComponentBooking->getDataByBookingId($bookingId);
        }
        $p['html'] = $this->load->view('rent/viewBill', $p);
        echo $p['html'];
    }

    /**
     * Function to display the products and components stock.
     *
     * @access public
     * @return void
     */
    public function displayProductStock()
    {
        $p = array();
        $p['type'] = '';
        $fields = array("ID" => "a.id as id", "NAME" => "a.product_name as name",
            "Description" => "a.description as description", "Quantity" => "b.quantity");
        $table = " rent_product a, rent_product_stock b ";
        $where = " where a.id = b.rent_product_id AND a.status = 1 ";
        $actions = array(
            'Components' => array("url" => site_url('rent/displayComponentsStock?type=2&ajax=1'), "css" => "btn btn-primary action-btn fancybox"),
        );
        $orderby = " order by `a`.`id` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $p['tab'] = 'stock';
        $this->_my_output('displayStock', $p);
    } //end: function displayStock

    /**
     * Function to display the components stock.
     *
     * @access public
     * @return void
     */
    public function displayComponentsStock()
    {
        $p = array();
        $fields = array("ID" => "a.id as id", "NAME" => "a.name as name",
            "Quantity" => "b.quantity");
        $table = " rent_components a, rent_component_stock b ";
        $where = " where a.id = b.rent_component_id  ";
        $actions = array();
        $orderby = " order by `a`.`id` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $p['tab'] = 'rent_stock';
        $this->_my_output('displayStock', $p);
    } //end: function displayComponentsStock

    /**
     * Function to display the transaction reports
     *
     * @access public
     * @return void
     */
    public function transactionReports()
    {
        $p = array();
        $p['tab'] = 'rent_reports';
        $this->_my_output('transactionReport', $p);
    } //end: function transactionReports

    function split_date($date)
    {
        $reportdate = explode("To", urldecode($date));
        if (!empty($reportdate[1])) {
            $frm = $reportdate[0];
            $to = date('Y-m-d', strtotime('0 day', strtotime($reportdate[1])));
        }
        else {
            $frm = $reportdate[0];
            $to = date('Y-m-d', strtotime('0 day', strtotime($date)));
        }
        return array($frm, $to);
    }

    /**
     * Function to generate reports based on the from and to date
     */
    public function displayReports()
    {
        $from = $this->split_date($_REQUEST['from']);
        $to = $this->split_date($_REQUEST['to']);
        $p['report'] = $this->rentBooking->getDataByDate($from, $to);
        $p['tab'] = 'reports';
        $this->load->view('rent/displayReports', $p);
    }

    /**
     * Function to fetch the booking details and do a pikcup
     *
     * @access public
     * @return void
     */
    public function pickup()
    {
        $p = array();
        $p['tab'] = 'rent_pickup';
        $this->_my_output('pickup', $p);
    }

    // end: function pikcup

    /**
     * Function to display the confirmation of invoice
     *
     * @access public
     * @return void
     */
    public function pickupConfirmation()
    {
        $p = array();
        $p['data'] = $_REQUEST;

        $p['tab'] = 'pickup';
        $this->_my_output('pickupConfirmation', $p);
    } //end: function invoiceConfirmation

    /**
     * Function to submit the pickup information to database
     *
     * @access public
     *
     */
    public function submitPickup()
    {
        $p = array();
        $components = array();
        $data = $_SESSION['pickupData'];

        $p['tab'] = 'Bookings';
        $bookingData['bid'] = $data['bookingId'];
        $bookingData['cname'] = $data['customer_id'];
        $bookingData['delivery_date'] = $data['delivery_date'];
        $bookingData['noofdays'] = $data['return_date'];
        $bookingData['rent_amount'] = $data['total_rent'];
        $bookingData['total_negotiation'] = 0;
        $bookingData['bill_total'] = 0;
        $bookingData['deposit'] = $data['deposit'];
        $bookingData['ordertype'] = 2;

        //Inserting in to the rent booking table
        $bookingId = $this->rentBooking->update($bookingData);

        if (isset($data['pcomponents'])) {
            foreach ($data['pcomponents'] as $key => $val) {

                if ($val != '') {
                    $bookingComponent['cid'] = $val;
                    $bookingComponent['bookingId'] = $data['bookingId'];
                    $bookingComponent['productId'] = $data['pcomponent_pid'][$key];
                    $bookingComponent['componentId'] = $data['pcomponent_cid'][$key];
                    $bookingComponent['quantity'] = $data['pcomponent_quantity'][$key];
                    $bookingComponent['rent_price'] = $data['pcomponent_price'][$key];
                    $bookingComponent['negotiated_amt'] = '';
                    //Inserting in to the rent product booking table
                    $componentBookingId = $this->rentComponentBooking->update($bookingComponent);


                } else {
                    $bookingComponent['bookingId'] = $data['bookingId'];
                    $bookingComponent['productId'] = $data['pcomponent_pid'][$key];
                    $bookingComponent['componentId'] = $data['pcomponent_cid'][$key];
                    $bookingComponent['quantity'] = $data['pcomponent_quantity'][$key];
                    $bookingComponent['rent_price'] = $data['pcomponent_price'][$key];
                    $bookingComponent['negotiated_amt'] = '';

                    //Inserting in to the rent product booking table
                    $componentBookingId = $this->rentComponentBooking->insert($bookingComponent);

                }
                $componentStock = $this->rentComponentStock->getAllByComponentsId($bookingComponent['componentId']);
                $updateComponentStock = $componentStock[0]['quantity'] - $bookingComponent['quantity'];
                $updatedStock['rent_component_id'] = $bookingComponent['componentId'];
                $updatedStock['id'] = $componentStock[0]['id'];
                $updatedStock['quantity'] = $updateComponentStock;
                $this->rentComponentStock->update($updatedStock);
            }
        }
        if ($data['bookingId'] != '') {
            $p['billInfo'] = $this->rentBooking->getDataById($data['bookingId'], 2);
            $p['customerInfo'] = $this->customer->getById($p['billInfo']['customer_id']);
            $p['itemInfo'] = $this->rentComponentBooking->getDataByBookingId($data['bookingId']);
        }
        //inserting in to Booking Product table
        $p['tab'] = 'pickup';
        $this->_my_output('submitPickup', $p);
    }

    public function displayBooking()
    {
        $p = array();
        $bookingId = $_REQUEST['id'];
        $p['bookingData'] = $this->rentBooking->getDataById($bookingId, 1);
        if (isset($p['bookingData']['customer_id'])) {
            $p['customerInfo'] = $this->customer->getById($p['bookingData']['customer_id']);
            $p['bookingProductData'] = $this->rentProductBooking->getDataByBookingId($bookingId);
            $p['bookingComponentData'] = $this->rentComponentBooking->getDataByBookingId($bookingId);

            $this->load->view('rent/displayBooking', $p);
        } else {
            echo "No Bookings Available";
        }
    }

    public function displayInvoice()
    {
        $p = array();
        $bookingId = $_REQUEST['id'];
        $p['bookingData'] = $this->rentBooking->getDataById($bookingId, 2);
        if (isset($p['bookingData']['customer_id'])) {
            $p['customerInfo'] = $this->customer->getById($p['bookingData']['customer_id']);
            $p['bookingProductData'] = $this->rentProductBooking->getDataByBookingId($bookingId);
            $p['bookingComponentData'] = $this->rentComponentBooking->getDataByBookingId($bookingId);

            $this->load->view('rent/displayInvoice', $p);
        } else {
            echo "No Bookings Available";
        }
    }

    public function submitInvoice()
    {

        $data = $_REQUEST;
        $bookingData['bid'] = $data['bookingId'];
        $bookingData['cname'] = $data['customer_id'];
        $bookingData['delivery_date'] = $data['delivery_date'];
        $bookingData['noofdays'] = $data['return_date'];
        $bookingData['rent_amount'] = $data['total_rent'];
        $bookingData['deposit'] = $data['deposit'];
        $bookingData['total_negotiation'] = $data['negotiatedamt'];
        $bookingData['bill_total'] = $data['billtotal'];
        $bookingData['ordertype'] = 3;

        //Inserting in to the rent booking table
        $bookingId = $this->rentBooking->update($bookingData);

        if (isset($data['pcomponents'])) {
            foreach ($data['pcomponents'] as $key => $val) {

                if ($val != '') {
                    $bookingComponent['cid'] = $val;
                    $bookingComponent['bookingId'] = $data['bookingId'];
                    $bookingComponent['productId'] = $data['pcomponent_pid'][$key];
                    $bookingComponent['componentId'] = $data['pcomponent_cid'][$key];
                    $bookingComponent['quantity'] = $data['pcomponent_quantity'][$key];
                    $bookingComponent['rent_price'] = $data['pcomponent_price'][$key];
                    $bookingComponent['negotiated_amt'] = $data['pcomponent_negotiation'][$key];

                    //Inserting in to the rent product booking table
                    $componentBookingId = $this->rentComponentBooking->update($bookingComponent);
                } else {
                    $bookingComponent['bookingId'] = $data['bookingId'];
                    $bookingComponent['productId'] = $data['pcomponent_pid'][$key];
                    $bookingComponent['componentId'] = $data['pcomponent_cid'][$key];
                    $bookingComponent['quantity'] = $data['pcomponent_quantity'][$key];
                    $bookingComponent['rent_price'] = $data['pcomponent_price'][$key];
                    $bookingComponent['negotiated_amt'] = $data['pcomponent_negotiation'][$key];

                    //Inserting in to the rent product booking table
                    $componentBookingId = $this->rentComponentBooking->insert($bookingComponent);
                }
                $componentStock = $this->rentComponentStock->getAllByComponentsId($bookingComponent['componentId']);
                $updateComponentStock = $componentStock[0]['quantity'] + $bookingComponent['quantity'];
                $updatedStock['rent_component_id'] = $bookingComponent['componentId'];
                $updatedStock['id'] = $componentStock[0]['id'];
                $updatedStock['quantity'] = $updateComponentStock;
                $this->rentComponentStock->update($updatedStock);
            }
        }
        if ($data['bookingId'] != '') {
            $p['billInfo'] = $this->rentBooking->getDataById($data['bookingId'], 3);
            $p['customerInfo'] = $this->customer->getById($p['billInfo']['customer_id']);
            $p['itemInfo'] = $this->rentComponentBooking->getDataByBookingId($data['bookingId']);
        }
        //inserting in to Booking Product table
        $p['tab'] = 'invoice';
        $this->_my_output('submitInvoice', $p);
    }

    public function deleteComponentById()
    {
        $id = $_REQUEST['name'];
        $this->rentProductComponent->deleteById($id);
    }


    /**
     * Function to delete product from the rent_product table
     *
     * @access public
     * @return void
     *
     */
    public function deleteComponent()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this->_my_output('error', $p);
            return;
        }

        $r = $this->rentComponents->deleteById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['msg'] = "Successfully Deleted, Record Id " . $r['id'];
        $p['tab'] = 'manageComponents';
        $this->_my_output('success', $p);
    } //end:function deleteProductDB
} // end: class rent

?>
