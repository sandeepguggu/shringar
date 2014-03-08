<!-- User Access Message -->
<?php if (isset($access)): ?>
<h3><?= $access ?></h3>
<?php else: ?>
<div class="create_btn">
    <a class="btn content-menu" href="<?php echo site_url('po'); ?>">CREATE PO</a>
    <a class="btn content-menu selected" href="#">SAVED PO</a>
</div>
<div class="content-menu-body">
    <div class="content-header">
        <h3>Saved Purchase Orders</h3>
        <!--<b class="pull-right">Date: <?php /*echo date('M jS,  Y'); */?></b>-->
    </div>
    <?php if (isset($grid)): ?>
    <div class="content-subject">
        <?php echo $grid; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
