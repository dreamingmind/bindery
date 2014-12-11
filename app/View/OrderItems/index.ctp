<div class="orderItems index">
	<h2><?php echo __('Order Items'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('order_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('collection_id'); ?></th>
			<th><?php echo $this->Paginator->sort('content_id'); ?></th>
			<th><?php echo $this->Paginator->sort('image_id'); ?></th>
			<th><?php echo $this->Paginator->sort('product_name'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('quantity'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('product_code'); ?></th>
			<th><?php echo $this->Paginator->sort('option_summary'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($orderItems as $orderItem): ?>
	<tr>
		<td><?php echo h($orderItem['OrderItem']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($orderItem['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderItem['Order']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderItem['User']['username'], array('controller' => 'users', 'action' => 'view', $orderItem['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderItem['Collection']['heading'], array('controller' => 'collections', 'action' => 'view', $orderItem['Collection']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderItem['Content']['heading'], array('controller' => 'contents', 'action' => 'view', $orderItem['Content']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($orderItem['Image']['img_file'], array('controller' => 'images', 'action' => 'view', $orderItem['Image']['id'])); ?>
		</td>
		<td><?php echo h($orderItem['OrderItem']['product_name']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['price']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['quantity']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['type']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['product_code']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['option_summary']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['created']); ?>&nbsp;</td>
		<td><?php echo h($orderItem['OrderItem']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $orderItem['OrderItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $orderItem['OrderItem']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $orderItem['OrderItem']['id']), null, __('Are you sure you want to delete # %s?', $orderItem['OrderItem']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Order Item'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Order'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections'), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection'), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
	</ul>
</div>
