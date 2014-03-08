<?php
if (!isset($class_tree) || !is_array($class_tree) || count($class_tree) < 1) {
    log_message('error', '#22, classification/index.php error');
    $class_tree = array();
}
?>
<div class="add-class-category">
    <div class="content-header">
        <h3>Add Classification Category</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('classification/add_class_to_db?ajax=1'); ?>"
          method="post" id="form_add_class_category" onsubmit="return false;">
        <div class="content-subject">
            <div class="control-group">
                <label class="control-label">Name:</label>

                <div class="controls">
                    <input type="text" class="required" name="name"/>
                </div>
            </div>
            <div class="control-group hide">
                <label class="control-label">Sort Order:</label>

                <div class="controls">
                    <select name="sort_order">
                        <option value="0">ROOT</option>
                        <?php
                        if (isset($class)) {
                            foreach ($class as $c) {
                                echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Parent Category:</label>

                <div class="controls">
                    <select name="parent_id">
                        <?php
                        $this->load->view('class/tree_drop_down', array('tree' => $class_tree));
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Attributes:</label>

                <div class="controls autocomplete-jui">
                    <div class="ui-widget input-append">
                        <input id="add_category_class_attributes" type="text" class="input-add"/>
                        <span class="add-on search-image" id="add_category_class_attributes_plus">
                            <i class="icon-plus"></i>
                        </span>

                        <div id="class_attributes_tags" class=""></div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="add_class_attributes_row_count" value="0"/>
            <table class="table table-striped table-bordered" id="add_class_attributes_table">
                <tr>
                    <th>Name</th>
                    <th class="span1">Level</th>
                    <th style="width: 20px">&nbsp</th>
                </tr>
            </table>
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
    /*formValidate.submit('#form_add_class_category', true);
    formValidate.messages();*/
    app.autocomplete('#add_category_class_attributes', '/index.php/classification/suggest_attribute?json=1&from=class', classes.addSelect);
    element.click('#add_category_class_attributes_plus', classes.add);
    tree.create('#add_class_tree', { select:classes.changeClassId });

    validation.bind({
        formId:'#form_add_class_category',
        ajaxSubmit:true,
        reload:true
    });
    element.focus('.add-class-category input, .add-class-category textarea', validation.focus);
    element.key_up('.add-class-category input, .add-class-category textarea', validation.focus);
</script>