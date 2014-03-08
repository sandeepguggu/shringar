<div class="content-header">
    <h3>Stock</h3>

    <div class="pull-right">&nbsp; &nbsp;</div>
    <div class="pull-right input-append">
        <input class="span2" type="text"/>
			<span class="add-on search-image">
				<i class="icon-search"></i>
			</span>
    </div>
</div>
<div class="search-filter block">
    <div class=" row-fluid">
        <label class="span3">
            <span>Brand</span>
            <select id="reports_brand_id">
                <option value="0">All</option>
                <?php
                if (isset($brands)) {
                    $brand_id = isset($_REQUEST['brand_id']) ? $_REQUEST[brand_id] : '';
                    foreach ($brands as $c) {
                        $selected = '';
                        if ($brand_id == $c['id']) {
                            $selected = ' selected';
                        }
                        echo '<option value="' . $c['id'] . '"' . $selected . '>' . $c['name'] . '</option>';
                    }
                }
                ?>
            </select>
        </label>
        <label class="">
            <span class="search-filter-search-label">X</span>
            <button type="button" id="filter_reports_btn" class="btn btn-primary">Submit</button>
        </label>

    </div>
  <div class="autocomplete-jui pull-right">
                    <div class="ui-widget">
                        <input type="text" id="product_ac" class="input-medium ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
                    </div>
                <ul class="ui-autocomplete ui-menu ui-widget ui-widget-content ui-corner-all" role="listbox" aria-activedescendant="ui-active-menuitem" style="z-index: 1; top: 0px; left: 0px; display: none;"></ul>
  </div>
  <label class="input-small pull-right">Product:</label>
</div>
<br>
<div class="stock content-subject">
    <!--<div class="content-header">
        <?php
    /*        if (!isset($parents) || !is_array($parents) || count($parents) < 1) {
        log_message('error', '#18, inventory/stock.php error');
        $parents = array();
    }
    */?>
        <ul class="breadcrumb-nav">
            <?php
    /*            $length = count($parents);
    $count = 1;
    foreach($parents as $p) {
        $p['id'] = isset($p['id']) ? $p['id'] : '';
        $p['name'] = isset($p['name']) ? $p['name'] : '';
        $p['name'] = $p['id'] != 0 ? $p['name'] : 'Categories';

        $html = '<li>';
        $html .= '<a href="#" onclick="stock.showClasses('.$p['id'].')">'.$p['name'].'</a>';
        $html .= $length != $count ? '<i class="icon-hand-right"></i>' : '';
        $html .= '</li>';
        echo $html;
        $count++;
    }
    */?>
        </ul>
    </div>
    -->
    <div class="row-fluid">
    <?php if(isset($grid)){?>  <span id="append-total" class="hidden"><span class="pull-left grid-message-text" style="margin-left: 10px">Total Quantity : <?php echo round($quantity,0);?> </span><span class="pull-left grid-message-text" style="margin-left: 10px">Total MRP : Rs <?php echo round($price,0);?> </span></span> <?php }?>
       <?php if (isset($grid)) : echo $grid; else:  ?>
        <?php
        if (!isset($class_tree) || !is_array($class_tree) || count($class_tree) < 1) {
            log_message('error', '#22, classification/index.php error');
            $class_tree = array();
        }
        ?>
        <div id="stock_class_tree" class="span4">
            <?php
            $this->load->view('class/tree_template', array('tree' => $class_tree));
            ?>
        </div>
        <div class="span8 content-menu-body" id="reports-by-category">
            <div class="content-header">
                <h3>Categories</h3>
            </div>
            <div class="content-subject">
                Datagrid
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript">
   var html = $("#append-total").html();
   $(".grid-message").append(html);
    fancyBox.bind();
   tree.create(
        '#stock_class_tree',
        {
            initially_open:'0',
            select:stock.view
        }
    ); 
    element.click('#filter_reports_btn', stock.filterReports);
    //$('.grid-message').append()
     app.autocomplete('#product_ac', '<?php echo site_url('product/suggest_product?ajax=1&details=0'); ?>', stock.selectprodAutoComplete);
</script>