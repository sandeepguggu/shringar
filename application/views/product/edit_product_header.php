<?php
$id = isset($output['id']) ? $output['id'] : '';
$name = isset($output['name']) ? $output['name'] : '';
$brand = isset($output['brand']) ? $output['brand'] : '';
$brand_id = isset($output['brand_id']) ? $output['brand_id'] : '';
$category_id = isset($output['category_id']) ? $output['category_id'] : 0;
$class_id = isset($output['class_id']) ? $output['class_id'] : 0;
$description = isset($output['description']) ? $output['description'] : '';
$desc_id = isset($output['desc_id']) ? $output['desc_id'] : '';
?>
<div class="edit-product">
    <div class="content-header">
        <h3>Update Product Header</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('product/update_product_header?ajax=1'); ?>" method="post"
          id="form_edit_product" onsubmit="return false;">
        <input type="hidden" value="<?php echo $id; ?>" name="product_header_id"/>

        <div class="content-subject">
            <?php if (isset($success)): ?>
            <div class="label label-success flash-message"><?php echo $success; ?></div>
            <?php elseif (isset($failed)): ?>
            <div class="label label-warning flash-message"><?php echo $failed; ?></div>
            <?php endif;?>

            <div class="label label-warning">Fill the Form</div>
            <div class="control-group">
                <label class="control-label">Name:</label>

                <div class="controls">
                    <input type="text" class="required" name="name" value="<?php echo $name; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Brand:</label>

                <div class="controls autocomplete-jui">
                    <div class="ui-widget input-append">
                        <input id="edit_product_brand_name" type="text" name="brand_name" value="<?php echo $brand; ?>">
                        <input id="edit_product_brand_id" name="brand_id" type="hidden"
                               value="<?php echo $brand_id; ?>"/>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tax Category:</label>

                <div class="controls">
                    <select name="category_id">
                        <option value="0">ROOT</option>
                        <?php
                        if (isset($category)) {
                            foreach ($category as $c) {
                                echo '<option value="' . $c['id'] . '"';
                                echo ($c['id'] == $category_id) ? ' selected ' : '';
                                echo '>' . $c['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Class Category:</label>

                <div class="controls">
                    <select name="class_id" id="edit_product_class_id">
                        <?php
                        $this->load->view('class/tree_drop_down', array('tree' => $class_tree, 'id' => $class_id));
                        ?>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>

                <div class="controls">
                    <textarea name="description"><?php echo $description; ?></textarea>
                    <input type="hidden" name="description_id" value="<?php echo $desc_id; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Attributes:</label>

                <div class="controls autocomplete-jui">
                    <div class="ui-widget input-append">
                        <input id="edit_product_class_attributes" type="text" class="input-add"/>
                        <span class="add-on search-image" id="edit_product_class_attributes_plus">
                            <i class="icon-plus"></i>
                        </span>

                        <div id="class_attributes_tags" class=""></div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="edit_product_attributes_row_count" value="0"/>
            <table class="table table-striped table-bordered" id="edit_product_attributes_table">
                <tr>
                    <th class="">Name</th>
                    <th>Value</th>
                    <th>Level</th>
                    <th>SKU</th>
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
    <?php
    foreach ($output['attributes'] as $v) {
        $v['display_name'] = (!is_null($v['display_name']) && $v['display_name'] != '') ? $v['display_name'] : $v['name'];
        echo 'products.editAdd(' . $v['id'] . ',"' . $v['name'] . '",' . $v['level'] . ',"' . $v['value'] . '", ' . $v['sku'] . ', "' . $v['display_name'] . '");';
    }
    ?>
    /*formValidate.submit('#form_edit_product', true, products.editValidate);
    formValidate.messages();*/
    app.autocomplete('#edit_product_brand_name', '/index.php/brand/suggest_brand?json=1&from=class', products.selectBrand);
    //element.change('#edit_product_class_id', products.changeClass, { 'table' : '#edit_product_attributes_table', 'row_count' : '#edit_product_attributes_row_count', 'class' : '#edit_product_class_id'} );
    app.autocomplete('#edit_product_class_attributes', '/index.php/classification/suggest_attribute?json=1&from=product', products.editSelect);
    element.click('#edit_product_class_attributes_plus', products.edit);

    validation.bind({
        formId:'#form_edit_product',
        ajaxSubmit:true,
        reload:true
    });
    element.focus('.edit-product input, .edit-product textarea', validation.focus);
    element.key_up('.edit-product input, .edit-product textarea', validation.focus);
</script>