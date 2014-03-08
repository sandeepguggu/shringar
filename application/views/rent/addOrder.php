
<div class="add-category">
    <div class="content-header">
        <h3>Add Order</h3>
    </div>
    <form action="<?php echo site_url('rent/product_to_db?ajax=1'); ?>" method="post" onsubmit="return false;" id="form_add_product" class="form-horizontal">
            <div class="content-subject">
			<?php if(isset($success)): ?>
				<div class="label label-success flash-message"><?php echo $success; ?></div>
			<?php elseif(isset($failed)): ?>
				<div class="label label-warning flash-message"><?php echo $failed; ?></div>
			<?php endif;?>
            <div class="label label-warning">Fill the Form</div>
            <div class="control-group">
                <label class="control-label">Product:</label>
                <div class="controls">
                     <select name="product_id" class="required span3">

                        <?php
                        if (isset($products)) {
                            foreach ($products as $c)
                            {
                                echo '<option value="' . $c['id'] . '">' . $c['product_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Advance:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="purchased_at" class="required span3" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">No Of Days:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="age_factor" class="required span3" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Rent Negotiated:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="quality" class="required span3" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Deposit Negotiated:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="price" class="required span3" />
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
</script>