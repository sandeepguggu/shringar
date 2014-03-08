<div class="edit-category">
	<div class="content-header">
		<h3>Update Category</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('category/update_to_db?ajax=1'); ?>" method="post" id="form_edit_category" onsubmit="return false;">		
		<input type="hidden" name="id" value="<?php echo isset($id)?$id:''; ?>" />
		<div class="content-subject">
			<div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" name="name" class="required" value="<?php echo isset($name)?$name:''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Vat(%):</label>
                <div class="controls">
                    <input type="text" id="vat_percentage" name="vat_percentage" class="number required" min="0" value="<?php echo isset($vat_percentage)?$vat_percentage:''; ?>" />
                </div>
            </div>
			<div class="control-group">
                <label class="control-label">Parent Category:</label>
                <div class="controls">
                    <select name="parent_id">
						<option value="0">[ROOT]</option>
						<?php
							if(isset($category)){
								foreach($category as $c){
									echo '<option value="'.$c['id'].'"';
									if(isset($selected_parent_id)){
										echo ($c['id'] == $selected_parent_id)?' selected ':'';
									}
									echo '>'.$c['name'].'</option>';
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
                &nbsp;Update
            </button>
		</div>
	</form>
</div>
<script type="text/javascript">
	/*formValidate.submit('#form_edit_category', true);
	formValidate.messages();*/

    validation.bind({
        formId: '#form_edit_category',
        ajaxSubmit: true,
        reload: true
    });
    element.focus('.edit-category input, .edit-category textarea', validation.focus);
    element.key_up('.edit-category input, .edit-category textarea', validation.focus);
</script>