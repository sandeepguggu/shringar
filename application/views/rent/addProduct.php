
<div class="add-category">
    <div class="content-header">
        <h3>Add Product</h3>
    </div>
    <form action="<?php echo site_url('rent/addProductoDB?ajax=1'); ?>" method="post" onsubmit="return false;" id="form_add_product" class="form-horizontal">
            <div class="content-subject">
			<?php if(isset($success)): ?>
				<div class="label label-success flash-message"><?php echo $success; ?></div>
			<?php elseif(isset($failed)): ?>
				<div class="label label-warning flash-message"><?php echo $failed; ?></div>
			<?php endif;?>
            <div class="label label-warning">Fill the Form</div>
            <div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" class="required span3" name="product_name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>
                <div class="controls">
                    <textarea type="text" class="required span3" name="description"></textarea>
                </div>
            </div>
           <!-- <div class="control-group">
                <label class="control-label">Purchased Date:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="purchased_date" class="required span3 hasDatePicker" id="hasDatePicker" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Quantity:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="quantity" class="required span3 number" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Purchased Price:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="purchase_price" class="required span3 number" />
                </div>
            </div>-->
            <div class="control-group">
                <label class="control-label">Rent Price:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="rent_price" class="required span3 number" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Quantity:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="quantity" class="required span3 number" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Category:</label>
                <div class="controls">
                    <select name="category_id" class="required span3">
                        <option value="0">ROOT</option>
                        <?php
                        if (isset($class)) {
                            foreach ($class as $c)
                            {
                                echo '<option value="' . $c['id'] . '">' . $c['category_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- <div class="control-group">
                <label class="control-label">Deposit:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="deposit" class="required span3 number" />
                </div>
            </div> -->
            <div class="control-group">
                <label class="control-label">Components:</label>
                <div class="controls autocomplete-jui">				
                    <div class="ui-widget input-append">
                        <input id="add_component_class_attributes" type="text" class="input-add"/>
                            <span class="add-on search-image" id="add_component_class_attributes_plus">
                            <i class="icon-plus"></i>
                        </span>
			<div id="class_attributes_tags" class=""></div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="add_component_attributes_row_count" value="0" />
            <table class="table table-striped table-bordered" id="add_component_attributes_table">
                    <tr>
                            <th class="">Name</th>
                            <!--<th>Quantity</th>
                            <th>Rent Price</th>-->
                            <th style="width: 20px">&nbsp</th>
                    </tr>
            </table>
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
        $('#hasDatePicker').datepicker()
        element.click('#add_component_class_attributes_plus', rent_products.addComponent);
        app.autocomplete('#add_component_class_attributes', '/index.php/rent/suggest_component?json=1&from=product', components.addSelect);
</script>