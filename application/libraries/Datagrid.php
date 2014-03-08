<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Datagrid
{
    private $db;

    public function __construct($db = '')
    {
        if (isset($db['db'])) {
            $this->db = $db['db'];
        } else {
            throw new Exception('Database connection required in the params');
        }
    }

    function tableDisplay($fields, $table, $where, $orderby, $editable_fields = array())
    {
        $table_header = array();
        $select_fields = array();
        $editable = array();
        if (count($editable_fields) > 0) {
            foreach ($editable_fields as $e => $v) {
                $editable[$v] = 1;
            }
        }
        if (is_array($fields)) {
            foreach ($fields as $kf => $kv) {
                $table_header[] = $kf;
                $select_fields[] = "`" . $kv . "`";
            }
        }
        $sql = "SELECT " . implode(",", $select_fields) . " FROM " . $table . " " . $where . " " . $orderby;
        $r = $this->db->result_array($sql);
        $html = '';
        if (is_array($r) && is_array($fields)) {
            $html .= '<table width="100%" class="zebra-striping">';
            foreach ($fields as $kf => $kv) {
                if (isset($editable[$kv]) && $editable[$kv] == 1) {
                    $html .= '<tr style="background-color:#ccc;"><td>' . $kf . ': </td><td><input type="text" name="' . $kv . '" value="' . addslashes($r[$kv]) . '" style="width:90%;"></td></tr>';
                } else {
                    $html .= '<tr><td>' . $kf . ': </td><td>' . $r[$kv] . '&nbsp;</td></tr>';
                }
            }
            $html .= '</table>';
        }
        return $html;
    }

    function gridDisplay($fields, $table, $actions = array(), $where = '', $orderby = '', $limit = 50, $page_numbering = 1, $config = array())
    {
        //extract($config);
        $checkbox = isset($config['checkbox']) ? $config['checkbox'] : 0;
        $excel = isset($config['excel']) ? $config['excel'] : 0;
        $count_distinct = isset($config['count_distinct']) ? $config['count_distinct'] : '';
        $countlimit = isset($config['countlimit']) ? $config['countlimit'] : '';
        $destination = isset($config['destination']) ? $config['destination'] : '';
        $total_amount = isset($config['total_amount']) ? $config['total_amount'] : '';
        $total_quantity = isset($config['total_quantity']) ? $config['total_quantity'] : '';
        $total_vat = isset($config['total_vat']) ? $config['total_vat'] : '';
        $total_quantity_field = isset($config['total_quantity_field']) ? $config['total_quantity_field'] : '';
        $total_amount_field = isset($config['total_amount_field']) ? $config['total_amount_field'] : '';
        $total_vat_field = isset($config['total_vat_field']) ? $config['total_vat_field'] : '';
        //config => 'sortable' => 0/1
        //          'excel' => 0/1
        //          'count_distinct' => 'pd.id'
        //
        $table_header = array();
        $select_fields = array();
        $offset = 0;
        $action_count = count($actions);
        $cur_page = (isset($_REQUEST['page']) && $_REQUEST['page'] > 0) ? $_REQUEST['page'] : 1;
        if (isset($_REQUEST['page']) && $_REQUEST['page'] > 1) {
            $offset = $limit * ($_REQUEST['page'] - 1);
        }
        if (is_array($fields)) {
            foreach ($fields as $kf => $kv) {
                $table_header[] = $kf;
                //if(substr($kv,0,1) != "("){
                //	$select_fields[] = "`".$kv."`";
                //}else{
                $select_fields[] = $kv;
                //}
            }
        }
        if ($count_distinct != '') {
            //count_distinct is useful when you are using group by with aggregate function
            $sql_c = "SELECT SUM(cnt) AS cnt FROM (SELECT count(distinct {$count_distinct}) cnt FROM " . $table . " " . $where . " " . $orderby . ') AS A';
        } else {
            $sql_c = "SELECT count(*) cnt FROM " . $table . " " . $where . " " . $orderby;
        }

        if (isset($GLOBALS['debug']) && $GLOBALS['debug'] == 1) {
            echo $sql_c . "<br />";
        }
        if(!empty($countlimit))
        {
          $cnt = 20;
        }  else{
        $res = $this->db->query($sql_c);
        $cnt = $res->row_array();
        $cnt = $cnt['cnt'];
		}
        if ($cnt <= 0) {
            $html = 'No Records!';
            return $html;
        }

        if($total_amount == 1) {
            $sql_total_amount = "SELECT SUM($total_amount_field) AS total FROM " . $table . " " . $where;
            $result = $this->db->query($sql_total_amount);
            $result = $result->row_array();
            $total_amt = $result['total'];
        }

        if($total_quantity == 1) {
            $sql_total_quantity = "SELECT SUM($total_quantity_field) AS total FROM " . $table . " " . $where;
            $result = $this->db->query($sql_total_quantity);
            $result = $result->row_array();
            $total_qty = $result['total'];
        }

        if($total_vat == 1) {
            $sql_total_vat = "SELECT SUM($total_vat_field) AS total FROM " . $table . " " . $where;
            $result = $this->db->query($sql_total_vat);
            $result = $result->row_array();
            $total_vt = $result['total'];
        }    


        $html = '<div class="block grid-message">';
        $html .= '<span class="pull-left grid-message-text">Total Number of Records : ' . $cnt . '</span>';        

        $sql_e = "SELECT " . implode(",", $select_fields) . " FROM " . $table . " " . $where . " " . $orderby;
        if (isset($config['total']) && !empty($config['total'])) {
            $total_string = '';
            foreach ($config['total'] as $total_key => $total_value) {
                if ($total_string == '') {
                    $total_string .= " SUM(test.$total_value) as `$total_key`";
                } else {
                    $total_string .= " , SUM(test.$total_value) as `$total_key`";
                }
            }
            $sql_total = "SELECT $total_string FROM ($sql_e) AS test";
            $total_result_array = $this->db->query($sql_total)->row_array();
            foreach ($total_result_array as $key => $value) {
                $html .= '<span class="pull-left grid-message-text">,&nbsp;&nbsp;' . $key . ' : ' . $value . '</span>';
            }
        }
        $sql = $sql_e . " LIMIT " . $offset . "," . $limit;
        if (isset($GLOBALS['debug']) && $GLOBALS['debug'] == 1) {
            echo $sql . "<br />";
        }
        $res = $this->db->query($sql);
        if ($excel) {
            $a = json_encode($table_header);
            $a = urlencode($a);
           
            $html .= '<form class="pull-right" action="' . site_url('master/export_to_excel') . '" method="POST"><input name="query" type="hidden" value="' . urlencode($sql_e) . '">' .
                '<input name="headers" type="hidden" value="' . $a . '"><button type="submit" class="btn btn-primary">Export to Excel</button>';
             if($total_quantity == 1) {
                     $html .= '<input name="total_quantity" type="hidden" value="' . $total_qty . '">';
             }
             if($total_amount == 1) {
                     $html .= '<input name="total_amount" type="hidden" value="' . $total_amt . '">';
             }
             if($total_vat == 1) {
                     $html .= '<input name="total_vat" type="hidden" value="' . $total_vt . '">';
             }
             $html .= '</form>';
        }

        if($total_quantity == 1) {
                $html .= '<span class="pull-right grid-total-quantity" style="margin-right:35px;">&nbsp;&nbsp;&nbsp;Total Quantity : ' . $total_qty . '</span>';
        }
        if($total_amount == 1) {
                $html .= '<span class="pull-right grid-total-amount" style="margin-right:35px;">&nbsp;&nbsp;&nbsp;Total Amount : ' . $total_amt . '</span>';
        }    
        if($total_vat == 1) {
                $html .= '<span class="pull-right grid-total-vat" style="margin-right:35px;">&nbsp;&nbsp;&nbsp;Total VAT : ' . $total_vt . '</span>';
        }
        
        $html .= '</div>';
        $html .= '<table class="table table-striped table-bordered" width="100%"><thead>';
        $html .= '<tr>';
        if ($checkbox == 1) {
            $html .= '<td><input type="checkbox" class="checkbox_all"></td>';
        }
        if (isset($config['sortable']) && $config['sortable'] == 1) {
            foreach ($fields as $kf => $kv) {
                $_REQUEST['sort'] = $kv;
                $_REQUEST['ajax'] = 1;
                unset($_REQUEST['order']);
                $qs = http_build_query($_REQUEST);
                $html .= '<th><a href="#" onclick="tabs.reload(\'' . $_SERVER['PHP_SELF'] . '?' . $qs . '\'); return false;">' . $kf . ' &darr;</a>&nbsp; &nbsp;<a href="#" onclick="tabs.reload(\'' . $_SERVER['PHP_SELF'] . '?order=1&' . $qs . '\'); return false;"> &uarr;</a></th>';
            }
        } else {
            foreach ($table_header as $t) {
                $html .= '<th>' . $t . '</th>';
            }
        }
        if ($action_count > 0) {
            $html .= '<th colspan="' . $action_count . '"></th>';
        }
        $html .= '</tr></thead>';
        foreach ($res->result_array() as $d) {
            $html .= '<tr>';
            if ($checkbox == 1) {
                $html .= '<td><input type="checkbox" name="checkbox_' . $d['id'] . '"></td>';
            }
            foreach ($d as $k => $v) {
                $html .= '<td>' . $v . '</td>';
            }
            if ($action_count > 0) {
                foreach ($actions as $k => $v) {
                    $url = isset($v['url']) ? $v['url'] : $v;
                    $css_class = isset($v['css']) ? $v['css'] : '';
                    if (strpos($url, "?") !== false) {
                        $url .= '&id=' . $d['id'];
                    } else {
                        $url .= '?id=' . $d['id'];
                    }
                    $html .= '<td style="width: 20px"><a href="' . $url . '" class="' . $css_class . '">' . $k . '</a></td>';
                }
            }
            $html .= '</tr>';
        }
        $html .= '</table>';
         if ($cnt > $limit) {
            // Display Pagenumbering
            $tmp = $cnt / $limit;
            $tmp_i = intval($tmp);
            $tmp_f = $tmp - $tmp_i;
            if ($tmp_f > 0) {
                $tmp_i++;
            }
            $pages = $tmp_i;
            $html .= '<div class="pagination">';
            $html .= '<ul>';
          
               $_REQUEST['page'] = 1;
                unset($_REQUEST['ajax']);
                $qs = http_build_query($_REQUEST);
               //debugbreak();
                if(isset($config['in_fancy_box']) && $config['in_fancy_box']==1)
                {
                  $qs.="&fancybox=1";
                }
                $html .= ' <li class="prev"><a href="#" onclick="tabs.reload(\'' . $_SERVER['PHP_SELF'] . '?ajax=1&' . $qs . '\'); return false;">First</a></li>';
                
            if ($cur_page <= 1) {
                
                $html .= ' <li class="prev disabled"><a href="URL" onclick="return false">&larr; Previous</a></li>';
            } else {
                $_REQUEST['page'] = $cur_page - 1;
                unset($_REQUEST['ajax']);
                $qs = http_build_query($_REQUEST);
               //debugbreak();
                if(isset($config['in_fancy_box']) && $config['in_fancy_box']==1)
                {
                  $qs.="&fancybox=1";
                }
                $html .= ' <li class="prev"><a href="#" onclick="tabs.reload(\'' . $_SERVER['PHP_SELF'] . '?ajax=1&' . $qs . '\'); return false;">&larr; Previous</a></li>';
            }
           //debugbreak();
           $i_last_page = ($cur_page == $pages ) ? $pages : ( ($cur_page + ($pages - $cur_page) > ($cur_page + 4)) ? $cur_page + 4 : $cur_page + ($pages - $cur_page)) ;
            for ($i = $cur_page; $i <= $i_last_page; $i++) {
                $_REQUEST['page'] = $i;
                unset($_REQUEST['ajax']);
                $qs = http_build_query($_REQUEST);
                 if(isset($config['in_fancy_box']) && $config['in_fancy_box']==1)
                {
                  $qs.="&fancybox=1";
                }
                if ($cur_page == $i) {
                    $html .= '<li class="active"><a href="#">';
                    $html .= $i;
                    $html .= '</a></li>';
                } else {
                    $html .= '<li style="float: left;">';
                    $html .= '<a href="URL" onclick="tabs.reload(\'' . $_SERVER['PHP_SELF'] . '?ajax=1&' . $qs . '\'); return false;">' . $i . '</a>';
                    $html .= '</li>';
                }
            }
         $_REQUEST['page'] = $pages;
            $qs = http_build_query($_REQUEST);
                 if(isset($config['in_fancy_box']) && $config['in_fancy_box']==1)
                {
                  $qs.="&fancybox=1";
                }
                unset($_REQUEST['ajax']);
                $html .= ' <li class="next"><a href="URL" onclick="tabs.reload(\'' . $_SERVER['PHP_SELF'] . '?ajax=1&' . $qs . '\'); return false;">Last </a></li>';
            $html .= '</ul>';
            $html .= '</div>';
        }
        return $html;
    }
}
/*END OF FILE*/