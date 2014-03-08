<?php
$reload = 'true';
?>
<div class="create-user">
    <div class="content-header">
        <h3>Create User</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('manage_users/createUser'); ?>" method="post" id="create_user_form">
        <div class="content-subject">
            <div class="control-group">
                <label class="control-label">First Name:</label>
                <div class="controls">
                    <input type="text" name="first_name" class="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Last Name:</label>
                <div class="controls">
                    <input type="text" name="last_name" class="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone:</label>
                <div class="controls">
                    <input type="text" name="phone" class="required digits" minlength="10" maxlength="12"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Username:</label>
                <div class="controls">
                    <input type="text" name="username" class="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Password:</label>
                <div class="controls">
                    <input type="password" name="password" class="required" id="create_user_password" minlength="6" maxlength="12"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Confirm Password:</label>
                <div class="controls">
                    <input type="password" name="password_confirm" class="required" id="create_user_confirm_password" minlength="6" maxlength="12"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Group:</label>
                <div class="controls">
                    <select name="groups" id="create_user_group_id">
                        <option value="0">Choose One</option>
                        <?php
                        foreach($groups as $id => $group) {
                            echo '<option value="'.$id.'">'.$group.'</option> ';
                        }
                        ?>
                    </select>
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
        formId: '#create_user_form',
        ajaxSubmit: true,
        callback: manageUsers.createUserValidate,
        reload: <?php echo $reload ?>
    });
    element.focus('.create-user input, .create-user select', validation.focus);
    element.key_up('.create-user input, .create-user select', validation.focus);
</script>


