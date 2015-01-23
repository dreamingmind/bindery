<?php if ($wishCount > 0) : ?>
	<div id="wish_badge" class="badge">
		<p> | </p>
		
		<?php echo $this->Html->image('lamp-r.jpg', array('alt' => 'wishlist icon')); ?>
		
		<p><?php echo $wishCount . (($purchaseCount > 0) ? ' | ' : ''); ?></p>
	</div>
<?php endif ?>
