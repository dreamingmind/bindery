<!-- Elements/Cart/wish_badge.ctp -->
	<div id="wish_badge" class="badge">
<?php if ($wishCount > 0) : ?>
		<p> | 
			<?php 
			echo $this->Html->link(
				$this->Html->image('lamp-r.jpg', array('alt' => 'wishlist icon')) . ' ' . $wishCount,
				array('controller' => 'accounts', 'action' => 'wish_list'), 
				array('escape' => FALSE, 'title' => 'Wish List')
			);
			?>
		</p>
<?php endif ?>
	</div>
<!-- END Elements/Cart/wish_badge.ctp END -->
