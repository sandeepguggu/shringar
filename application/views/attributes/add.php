<div class="add-attribute">
	<div class="content-header">
		<h3>New Attribute</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('attribute/add_to_db?ajax=1'); ?>" method="post" id="form_add_attribute" onsubmit="return false;">
		<div class="content-subject">
			<div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" name="name" class="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Display Name:</label>
                <div class="controls">
                    <input type="text" name="display_name" class="required" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Level:</label>
                <div class="controls">
                    <label>Secondary</label>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Criticality:</label>
                <div class="controls">
                    <select name="criticality">
                        <option value="level_1">Level 1</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Availability:</label>
                <div class="controls">
                    <select name="availability">
                        <option value="sku">SKU</option>
                        <option value="header">Product header</option>
                        <option value="both">Both</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Value Type:</label>
                <div class="controls">
                    <select name="value_type" id="attribute_value_type">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="set">Value Set</option>
                    </select>
                </div>
            </div>
            <div class="control-group value-type value-type-number">
                <label class="control-label">Multiplier:</label>
                <div class="controls">
                    <input type="text" name="multiplier" class="number" min="1" id="value_multiplier">
                </div>
            </div>
            <div class="control-group value-type value-type-text value-type-number">
                <label class="control-label">Minimum Length:</label>
                <div class="controls">
                    <input type="text" name="minimum_value" id="value_minimum_value" class="number required" value="1" min="1">
                </div>
            </div>
            <div class="control-group value-type value-type-text value-type-number">
                <label class="control-label">Maximum Length:</label>
                <div class="controls">
                    <input type="text" name="maximum_value" id="value_maximum_value" class="number required" value="20" max="20">
                </div>
            </div>
            <div class="control-group value-type value-type-text value-type-number">
                <label class="control-label">Default Value:</label>
                <div class="controls">
                    <input type="text" id="value_default_value" name="default_value" class="required" minlength="1" maxlength="20">
                </div>
            </div>
            <div class="control-group value-type value-type-text value-type-text" >
                <label class="control-label">Letter type:</label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="value_letter_type" value="caps">
                        Caps
                    </label>
                    <label class="radio">
                        <input type="radio" name="value_letter_type" value="small">
                        Small
                    </label>
                    <label class="radio">
                        <input type="radio" name="value_letter_type" value="mixed" checked="checked">
                        Mixed
                    </label>
                </div>
            </div>
            <div class="control-group value-type value-type-text">
                <label class="control-label">Characters Allowed:</label>
                <div class="controls">
                    <label class="checkbox">
                        <input type="checkbox" name="value_special" value="special">
                        Special
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" name="value_number" value="numeric">
                        Numeric
                    </label>
                </div>
            </div>
            <div class="control-group value-type value-type-set" >
                <label class="control-label">Editable:</label>
                <div class="controls">
                    <label class="radio">
                        <input type="radio" name="value_set_editable" value="yes">
                        Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="value_set_editable" value="no" checked="checked">
                        No
                    </label>
                </div>
            </div>
            <div class="control-group value-type value-type-set">
                <label class="control-label">Values (CSV):</label>
                <div class="controls">
                    <textarea rows="2" name="value_set_values" id="value_set_values"></textarea>
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
    $('.value-type').hide();
    $('.value-type-text').show();
    BIZ.app.bind({
        event: 'change',
        parentElement: '.add-attribute',
        targetElement: '#attribute_value_type',
        callback: BIZ.attributeManager.valueTypeChanged,
        extra: ''
    });
    BIZ.app.bind({
        event: 'keyup',
        parentElement: '.add-attribute',
        targetElement: '#value_multiplier',
        callback: BIZ.attributeManager.updateMinimumMaximumValues,
        extra: ''
    });
    BIZ.app.bind({
        event: 'change',
        parentElement: '.add-attribute',
        targetElement: '#value_minimum_value, #value_maximum_value',
        callback: BIZ.attributeManager.updateDefaultValueLimits,
        extra: ''
    });
    validation.bind({
        formId: '#form_add_attribute',
        ajaxSubmit: true,
        reload: true,
        callback: BIZ.attributeManager.validate
    });

    BIZ.app.bind({
        event: 'focus',
        parentElement: '.add-attribute',
        targetElement: 'input, textarea',
        callback: validation.focus,
        extra: ''
    });
    BIZ.app.bind({
        event: 'keyup',
        parentElement: '.add-attribute',
        targetElement: 'input, textarea',
        callback: validation.focus,
        extra: ''
    });
    /*element.focus('.add-attribute input, .add-vendor textarea', validation.focus);
    element.key_up('.add-attribute input, .add-vendor textarea', validation.focus);*/
	/*formValidate.submit('#form_add_brand', true);
	formValidate.messages();*/
</script>