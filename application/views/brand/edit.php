<div class="edit-brand">
    <div class="content-header">
        <h3>Update Brand</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('brand/update_to_db?ajax=1'); ?>" method="post"
          id="form_edit_brand" onsubmit="return false;">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>"/>

        <div class="content-subject">
            <div class="control-group">
                <label class="control-label">Name:</label>

                <div class="controls">
                    <input type="text" name="name" class="required" value="<?php echo isset($name) ? $name : ''; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>

                <div class="controls">
                    <textarea rows="3"
                              name="description"><?php echo isset($description) ? $description : ''; ?></textarea>
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
    validation.bind({
        formId:'#form_edit_brand',
        ajaxSubmit:true,
        reload:true
    });
    element.focus('.edit-brand input, .edit-brand textarea', validation.focus);
    element.key_up('.edit-brand input, .edit-brand textarea', validation.focus);
</script>