<?php if ($wishCount > 0) : ?>
<!-- Elements/Cart/wish_badge.ctp -->
	<div id="wish_badge" class="badge">
		<p> | 
			<?php 
			echo $this->Html->link(
				$this->Html->image('lamp-r.jpg', array('alt' => 'wishlist icon')) . ' ' . $wishCount,
				array('controller' => 'accounts', 'action' => 'wish_list'), 
				array('escape' => FALSE, 'title' => 'Wish List')
			);
			?>
		</p>
	</div>
<?php endif ?>
<!-- END Elements/Cart/wish_badge.ctp END -->
