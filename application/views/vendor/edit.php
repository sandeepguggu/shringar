<div class="update-vendor">
	<div class="content-header">
		<h3>Update Vendor</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('vendor/update_to_db?ajax=1'); ?>" method="post" id="form_update_vendor" onsubmit="return false;">		
		<input type="hidden" name="id" value="<?php echo $id;?>" />
		<div class="content-subject">
			<div class="control-group">
                <label class="control-label">Company Name:</label>
                <div class="controls">
                    <input type="text" name="company_name" value="<?php echo $company_name;?>" class="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Contact Person:</label>
                <div class="controls">
                    <input type="text" name="main_person_name" value="<?php echo $main_person_name;?>" class="" />
                </div>
            </div>
			<div class="control-group">
                <label class="control-label">Address:</label>
                <div class="controls">
                    <textarea name="address" class="" cols="10" rows="1"><?php echo $address;?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">City:</label>
                <div class="controls">
                    <input type="text" name="city" value="<?php echo $city;?>" class="" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">PIN:</label>
                <div class="controls">
                    <input type="text" name="pin" value="<?php echo $pin;?>" class="digits" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone #1:</label>
                <div class="controls">
                    <input type="text" name="phone1" value="<?php echo $phone1;?>" class="digits" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone #2:</label>
                <div class="controls">
                    <input type="text" name="phone2" value="<?php echo $phone2;?>" class="digits" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Mobile:</label>
                <div class="controls">
                    <input type="text" name="mobile" value="<?php echo $mobile;?>" class="digits" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Comments:</label>
                <div class="controls">
                    <textarea name="comments" cols="10" rows="1"><?php echo $comments;?></textarea>
                </div>
            </div>
        </div>
		<div class="content-footer">
			<button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
				<i class="icon-remove-circle icon-white"></i>
				&nbsp;Cancel
			</button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right" onclick="$(this).submit();">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Update
            </button>
		</div>
	</form>
</div>
<script type="text/javascript">
    validation.bind({
        formId: '#form_update_vendor',
        ajaxSubmit: true,
        reload: true
    });
    element.focus('.update-vendor input, .update-vendor textarea', validation.focus);
    element.key_up('.update-vendor input, .update-vendor textarea', validation.focus);
</script>