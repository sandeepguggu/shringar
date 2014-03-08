<div class="add-brand">
	<div class="content-header">
		<h3>Add Brand</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('brand/add_to_db?ajax=1'); ?>" method="post" id="form_add_brand" onsubmit="return false;">		
		<div class="content-subject">
			<div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" name="name" class="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>
                <div class="controls">
                    <textarea rows="3" name="description"></textarea>
                </div>
            </div>
        </div>
		<div class="content-footer">
			<button type="button" class="btn btn-danger pull-right action-btn" onclick="$.fancybox.close()">
				<i class="icon-remove-circle icon-white"></i>
				&nbsp;Cancel
			</button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="submit" class="btn btn-primary pull-right action-btn">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
		</div>
	</form>
</div>
<script type="text/javascript">
    validation.bind({
        formId: '#form_add_brand',
        ajaxSubmit: true,
        reload: true
    });
    element.focus('.add-brand input, .add-vendor textarea', validation.focus);
    element.key_up('.add-brand input, .add-vendor textarea', validation.focus);
	/*formValidate.submit('#form_add_brand', true);
	formValidate.messages();*/
</script>