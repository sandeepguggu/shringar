<script type="text/javascript">
    $(function(){
        add_ajaxSubmit('add-metal-form');
    });
</script>
<?php if (isset($status)): ?>
    <div class="alert-message <?php if ($status == true) echo 'success'; else echo 'danger'; ?>"><?= $msg; ?></div>
<?php endif; ?>
<div class="add-metal">
    <h3 class="my-header">Add Metal</h3>
    <form action="<?= site_url('product/add_metal_to_db?ajax=1'); ?>" id="add-metal-form">
        <fieldset class="my-block my-fieldset">
            <div class="my-block">
                <label class="pull-left span3">Name:</label>
                <div class="pull-left span3">
                    <input type="text" class="required span3" name="metal-name" />
                </div>
            </div>
            <div class="my-block">
                <label class="pull-left span3">Karat:</label>
                <div class="pull-left span3">
                    <input type="text" class="required span3" name="metal-karat" />
                </div>
            </div>
            <div class="my-block">
                <label class="pull-left span3">Fineness:</label>
                <div class="pull-left span3">
                    <input type="text" class="required span3" name="metal-fineness" />
                </div>
            </div>
            <div class="my-block">
                <label class="pull-left span3">Old:</label>
                <div class="pull-left span3">
                    <input type="radio" class="pull-left" name="metal-old" value="1"/>
                    <label class="span1 pull-left">Yes</label>
                    <input type="radio" class="pull-left" name="metal-old" value="0" checked/>
                    <label class="span1 pull-left">No</label>
                </div>
            </div>
            <div class="my-block">
                <label class="pull-left span3">Type:</label>
                <div class="pull-left span3">
                    <select name="metal-type" class="span3">
                        <option value="gold" selected="selected">Gold</option>
                        <option value="silver">Silver</option>
                        <option value="platinum">Platinum</option>
                    </select>
                </div>
            </div>
            <div class="my-block">
                <label class="pull-left span3">Category:</label>
                <div class="pull-left span3">
                    <select name="metal-category" class="span3" min="1">
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