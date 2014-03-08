<div class="products" id="products-content-id">
    <div class="content-header">
        <h3>Mange Products</h3>
        <a id="vendor_add_btn" href="<?php echo site_url('product/add?ajax=1&pt=25'); ?>"
           class="btn btn-primary fancybox pull-right">
            <!--<i class="icon-tags icon-white"></i>-->
            Add Product Header
        </a>

        <div class="pull-right">&nbsp; &nbsp;</div>
        <div class="pull-right input-append">
            <input class="span2" type="text" id="product-search-field"/>
			<span class="add-on search-image" id="product-search-btn">
				<i class="icon-search"></i>
			</span>
        </div>
    </div>
    <div class="search-filter block">
        <div class=" row-fluid">
            <label class="span3">
                <span>Brand</span>
                <select id="products_brand_id">
                    <option value="0">All</option>
                    <?php
                    if (isset($brands)) {
                        foreach ($brands as $c) {
                            $selected = '';
                            if (isset($_REQUEST['brand_id']) && $_REQUEST['brand_id'] == $c['id']) {
                                $selected = ' selected ';
                            }
                            echo '<option value="' . $c['id'] . '" ' . $selected . '>' . $c['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </label>
            <label class="span3">
                <span>Class</span>
                <select id="products_class_id">
                    <?php
                    $selected_id = isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : 0;
                    $this->load->view('class/tree_drop_down', array('tree' => $class_tree, 'class_id' => $selected_id));
                    ?>
                </select>
            </label>
            <label class="">
                <span class="search-filter-search-label">X</span>
                <button type="button" id="filter_products" class="btn btn-primary">Submit</button>
            </label>
        </div>
    </div>
    <div class="content-subject">
        <div class="data-grid">
            <?php if (isset($grid)) echo $grid; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    fancyBox.bind();
    element.click('#filter_products', products.filter);
    element.click('#product-search-btn', BIZ.app.search, {

        field:'#product-search-field',
        search:1,
        url:'',
        targetDiv:'#products-content-id'
    });
    element.key_up('#product-search-field', BIZ.app.search, {
        field:'#product-search-field',
        search:0,
        url:'',
        targetDiv:'#products-content-id'
    });

    /*BIZ.app.bind({
        event:'click',
        parentElement:'.products',
        targetElement:'#product-search-btn',
        callback:BIZ.app.search,
        extra:{
            field:'#product-search-field',
            search:1,
            url:'',
            targetDiv:'#products-content-id'
        }
    });
    BIZ.app.bind({
        event:'keyup',
        parentElement:'.products',
        targetElement:'#product-search-field',
        callback:BIZ.app.search,
        extra:{
            field:'#product-search-field',
            search:0,
            url:'',
            targetDiv:'#products-content-id'
        }
    });*/
</script>