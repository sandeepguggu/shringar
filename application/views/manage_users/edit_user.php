<?php
$reload = 'true';
?>
<div class="edit-user">
    <div class="content-header">
        <h3>Update User</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('manage_users/editUser'); ?>" method="post" id="edit_user_form">
        <?php echo form_hidden('id', $userId); ?>
        <div class="content-subject">
            <div class="control-group">
                <label class="control-label">First Name:</label>
                <div class="controls">
                    <?php echo form_input($first_name);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Last Name:</label>
                <div class="controls">
                    <?php echo form_input($last_name);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone:</label>
                <div class="controls">
                    <?php echo form_input($phone);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Username:</label>
                <div class="controls">
                    <?php echo form_input($username);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Group:</label>
                <div class="controls">
                    <?php echo form_dropdown('groups', $groups, $groupId, 'id="edit_user_group_id"');?>
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
        formId: '#edit_user_form',
        ajaxSubmit: true,
        callback: manageUsers.editUserValidate,
        reload: <?php echo $reload ?>
    });
    element.focus('.edit-user input, .edit-user select', validation.focus);
    element.key_up('.edit-user input, .edit-user select', validation.focus);
</script>