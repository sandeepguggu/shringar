<?php
$reload = 'true';
?>
<div class="create-group">
    <div class="content-header">
        <h3>Create Group</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('manage_users/createGroup'); ?>" method="post" id="create_group_form">
        <div class="content-subject">
            <div class="control-group">
                <label class="control-label">Group Title:</label>
                <div class="controls">
                    <?php echo form_input($group_name);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Group Identifier:</label>
                <div class="controls">
                    <?php echo form_input($group_identifier);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>
                <div class="controls">
                    <?php echo form_textarea($group_description);?>
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
        formId: '#create_group_form',
        ajaxSubmit: true,
        reload: <?php echo $reload ?>
    });
    element.focus('.create-group input, .create-group select', validation.focus);
    element.key_up('.create-group input, .create-group select', validation.focus);
</script>
