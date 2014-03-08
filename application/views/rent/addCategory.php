<div class="add-category">
    <div class="content-header">
		<h3>Add Rent Category</h3>
	</div>
    <form action="<?php echo site_url('rent/addCategoryDB?ajax=1'); ?>" method="post" class="form-horizontal"  id="form_add_rent_category">
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
                    <input type="text" class="required span3" name="category_name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Parent Category:</label>
                <div class="controls">
                   <select name="parent_id" class="span3">
                        <option value="">ROOT</option>
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
	formValidate.submit('#form_add_rent_category', true);
	formValidate.messages();
</script>