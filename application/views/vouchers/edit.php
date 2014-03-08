<div class="edit-gift-voucher">
    <div class="content-header">
        <h3>Edit Gift Voucher</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('vouchers/add_to_db?ajax=1'); ?>" method="post" id="form_edit_voucher" onsubmit="return false;">
        <div class="content-subject">
            <div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" name="name" class="required" value="<?php if(isset($name)) echo $name; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Amount Type:</label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" value="multiple_of" name="amount_type" checked="checked">
                        Multiple of
                    </label>
                    <label class="radio">
                        <input type="radio" value="value_set" name="amount_type">
                        Value Set
                    </label>
                </div>
            </div>
            <div class="control-group amount-type-amount">
                <label class="control-label">Amount :</label>
                <div class="controls">
                    <input type="text" name="amount_value" class="required number" min="0" value="<?php if(isset($amount_value)) echo $amount_value; ?>">
                </div>
            </div>
            <div class="control-group amount-type-amount">
                <label class="control-label">Minimum Value :</label>
                <div class="controls">
                    <input type="text" name="amount_min_value" class="required number" min="0">
                </div>
            </div>
            <div class="control-group amount-type-amount">
                <label class="control-label">Maximum Value :</label>
                <div class="controls">
                    <input type="text" name="amount_max_value" class="required number" min="0">
                </div>
            </div>
            <div class="control-group hide amount-type-value-set">
                <label class="control-label">Value Set (CSV):</label>
                <div class="controls">
                    <textarea rows="2" name="amount_value_set"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Validity:</label>
                <div class="controls">
                    <input type="text" name="validity" class="required digits " min="0" style="width: 40%"/>
                    <span>&nbsp;</span>
                    <select name="validity_unit" class="" style="width: 40%">
                        <option value="months">Months</option>
                        <option value="days">Days</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>
                <div class="controls">
                    <textarea rows="3" name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
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
    BIZ.app.bind({
        event: 'change',
        parentElement: '.edit-gift-voucher',
        targetElement: 'input[name=amount_type]',
        callback: BIZ.vouchers.toggleAmountTypes,
        extra: ''
    });

    validation.bind({
        formId: '#form_edit_voucher',
        ajaxSubmit: true,
        reload: true,
        callback: BIZ.vouchers.validate
    });

    BIZ.app.bind({
        event: 'focus',
        parentElement: '.edit-gift-voucher',
        targetElement: 'input, textarea',
        callback: validation.focus,
        extra: ''
    });
    BIZ.app.bind({
        event: 'keyup',
        parentElement: '.edit-gift-voucher',
        targetElement: 'input, textarea',
        callback: validation.focus,
        extra: ''
    });
</script>