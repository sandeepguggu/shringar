<?php
$reload = isset($_REQUEST['reload']) ? 'false': 'true';
?>
<div class="add-product">
	<div class="content-header">
		<h3>Add Product Header</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('product/add_product_header_to_db?ajax=1'); ?>" method="post" id="form_add_product" onsubmit="return false;">
		<div class="content-subject">
			<div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" class="required" name="name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Brand:</label>
                <div class="controls autocomplete-jui">
                    <div class="ui-widget input-append">
                        <input id="add_product_brand_name" type="text" name="brand_name">
						<input id="add_product_brand_id" name="brand_id" type="hidden" />
                    </div>
                </div>
            </div>
            <!--<div class="control-group">
                <label class="control-label">Mfg. Barcode:</label>
                <div class="controls">
                    <input type="text" class="" name="mfg_barcode" />
                </div>
            </div>-->
			<div class="control-group">
                <label class="control-label">Tax Category:</label>
                <div class="controls">
                    <select name="category_id">
                        <option value="0">ROOT</option>
                        <?php
                        if (isset($category)) {
                            foreach ($category as $c) {
                                echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label">Class Category:</label>
                <div class="controls">
                    <select name="class_id" id="add_product_class_id">
                        <?php
                        $this->load->view('class/tree_drop_down', array('tree' => $class_tree));
                        ?>
                    </select>
                </div>
            </div>
			<div class="control-group">
                <label class="control-label">Description:</label>
                <div class="controls">
                    <textarea name="description"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Attributes:</label>
                <div class="controls autocomplete-jui">				
                    <div class="ui-widget input-append">
                        <input id="add_product_class_attributes" type="text" class="input-add"/>
                        <span class="add-on search-image" id="add_product_class_attributes_plus">
                            <i class="icon-plus"></i>
                        </span>
						<div id="class_attributes_tags" class=""></div>
                    </div>
                </div>
            </div>
			<input type="hidden" id="add_product_attributes_row_count" value="0" />
			<table class="table table-striped table-bordered" id="add_product_attributes_table">
				<tr>
					<th class="">Name</th>
					<th>Value</th>
					<th>Level</th>
					<th>SKU</th>
					<th style="width: 20px">&nbsp</th>
				</tr>
			</table>
        </div>
		<div class="content-footer">
			<button type="button" class="btn btn-danger btn-medium pull-right" onclick="$.fancybox.close()">
				<i class="icon-remove-circle icon-white"></i>
				&nbsp;Cancel
			</button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary btn-medium pull-right" onclick="$(this).submit()">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
		</div>
	</form>
</div>
<script type="text/javascript">
	/*formValidate.submit('#form_add_product', true, products.addValidate);
	formValidate.messages();*/
	app.autocomplete('#add_product_brand_name', '/index.php/brand/suggest_brand?json=1&from=class', products.selectBrand);
	element.change('#add_product_class_id', products.changeClass, { 'table' : '#add_product_attributes_table', 'row_count' : '#add_product_attributes_row_count', 'class' : '#add_product_class_id'});
    app.autocomplete('#add_product_class_attributes', '/index.php/classification/suggest_attribute?json=1&from=product', products.addSelect);
	element.click('#add_product_class_attributes_plus', products.add);

    element.focus('.add-product input', validation.focus);
    element.key_up('.add-product input', validation.focus);
    validation.bind({
        formId: '#form_add_product',
        ajaxSubmit: true,
        callback: products.addValidate,
        reload: <?php echo $reload ?>
    });

</script>