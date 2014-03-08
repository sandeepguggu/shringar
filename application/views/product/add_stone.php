<script type="text/javascript">
    add_ajaxSubmit('add-stone-form');
</script>
<?php if (isset($status)): ?>
    <div class="alert-message <?php if ($status == true) echo 'success'; else echo 'danger'; ?>"><?= $msg; ?></div>
<?php else: ?>
    <div class="add-metal">
        <h3 class="my-header">Add Stone</h3>
        <form action="<?= site_url('product/add_stone_to_db?ajax=1'); ?>" id="add-stone-form">
            <fieldset class="my-block my-fieldset">
                <div class="my-block">
                    <label class="pull-left span3">Name:</label>
                    <div class="pull-left span3">
                        <input type="text" class="required span3" name="stone-name" />
                    </div>
                </div>
                <div class="my-block">
                    <label class="pull-left span3">Type:</label>
                    <div class="pull-left span3">
                        <select name="stone-type" class="span3">
                            <option value="stone" selected="selected">Normal</option>
                            <option value="gemstone">Gem Stone</option>
                            <option value="diamond">Diamond</option>
                        </select>
                    </div>
                </div>
                <div class="my-block">
                    <label class="pull-left span3">Category:</label>
                    <div class="pull-left span3">
                        <select name="stone-category" class="span3">
                            <option value="">Select-Category</option>
                            <?php
                            if (isset($category) && is_array($category)) {
                                foreach ($category as $c) {
                                    echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>' . "\n";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </fieldset>
            <div class="my-block print-center-200">
                <input type="submit" class="btn primary span2" value="Add" /> 
                <input type="button" class="btn danger span2" value="Cancel" onclick="$.fancybox.close();" />
            </div>
        </form>
    </div>    
<?php endif; ?>