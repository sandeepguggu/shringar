<div class="content-subject" style="min-width: 400px">
	<?php if(isset($msg)) : ?>
		<div class="label label-warning"><?php echo $msg; ?></div>
	<?php else: ?>
		<div class="label label-warning"><?php echo $success; ?> :-)</div>
	<?php endif; ?>
</div>
<div class="content-footer">
	<button type="button" class="btn btn-primary pull-right" onclick="$.fancybox.close();">
		<i class="icon-off icon-white"></i>
		&nbsp;Close
	</button>			
</div>