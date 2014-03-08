<div class="add-vendor">
	<div class="content-header">
		<h3>Add Vendor</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('vendor/add_to_db?ajax=1'); ?>" method="post" id="form_add_vendor" onsubmit="return false;">		
		<div class="content-subject">
			<div class="control-group">
                <label class="control-label">Company Name:</label>
                <div class="controls">
                    <input type="text" class="required " name="company_name" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Contact Person:</label>
                <div class="controls">
                    <input type="text" class=" " name="main_person_name" />
                </div>
            </div>
			<div class="control-group">
                <label class="control-label">Address:</label>
                <div class="controls">
                    <textarea name="address" class=" " cols="5" rows="1"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">City:</label>
                <div class="controls">
                    <input type="text" class="" name="city" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">PIN:</label>
                <div class="controls">
                    <input type="text" class="digits " name="pin" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone #1:</label>
                <div class="controls">
                    <input type="text" class="digits " name="phone1" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone #2:</label>
                <div class="controls">
                    <input type="text" class="digits " name="phone2" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Mobile:</label>
                <div class="controls">
                    <input type="text" class="digits" name="mobile" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Comments:</label>
                <div class="controls">
                    <textarea name="comments" class="" cols="5" rows="1"></textarea>
                </div>
            </div>
        </div>
		<div class="content-footer">
			<button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
				<i class="icon-remove-circle icon-white"></i>
				&nbsp;Cancel
			</button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right" onclick="$(this).submit()">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
		</div>
	</form>
</div>
<script type="text/javascript">
    validation.bind({
        formId: '#form_add_vendor',
        ajaxSubmit: true,
        reload: true
    });
    element.focus('.add-vendor input, .add-vendor textarea', validation.focus);
    element.key_up('.add-vendor input, .add-vendor textarea', validation.focus);
</script>