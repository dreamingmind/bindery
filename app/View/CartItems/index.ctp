<div class="carts index">
	<h2><?php echo __('Carts'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('session_id'); ?></th>
			<th><?php echo $this->Paginator->sort('design_name'); ?></th>
			<th><?php echo $this->Html->para('toggle', 'data', array('id' => 'dataColumn')); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($carts as $cart): ?>
	<tr>
		<td><?php echo h($cart['CartItem']['id']); ?>&nbsp;</td>
		<td><?php echo date('m-d h:i', strtotime(h($cart['CartItem']['created']))); ?>&nbsp;</td>
		<td><?php echo date('m-d h:i', strtotime(h($cart['CartItem']['modified']))); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($cart['User']['username'], array('controller' => 'users', 'action' => 'view', $cart['User']['id'])); ?>
		</td>
		<td>
			<?php echo h($cart['CartItem']['session_id']); ?>
		</td>
		<td><?php echo h($cart['CartItem']['design_name']); ?>&nbsp;</td>
		<td><?php echo $this->Html->para('dataColumn hide', h($cart['CartItem']['data'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cart['CartItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cart['CartItem']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cart['CartItem']['id']), null, __('Are you sure you want to delete # %s?', $cart['CartItem']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Cart'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
