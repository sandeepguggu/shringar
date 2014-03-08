<div class="add-category">
	<div class="content-header">
		<h3>Add Category</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('category/add_to_db?ajax=1'); ?>" method="post" id="form_add_category" onsubmit="return false;">		
		<div class="content-subject">
			<?php /*if(isset($success)): */?><!--
				<div class="label label-success flash-message"><?php /*echo $success; */?></div>
			<?php /*elseif(isset($failed)): */?>
				<div class="label label-warning flash-message"><?php /*echo $failed; */?></div>
			<?php /*endif;*/?>
			
            <div class="label label-warning">Fill the Form</div>-->
			<div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" class="required" name="name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Vat(%):</label>
                <div class="controls">
                    <input type="text" class="required number" min="0" max="100" name="vat_percentage" autocomplete="off" />
                </div>
            </div>
			<div class="control-group">
                <label class="control-label">Parent Category:</label>
                <div class="controls">
                    <select name="parent_id">
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
        </div>
		<div class="content-footer">

            <button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
                <i class="icon-remove-circle icon-white"></i>
                &nbsp;Cancel
            </button>
			<span class="pull-right">&nbsp;&nbsp;</span>
            <button type="submit" class="btn btn-primary pull-right">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
		</div>
	</form>
</div>
<script type="text/javascript">
	/*formValidate.submit('#form_add_category', true);
	formValidate.messages();*/
    validation.bind({
        formId: '#form_add_category',
        ajaxSubmit: true,
        reload: true
    });
    element.focus('.add-category input, .add-category textarea', validation.focus);
    element.key_up('.add-category input, .add-category textarea', validation.focus);
</script>