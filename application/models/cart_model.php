<?php
/**
 * File Name: cart_model.php
 * Author: Rajat
 * Date: 5/21/12
 * Time: 12:10 PM
 */
class Cart_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function create($user_id, $customer_id, $branch_id, $status = 1)
    {
        $this->db->select('id');
        $q = $this->db->get_where('cart', array('customer_id' => $customer_id));
        if ($q->num_rows > 0) {
            $q = $q->row_array();
            $this->emptyCart($q['id']);
            return $q['id'];
        }
        $created_at = date('Y-m-d H:i:s');
        $sql = "insert into `cart` (`user_id`, `customer_id`, `status`, `created_at`)" .
            " values (?,?,?,?)";
        $r = $this->db->query($sql, array($user_id, $customer_id, $status, $created_at));
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function updateCart($id, $items = array())
    {
    }

    public function add_item($cart_id, $item_entity_id, $item_specific_id, $quantity, $price, $vat, $discount, $final_amount, $branch_id = 0)
    {
        $created_at = date('Y-m-d H:i:s');
        $sql = "insert into `cart_item`(`cart_id`, `item_entity_id`, `item_specific_id`, `quantity`, `price`, `vat`, `discount`, `final_amount`, `branch_id`, `created_at`) values (?,?,?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($cart_id, $item_entity_id, $item_specific_id, $quantity, $price, $vat, $discount, $final_amount, $branch_id, $created_at));
        if ($this->db->affected_rows() > 0) {
            return $item_specific_id;
        }
        return false;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `cart` where `id` = ?", array($id));
        $cart = $q->row_array();
        $cart['items'] = $this->getItems($cart['id']);
        return $cart;
    }

    public function getByCustomerId($customer_id)
    {
        if ($customer_id == '') {
            return False;
        }
        $q = $this->db->query("select * from `cart` where `customer_id` = ? LIMIT 1", array($customer_id));
        if ($q->num_rows() > 0) {
            $cart = $q->row_array();
            $cart['items'] = $this->getItems($cart['id']);
            return $cart;
        }
        return False;
    }

    public function getItems($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `cart_item` where `cart_id` = ?", array($id));
        return $q->result_array();
    }

    public function getByItemID($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `cart_item` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id']) && (!is_array($r['items']) || count($r['items']) < 1)) {
            $q = $this->db->query("delete from `cart` where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function emptyCart($id)
    {
        $q = $this->db->query("delete from `cart_item` where `cart_id` = ?", array($id));
        if ($this->db->affected_rows() <= 0) {
            return false;
        }
        return True;
    }

    public function emptyCartByCustomerId($customer_id)
    {
        $cart = $this->getByCustomerId($customer_id);
        if (!$cart) {
            return False;
        }
        return $this->emptyCart($cart['id']);
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `cart`");
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function invoiceReport($date)
    {
        $data = $this->db->query("select a.*,b.fname,b.lname  from cart a
								LEFT JOIN customers b on a.customer_id = b.id
								where a.created_at >= ? and a.created_at < ?",
            array($date[0], $date[1]))->result_array();
        return $data;
    }
}

/*END OF FILE*/