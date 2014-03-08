<div class="class">
    <div class="content-header">
        <h3>Mange Classification category</h3>
        <a id="vendor_add_class_btn" href="<?php echo site_url('classification/add_class?ajax=1'); ?>"
           class="btn btn-primary fancybox pull-right">
            <!--<i class="icon-tags icon-white"></i>-->
            Add Class
        </a>

        <div class="pull-right">&nbsp; &nbsp;</div>
        <div class="pull-right input-append">
            <input class="span2" type="text"/>
			<span class="add-on search-image">
				<i class="icon-search"></i>
			</span>
        </div>
    </div>
    <div class="content-subject">
        <?php
        if (!isset($class_tree) || !is_array($class_tree) || count($class_tree) < 1) {
            log_message('error', '#22, classification/index.php error');
            $class_tree = array();
        }
        ?>
        <div class="row-fluid">
            <div id="class_tree" class="span6">
                <?php
                $this->load->view('class/tree_template', array('tree' => $class_tree));
                ?>
            </div>
            <div id="class_default_message" class="hide">
                <div class="content-header">
                    <h3>ROOT</h3>
                </div>
                <div class="content-subject">
                    <p>
                        Click on Classification category names to see the description here.
                        <br>
                        You can Edit & Delete Categories from here.
                    </p>
                </div>
            </div>
            <div id="class_view" class="span6 content-menu-body">
                <div class="content-header">
                    <h3>ROOT</h3>
                </div>
                <div class="content-subject">
                    <p>
                        Click on Classification category names to see the description here.
                        <br>
                        You can Edit & Delete Categories from here.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    fancyBox.bind();
    tree.create('#class_tree', { initially_open:'0', select:classes.view});
</script>