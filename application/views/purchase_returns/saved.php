<!-- User Access Message -->
<?php if (isset($access)): ?>
<h3><?= $access ?></h3>
<?php else: ?>
<div class="" align="center">
    <a class="btn content-menu" href="<?php echo site_url('purchase_returns'); ?>">RETURN</a>
    <a class="btn content-menu selected" href="#">REPORTS</a>
</div>
<div class="content-menu-body">
    <div class="content-header">
        <h3>Saved Purchase Returns</h3>
        <!--<b class="pull-right">Date: <?php /*echo date('M jS,  Y'); */?></b>-->
    </div>
    <?php if (isset($grid)): ?>
    <div class="content-subject">
        <?php echo $grid; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
