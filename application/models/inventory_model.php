<?php
class Inventory_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model('rate_model', 'rm');
        $this->load->model('item_entity_model', 'item_entity');
        $this->load->model('bill_model', 'bill');
        $this->load->model('product_sku_model', 'prod_sku');
        $this->load->model('category_model','category');

    }

    /*central_stock table :: 21/3/2012
    +------------------+--------------+------+-----+---------+----------------+
    | Field            | Type         | Null | Key | Default | Extra          |
    +------------------+--------------+------+-----+---------+----------------+
    | id               | int(11)      | NO   | PRI | NULL    | auto_increment |
    | item_entity_id   | int(11)      | NO   |     | NULL    |                |
    | item_specific_id | int(11)      | NO   |     | NULL    |                |
    | branch_id        | int(11)      | NO   |     | NULL    |                |
    | quantity         | float        | NO   |     | NULL    |                |
    | weight           | float        | YES  |     | NULL    |                |
    | updated_at       | datetime     | NO   |     | NULL    |                |
    | additional       | varchar(100) | YES  |     | NULL    |                |
    | deleted          | tinyint(4)   | NO   |     | 0       |                |
    +------------------+--------------+------+-----+---------+----------------+*/
    function getInventory($whereClause = "", $select)
    {
        // ;
        // $inventory = $this->db->query("select a.*,b.name from central_stock a LEFT JOIN item_entity b on a.item_entity_id=b.id")->result_array();
        $where = "a.deleted = 0";
        if (!empty($select)) {
            $where .= " and b.name= '" . $select . "'";
        }
        // if(!empty($get)) {$where.=" and b.id='".$get['id']."'";}
        $this->db->select("a.*,b.name,b.display_name,c.name as branch_name");
        $this->db->join("item_entity b", "a.item_entity_id=b.id", "LEFT");
        $this->db->join("branch c", "c.id=a.branch_id", "LEFT");
        if (!empty($whereClause)) {
            $where .= " AND ";
            $where .= $whereClause;
        }
        $this->db->where($where);
        $inventory = $this->db->get("central_stock a")->result_array();
        $i = 0;
        foreach ($inventory as $inv) {
            $tbl = $inv['name'];
            $op_id = $this->item_entity->getEntityId('ornament_product');
            if ($inv['item_entity_id'] == $op_id) {
                $wherecl = "a.item_entity_id ='" . $inv['item_entity_id'] . "'"; //if(!empty($get)) {$wherecl.= " and c.name like '%".($txt)."%'";}
                $this->db->select("a .branch_id,a.quantity,a.weight,c.*");
                $this->db->join("ornament_product b", "a.item_specific_id = b.id", "LEFT");
                $this->db->join("ornament c", "b.ornament_header_id = c.id", "LEFT");
                if (!empty($wherecl)) {
                    $this->db->where($wherecl);
                }
                $data = $this->db->get("central_stock a")->row_array();
                //$inventory[$i][$tbl] = $data;
            } else {
                $this->db->select("*");
                $wherecl = "deleted = 0 and id ='" . $inv['item_specific_id'] . "'";
                //  if(!empty($get)) {$wherecl.=" and name like '%".($get['txt'])."%'";}
                $this->db->where($wherecl);
                $data = $this->db->get("$tbl")->row_array();
                // ;
            }
            $inventory[$i][$tbl] = $data;
            $i++;
        }
        return array(count($inventory), $inventory);
    }

    function search($get, $tbl)
    {
        // ;
        $txt = $get['txt'];
        $invtry = $this->db->query("SELECT a.display_name as name_type,b.*,c.*,d.name as branch_name FROM item_entity a LEFT JOIN central_stock b ON a.id = b.item_entity_id LEFT JOIN $tbl c ON b.item_specific_id = c.id left join branch d on b.branch_id=d.id WHERE a.id ='" . $get['id'] . "'  AND c.name LIKE '%$txt%'")->result_array();
        return $invtry;
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE central_stock SET `deleted` = '1' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `central_stock` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function add($item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $force_new = 0, $additional = '', $user_id = 0, $reference_id = 0)
    {
        if ($force_new == 1) {
            $return_array = $this->insert($item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $additional);
            $central_stock_id = $return_array['id'];
            //log_message('error', 'In inventory model:'. print_r($central_stock_id, 1));
            $transaction_id = $this->transaction($central_stock_id, $user_id, $quantity, $weight, 0, $quantity, 0, $weight, $additional, $reference_id);
            return array('central_stock_id' => $central_stock_id, 'transaction_id' => $transaction_id);
        } else if ($force_new == -1) {
            //update sql
            $sql = "";
        } else {
            $check = $this->db->query("select id, quantity, weight from central_stock where item_entity_id= ? and item_specific_id = ? AND branch_id = ?",
                array($item_entity_id, $item_specific_id, $branch_id));
            if ($check->num_rows > 0) {
                $c = $check->row_array();
                $id = $c['id'];
                $quantity_added = $quantity;
                $quantity = $c['quantity'] + $quantity;
                $weight_added = $weight;
                $weight = $c['weight'] + $weight;
                if ($quantity < 0 || $weight < 0) {
                    $return_array['status'] = False;
                }
                $update_response = $this->update($id, $item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $additional = '');
                if ($update_response['status']) {
                    $transaction_id = $this->transaction($id, $user_id, $quantity_added, $weight_added, $c['quantity'], $quantity, $c['weight'], $weight, $additional, $reference_id);
                    //log_message('error', 'In inventory second place:'. print_r($transaction_id, 1));
                    return array('central_stock_id' => $id, 'transaction_id' => $transaction_id);
                } else {
                    return $update_response;
                }
            } else {
                $return_array = $this->insert($item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $additional);
                if (isset($return_array['status']) && !$return_array['status']) {
                    return $return_array;
                }
                $central_stock_id = $return_array['id'];
                $transaction_id = $this->transaction($central_stock_id, $user_id, $quantity, $weight, 0, $quantity, 0, $weight, $additional, $reference_id);
                $return = array('central_stock_id' => $central_stock_id, 'transaction_id' => $transaction_id);
                return $return;
            }
        }
    }

    public function insert($item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $additional = '')
    {
        if ($quantity < 0 || $weight < 0) {
            return array('status' => False, 'msg' => 'Quantity/Weight can\'t be less than zero!');
        }
        $sql = "INSERT INTO `central_stock` (`item_entity_id`, `item_specific_id`, `branch_id`, `quantity`, `weight`, `updated_at`, `additional`) VALUES (?,?,?,?,?, NOW(),?)";
        $this->db->query($sql, array($item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $additional));
        if ($this->db->affected_rows() > 0) {
            $p['id'] = $this->db->insert_id();
        }
        if ($this->db->affected_rows() <= 0) {
            $p['status'] = false;
            $p['msg'] = 'Database Error occurred while inserting new item.';
            return $p;
        }
        $p['status'] = true;
        $p['msg'] = 'Inventory updated with new item.';
        return $p;
    }

    public function update($id, $item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $additional = '')
    {
        if ($quantity < 0 || $weight < 0) {
            return array('status' => False, 'msg' => 'Quantity/Weight can\'t be less than zero!');
        }
        $data = array(
            'item_entity_id' => $item_entity_id,
            'item_specific_id' => $item_specific_id,
            'branch_id' => $branch_id,
            'quantity' => $quantity,
            'weight' => $weight,
            'updated_at' => 'NOW()',
        );
        if (!empty($additional)) {
            $data['additional'] = $additional;
        }
        $this->db->where('id', $id);
        $this->db->update('central_stock', $data);
        return array('status' => True);
    }

    /*transaction table :: 21/3/2012
    +------------------+--------------+------+-----+---------+-------+
    | Field            | Type         | Null | Key | Default | Extra |
    +------------------+--------------+------+-----+---------+-------+
    | id               | int(11)      | NO   | PRI | NULL    |       |
    | central_stock_id | int(11)      | NO   |     | NULL    |       |
    | user_id          | int(11)      | NO   |     | NULL    |       |
    | created_at       | datetime     | NO   |     | NULL    |       |
    | quantity         | float        | NO   |     | NULL    |       |
    | weight           | float        | YES  |     | NULL    |       |
    | quantity_before  | float        | NO   |     | NULL    |       |
    | quantity_after   | float        | NO   |     | NULL    |       |
    | weight_before    | float        | NO   |     | NULL    |       |
    | weight_after     | float        | NO   |     | NULL    |       |
    | additional       | varchar(200) | NO   |     | NULL    |       |
    +------------------+--------------+------+-----+---------+-------+
    */
    public function transaction($central_stock_id, $user_id, $quantity, $weight, $quantity_before, $quantity_after, $weight_before, $weight_after, $additional = '', $reference_id = 0)
    {
        $trans = array(
            "central_stock_id" => $central_stock_id,
            "user_id" => $user_id,
            "created_at" => date("Y-m-d H:i:s"),
            "quantity" => $quantity,
            "weight" => $weight,
            "quantity_before" => $quantity_before,
            "quantity_after" => $quantity_after,
            "weight_before" => $weight_before,
            "weight_after" => $weight_after,
            "additional" => $additional,
            "reference" => $reference_id,
        );
        $this->db->insert('transaction', $trans);
        $transaction_id = $this->db->insert_id();
        $sub_trans_check = $this->db->query("select b.is_composite,b.is_subtype,a.item_entity_id,a.item_specific_id from item_entity b LEFT JOIN central_stock a on b.id = a.item_entity_id where a.id = ?", $central_stock_id)->row_array();
        if ($sub_trans_check['is_composite'] == 1) {
            $mode = $weight > 0 ? 1 : -1;
            $branch_id = $this->addToSubCentralStock($sub_trans_check['item_entity_id'], $sub_trans_check['item_specific_id'], $mode);
            $this->sub_transaction($sub_trans_check['item_entity_id'], $sub_trans_check['item_specific_id'], $mode);
        }
        if ($sub_trans_check['is_subtype'] == 1) {
            $this->addToSuperTable($sub_trans_check['item_entity_id'], $sub_trans_check['item_specific_id'], $mode, $weight, $quantity, $branch_id, $transaction_id, $reference_id = 0);
        }
        return $transaction_id;
    }

    public function sub_transaction($entity_id, $specific_id, $mode)
    {
        $data = $this->db->query("SELECT d.item_entity_id AS sub_entity_id,b.id as transaction_id,b.reference, d.item_specific_id AS sub_specific_id, d.weight AS sub_weight, d.quantity AS sub_qty, e.weight AS current_weight, e.quantity AS current_qty
        FROM ornament_product_items d
        LEFT JOIN ornament_product c ON c.id = d.ornament_product_id
        LEFT JOIN central_stock a ON a.item_specific_id = c.id
        LEFT JOIN transaction b on a.id = b.central_stock_id
        LEFT JOIN central_stock_items e ON d.item_entity_id = e.item_entity_id
        AND d.item_specific_id = e.item_specific_id
        WHERE a.item_entity_id =?
        AND a.item_specific_id =?", array($entity_id, $specific_id))->result_array();
        foreach ($data as $d) {
            $sub_trans = array(
                "transaction_id" => $d['transaction_id'],
                "item_entity_id" => $d['sub_entity_id'],
                "item_specific_id" => $d['sub_specific_id'],
                "weight" => $d['sub_weight'] * $mode,
                "quantity" => $d['sub_qty'] * $mode,
                "weight_before" => $d['current_weight'],
                "quantity_before" => $d['current_qty'],
                "weight_after" => $d['current_weight'] + ($d['sub_weight'] * $mode),
                "quantity_after" => $d['current_qty'] + ($d['sub_qty'] * $mode),
                "reference_id" => $d['reference']
            );
            $this->db->insert('sub_transaction', $sub_trans);
            //  $this->db->query("update weight set ")
            $this->db->query("update central_stock_items set quantity =? ,weight =? where item_entity_id = ? and item_specific_id=?",
                array($sub_trans['quantity'], $sub_trans['weight'], $sub_trans['item_entity_id'], $sub_trans['item_specific_id']));
        }
    }

    function addToSubCentralStock($item_entity_id, $item_specific_id, $mode)
    {
        $data = $this->db->query("select c.branch_id,a.quantity,a.weight,a.item_entity_id as sub_entity_id,a.item_specific_id as sub_specific_id from ornament_product_items a LEFT JOIN ornament_product b on b.id =ornament_product_id
        LEFT JOIN central_stock c on c.item_specific_id = b.id  where c.item_entity_id=? and c.item_specific_id=?", array($item_entity_id, $item_specific_id))->result_array();
        foreach ($data as $d) {
            $check = $this->db->query("select count(*) from central_stock_items where item_entity_id=? and item_specific_id=?", array($d['sub_entity_id'], $d['sub_specific_id']))->row_array();
            if ($check['count(*)'] == 0) {
                $sub_central_stock = array(
                    "item_entity_id" => $d['sub_entity_id'],
                    "item_specific_id" => $d['sub_specific_id'],
                    "weight" => $d['weight'],
                    "quantity" => $d['quantity'],
                    "branch_id" => $d['branch_id'],
                    "updated_at" => date("Y-m-d H:i:s"),
                );
                $this->db->insert('central_stock_items', $sub_central_stock);
                return $sub_central_stock['branch_id'];
            } else {
                $this->db->query("update central_stock_items set weight = weight + ? , quantity = quantity + ? 
                where item_entity_id = ? and item_specific_id=? ", array($d['weight'] * $mode, $d['quantity'] * $mode, $d['sub_entity_id'], $d['sub_specific_id']));
            }
        }
    }

    function price($arr)
    {
        if (isset($arr['ajax'])) {
            $data = $this->db->query("select a.item_entity_id,a.item_specific_id,b.display_name,c.price from central_stock a LEFT JOIN item_entity b on a.item_entity_id =b.id LEFT JOIN rate c on a.item_entity_id=c.item_entity_id and a.item_specific_id=c.item_specific_id where a.item_entity_id='" . $arr['eid'] . "' and a.item_specific_id='" . $arr['sid'] . "'")->row_array();
            return $data;
        } else {
            $this->rm->setRate($arr['eid'], $arr['sid'], $arr['price']);
            //  $this->db->query("update rate set price='" . $arr['price'] . "' where item_entity_id='" . $arr['eid'] . "' and item_specific_id='" . $arr['sid'] . "'");
        }
    }

    function inventoryReport($id)
    {
        // ;
        $html = "";
        $name = $this->db->query("SELECT name from item_entity where id=?", $id)->row_array();
        $where = "b.item_entity_id =" . $id;
        $this->db->select("a.*,b.weight,c.name as branch_name");
        $this->db->join("central_stock b", "a.id = b.item_specific_id", "LEFT");
        $this->db->join("branch c", "c.id=b.branch_id", "LEFT");
        $data = $this->db->get($name['name'] . " a");
        foreach ($data as $d) {
            $html .= "<option value='" . $d['id'] . "'>" . $d['name'] . "</option>";
        }
        if ($data->num_rows > 1) {
            return array($html, $data->result_array());
        } else {
            return array($html, $data->row_array());
        }
    }

    function InventoryReportData($term, $id)
    {
        //$tbl = array('metal','stone');
        $tbl = $this->item_entity->getEntitySpecificName($id);
        $where = "name like '%" . $term . "%'";
        $this->db->select("distinct(name),id as specific_id");
        //$this->db->join("central_stock a","b.id=a.item_specific_id","LEFT");
        //$this->db->join("item_entity c","c.id=a.item_entity_id","LEFT");
        $this->db->where($where);
        $data = $this->db->get($tbl['entity_name'])->result_array();
        return $data;
    }

    function reportAsBullion($entity_id, $specific_id, $date, $num = "", $offset = "")
    {
        $tbl = $this->db->query("Select name from item_entity where id = ?", $entity_id)->row_array();
        $this->db->select("a.weight as instock,b.name as item_specific_name,d.price,c.created_at,c.quantity as transaction_qty,c.weight as transaction_weight,c.quantity_before,c.quantity_after,c.weight_before,c.weight_after");
        $this->db->join("central_stock a ", "c.central_stock_id = a.id", "LEFT");
        $this->db->join("rate d", "d.item_specific_id = a.item_specific_id AND d.item_entity_id = a.item_entity_id", "LEFT");
        $this->db->join($tbl['name'] . " b", "b.id = a.item_specific_id", "LEFT");
        $where = "a.item_entity_id ='" . $entity_id . "' AND c.created_at >='" . $date[0] . "' AND c.created_at <='" . $date[1] . "'";
        if ($specific_id != 0) {
            $where .= " AND a.item_specific_id=" . $specific_id;
        }
        $this->db->where($where);
        $this->db->order_by("c.created_at", "DESC");
        $this->db->limit($num, $offset);
        $data = $this->db->get("transaction c")->result_array();
        return $data;
    }

    function reportAsSubItem($entity_id, $specific_id, $date, $num = "", $offset = "")
    {
        //		/;
        $where = "b.created_at >='" . $date[0] . "' AND b.created_at <='" . $date[1] . "'";
        $where .= " AND a.item_entity_id=" . $entity_id;
        if ($specific_id != 0) {
            $where .= " AND a.item_specific_id='" . $specific_id . "'";
        }
        $tbl = $this->db->query("SELECT name FROM item_entity where id = ?", $entity_id)->row_array();
        $this->db->select("a.* ,e.weight as ornament_weight, c.name as ornament_name,f.price,b.created_at");
        $this->db->join("transaction b", "b.id = a.transaction_id", "LEFT");
        $this->db->join("central_stock d", "d.id=b.central_stock_id", "LEFT");
        $this->db->join("rate f", "a.item_specific_id = f.item_specific_id  AND a.item_entity_id  = f.item_entity_id", "LEFT");
        $this->db->join("ornament_product e", "e.id=d.item_specific_id", "LEFT");
        $this->db->join("ornament c", "c.id= e.ornament_header_id", "LEFT");
        $this->db->where($where);
        $this->db->order_by("b.created_at", "DESC");
        if (!empty($num)) {
            $this->db->limit($num, $offset);
        }
        $data = $this->db->get("sub_transaction a")->result_array();
        //$data = $this->db->query("select a.*,")
        return $data;
    }

    function getOrnamentName($term)
    {
        $term = mysql_real_escape_string(trim($term));
        $data = $this->db->query("SELECT * FROM `ornament` WHERE `name`  like '%" . $term . "%'")->row_array();
        return $data;
    }

    function ornamentReport($entity_id, $ornament_id, $date, $num = "", $offset = "")
    {
        $this->db->select("a.*,b.name");
        $this->db->join("ornament b", "a.item_specific_id=b.id", "LEFT");
        $where = "a.item_entity_id =" . $entity_id . " AND a.created_at >='" . $date[0] . "' AND a.created_at <= '" . $date[1] . "'";
        if ($ornament_id != 0) {
            $where .= " AND a.item_specific_id=" . $ornament_id;
        }
        $this->db->where($where);
        $this->db->order_by("a.created_at", "asc");
        if (!empty($num)) {
            $this->db->limit($num, $offset);
        }
        $this->db->order_by("a.created_at", "DESC");
        $data = $this->db->get("super_transaction a")->result_array();
        return $data;
    }

    function addToSuperTable($item_entity_id, $item_specific_id, $mode, $weight, $quantity, $branch_id, $transaction_id, $reference_id = 0)
    {
        $entity = $this->item_entity->getHeaderEntity($item_entity_id);
        $entitydata = $this->item_entity->getById($item_entity_id);
        $this->load->model($entitydata['name'] . '_model', $entitydata['name']);
        $specific_item = $this->{$entitydata['name']}->getById($item_specific_id);
        $data = $this->db->query("select * from super_central_stock where item_entity_id=? and item_specific_id=?", array($entity['id'], $specific_item['header_id']))->row_array();
        if (empty($data)) {
            $super_central_stock = array(
                "item_entity_id" => $entity['id'],
                "item_specific_id" => $specific_item['header_id'],
                "branch_id" => $branch_id,
                "quantity" => $quantity,
                "weight" => $weight,
            );
            $this->db->insert('super_central_stock', $super_central_stock);
            $id = $this->db->insert_id();
            $this->db->query("update super_central_stock set updated_at = NOW() where id = ?", $id);
        } else {
            $this->db->query("update super_central_stock set weight = weight + ? , quantity = quantity + ?,updated_at = NOW() where item_entity_id=? and item_specific_id=?", array($weight, $quantity, $entity['id'], $specific_item['header_id']));
        }
        $super_transaction_data = $this->db->query("Select quantity,weight from super_central_stock where item_entity_id=? and item_specific_id=?", array($entity['id'], $specific_item['header_id']))->row_array();
        $super_transaction = array(
            "transaction_id" => $transaction_id,
            "item_entity_id" => $entity['id'],
            "item_specific_id" => $specific_item['header_id'],
            "weight" => $weight * $mode,
            "quantity" => $quantity * $mode,
            "weight_before" => $super_transaction_data['weight'],
            "quantity_before" => $super_transaction_data['quantity'],
            "weight_after" => $super_transaction_data['weight'] + ($weight * $mode),
            "quantity_after" => $super_transaction_data['weight'] + ($quantity * $mode),
            "reference_id" => $reference_id,
            "created_at" => date("Y-m-d H:i:s")
        );
        $this->db->insert('super_transaction', $super_transaction);
    }

    function getProd_names($id)
    {
        $html = "";
        $name = $this->db->query("SELECT name from item_entity where id=?", $id)->row_array();
        $data = $this->db->query("SELECT * from " . $name['name'])->result_array();
        $html = "<option value='0'>--Select--</option>";
        foreach ($data as $d) {
            $html .= "<option value='" . $d['id'] . "'>" . $d['name'] . "</option>";
        }
        return array($html, $data);
    }

    public function getClassSpecificStock($class_id, $item_entity_id = 26)
    {
        if ($class_id == '') {
            return False;
        }
        $q = $this->db->query("SELECT SUM(cs.quantity) AS class_count FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND ph.class_id = ?", array($item_entity_id, $class_id));
        $q = $q->row_array();
        return $q['class_count'];
    }

    public function getStockByItem($item_entity_id, $item_specific_id, $quantity = 1)
    {
        if ($item_entity_id == '' || $item_specific_id == '') {
            return False;
        }
        $entity = $this->item_entity->getById($item_entity_id);
        if ($entity['is_header'] == 1) {
            $item_entity_id = $entity['product_entity_id'];
            $q = $this->db->query("SELECT SUM(cs.quantity) AS class_count FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND  ps.header_id = ?", array($item_entity_id, $item_specific_id));
            $q = $q->row_array();
            return $q['class_count'];
        } else {
            $this->db->select('quantity');
            $q = $this->get_where('central_stock', compact('item_entity_id', 'item_specific_id'))->row_array();
            return $q['quantity'];
        }
    }

    public function getStockByHeader($item_entity_id, $item_specific_id)
    {
        if ($item_specific_id == '') {
            return False;
        }
        $entity = $this->item_entity->getById($item_entity_id);
        if ($entity['is_header'] == 1) {
            $item_entity_id = $entity['product_entity_id'];
        }
        $q = $this->db->query("SELECT SUM(cs.quantity) AS class_count FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND ps.header_id = ?", array($item_entity_id, $item_specific_id));
        $q = $q->row_array();
        return $q['class_count'];
    }

    public function getStockValueByItem($item_entity_id, $item_specific_id, $branch_id = 0)
    {
        $branch_query = '';
        if ($branch_id > 0) {
            $branch_query = ' AND cs.`branch_id` = ' . $branch_id;
        }
        if ($item_entity_id == '' || $item_specific_id == '') {
            return False;
        }
        $entity = $this->item_entity->getById($item_entity_id);
        if ($entity['is_header'] == 1) {
            $item_entity_id = $entity['product_entity_id'];
            $q = $this->db->query("SELECT SUM(cs.quantity) AS stock, (SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)) AS value FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND  ps.header_id = ?" . $branch_query, array($item_entity_id, $item_specific_id));
            $q = $q->row_array();
            return $q;
        } else {
            $q = $this->db->query("SELECT SUM(cs.quantity) AS stock, (SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)) AS value FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND  ps.id = ?" . $branch_query, array($item_entity_id, $item_specific_id));
            $q = $q->row_array();
            return $q;
        }
    }

    public function getStockValueByBrandClass($item_entity_id, $brand_id = 0, $classes = array())
    {
        $q = $this->db->query("SELECT SUM(cs.quantity) AS stock, (SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)) AS value FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND  ps.header_id = ph.id GROUP BY ph.brand_id", array($item_entity_id));
        $q = $q->row_array();
        return $q;
        if (1) {
            $q = $this->db->query("SELECT SUM(cs.quantity) AS stock, (SUM(CASE WHEN ps.`price` > 0 THEN ps.price*cs.quantity ELSE 0 END) + SUM(CASE WHEN ph.`price` > 0 THEN ph.price*cs.quantity ELSE 0 END)) AS value FROM central_stock cs, product_sku ps, product_header ph WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id AND ps.header_id = ph.id AND  ps.id = ?", array($item_entity_id, $item_specific_id));
            $q = $q->row_array();
            return $q;
        }
    }

    public function getDetailedStockByClasses($classes = array(), $item_entity_id)
    {
        //this function will return detailed stock product name , quantity and class(immediate) name, when supplied with classes id array
        if (count($classes) < 1) {
            return False;
        }
        $id_string = $classes[0];
        foreach ($classes as $class_id) {
            $id_string .= ', ' . $class_id;
        }
        $sql = 'SELECT pd.name AS `Product Name`, SUM(cs.quantity) AS Quantity, cl.name AS `Classification Category` ' .
            'FROM central_stock cs, product_sku ps, product_header ph, products_description pd, class cl ' .
            'WHERE cs.`item_entity_id` = ? AND cs.item_specific_id = ps.id ' .
            'AND ps.`header_id` = ph.`id` AND ph.`product_desc_id` = pd.`id` AND ph.`class_id` = cl.id AND cl.id IN (?) GROUP BY ph.id';
        $q = $this->db->query($sql, array($item_entity_id, $id_string))->result_array();
        return $q;
    }

    public function StockLedgerReport($from, $to)
    {
        //debugbreak();
        $where = "";
        $where .= "a.created_at >= '" . $from . "' and a.created_at <= '" . $to . "' ";
        // $wh_sales = $where."and b.quantity > 0";
        $this->db->select("a.id,a.created_at,a.paid_by_cash,a.paid_by_card,a.discount_value,a.vat_amount,a.total_amount,a.final_amount,b.fname,b.lname");
        $this->db->where($where);
        $this->db->join("customers b", 'b.id = a.customer_id', 'LEFT');
        $data = $this->db->get('bill a')->result_array();
        foreach ($data as &$d) {
            $d['items'] = $this->bill->getItems($d['id']);
            foreach ($d['items'] as &$item) {
                $prod_info = $this->prod_sku->getById($item['item_specific_id']);
                $item['name'] = $prod_info['name'] . '-' . $prod_info['tax_category'];
                $item['vat_percent'] = $prod_info['vat_percentage'];
            }
        }
        return $data;
    }
public function salesReport($brand, $class, $from , $to)
{
    $where = '';
    $this->db->select("bill.created_at as date", "bill.id as id", "users.name as name","bill.final_amount AS amount" , 
            "bill.paid_by_cash as cash",  "bill.paid_by_card as card", "bill.vat_amount as vat");
    if(!empty($brand))
    {
        $where .="ph.brand_id = '".$brand."'";
    }  
     if(!empty($class))
    {
     if(!empty($where))
       {
          $where.=" AND ";
       } 
      $where .="ph.class_id = '".$class."'";    
    }         
    
     if(!empty($from))
    {
       if(!empty($where))
       {
          $where.=" AND ";  
       } 
     $where .="bill.created_at >= '".$from."'";  
    }         
    
     if(!empty($to))
    {
        if(!empty($where))
       {
           $where.=" AND ";
       } 
      $where .="bill.created_at <= '".$to."'";    
    }         
  if(!empty($where))
  {
      $this->db->where($where);
      
  }         
   $this->db->join(""); 
    
}
public function calculatetotals($brand)
{
  $data =   $this->db->query("select sum(cs.quantity) as quantity, sum(cs.quantity * ps.price) as price from central_stock cs LEFT JOIN product_sku ps on cs.item_specific_id = ps.id LEFT JOIN product_header ph on ph.id = ps.header_id where ph.brand_id = ?",$brand)->row_array();
  return $data;
}


}

/*END OF FILE*/