<?php if($error == true): ?>
	<div class="alert-message danger span8"><?php echo $msg ?></div>
<?php else: ?>
	<div class="alert-message success span8"><?php echo $msg ?></div>
<?php endif; ?>
<input type="button" class="btn" value="Close" onclick="$.fancybox.close();" />
