<div class="add-customer">
    <div class="content-header">
        <h3>Add Customer</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('customer/add_to_db?ajax=1&json=1'); ?>" method="post"
          id="form_add_customer">
        <div class="content-subject">
            <div class="control-group">
                <label class="control-label">First Name:</label>

                <div class="controls">
                    <input type="text" class="required " name="customer_fname" maxlength="25"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Last Name:</label>

                <div class="controls">
                    <input type="text" name="customer_lname"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Phone:</label>

                <div class="controls">
                    <input type="text" class="digits" name="customer_phone"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">SMS:</label>

                <div class="controls">
                    <label class="radio pull-left span1">
                        <input type="radio" value="Y" name="customer_sms" />Yes
                    </label>
                    <label class="radio">
                        <input type="radio" value="N" name="customer_sms" checked />No
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Sex:</label>

                <div class="controls">
                    <label class="radio pull-left span1">
                        <input type="radio"  value="M" name="customer_sex" />Male
                    </label>
                    <label class="radio">
                        <input type="radio" value="F" name="customer_sex" />Female
                    </label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Birthday:</label>

                <div class="controls">
                    <input type="text" name="customer_dob" id="customer_dob"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Email:</label>

                <div class="controls">
                    <input type="text" class="email" name="customer_email"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Building:</label>

                <div class="controls">
                    <input type="text" class=" " name="customer_building"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Street:</label>

                <div class="controls">
                    <input type="text" class=" " name="customer_street"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Area:</label>

                <div class="controls">
                    <input type="text" class=" " name="customer_area"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">City:</label>

                <div class="controls">
                    <input type="text" class=" " name="customer_city"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">PIN:</label>

                <div class="controls">
                    <input type="text" class="digits" name="customer_pin"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">State:</label>

                <div class="controls">
                    <input type="text" class=" " name="customer_state"/>
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
    $('#customer_dob').datepicker({
        changeMonth:true,
        changeYear: true
    });
    element.focus('.add-customer input', validation.focus);
    element.key_up('.add-customer input', validation.focus);
    validation.bind({
        formId: '#form_add_customer',
        ajaxSubmit: true
        //callback: customer.addCustomer
    });
</script>