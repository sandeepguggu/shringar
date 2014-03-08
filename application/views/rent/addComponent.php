
<div class="add-category">
    <div class="content-header">
        <h3>Add Component</h3>
    </div>
    <form action="<?php echo site_url('rent/addComponenttoDB?ajax=1'); ?>" method="post" onsubmit="return false;" id="form_add_product" class="form-horizontal">
            <div class="content-subject">
			<?php if(isset($success)): ?>
				<div class="label label-success flash-message"><?php echo $success; ?></div>
			<?php elseif(isset($failed)): ?>
				<div class="label label-warning flash-message"><?php echo $failed; ?></div>
			<?php endif;?>
            <div class="label label-warning">Fill the Form</div>

            <div class="control-group">
                <label class="control-label">Product:</label>
                <div class="controls autocomplete-jui">             
                        <input id="add_product_name" class="required span3" type="text" class="input-add" name="product_name"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" class="required span3" name="name" />
                </div>
            </div>

            <div class="control-group">
                <!--<label class="control-label">Quantity:</label>-->
                <div class="controls autocomplete-jui">
                        <input type="hidden" value="0" name="quantity" class="required span3 number" min="1"/>
                </div>
            </div>

            <div class="control-group">
                <!--<label class="control-label">Rent Price:</label>-->
                <div class="controls autocomplete-jui">
                        <input type="hidden" value="0" name="rent_price" class="required span3 number" min="1"/>
                </div>
            </div>

        </div>
            <div class="content-footer">
                <button type="submit" class="btn btn-primary pull-right">
                        <i class="icon-ok-circle icon-white"></i>
                        &nbsp;Submit
                </button>
                <span class="pull-right">&nbsp;&nbsp;</span>
                <button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
                        <i class="icon-remove-circle icon-white"></i>
                        &nbsp;Cancel
                </button>
            </div>
    </form>
</div>
<script type="text/javascript">
	formValidate.submit('#form_add_product', true);
	formValidate.messages();
        element.click('#add_component_class_attributes_plus', components.add);
        app.autocomplete('#add_product_name', '/index.php/rent/select_product?json=1&from=class', rent_products.displayGrid);
</script>