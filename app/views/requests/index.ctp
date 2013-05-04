<div class="requests index">
	<h2><?php __('Requests');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('workshop_name');?></th>
			<th><?php echo $this->Paginator->sort('month');?></th>
			<th><?php echo $this->Paginator->sort('year');?></th>
			<th><?php echo $this->Paginator->sort('message');?></th>
			<th><?php echo $this->Paginator->sort('workshop_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($requests as $request):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $request['Request']['id']; ?>&nbsp;</td>
		<td><?php echo $request['Request']['modified']; ?>&nbsp;</td>
		<td><?php echo $request['Request']['created']; ?>&nbsp;</td>
		<td><?php echo $request['Request']['email']; ?>&nbsp;</td>
		<td><?php echo $request['Request']['workshop_name']; ?>&nbsp;</td>
		<td><?php echo $request['Request']['month']; ?>&nbsp;</td>
		<td><?php echo $request['Request']['year']; ?>&nbsp;</td>
		<td><?php echo $request['Request']['message']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($request['Workshop']['id'], array('controller' => 'workshops', 'action' => 'view', $request['Workshop']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $request['Request']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $request['Request']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $request['Request']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $request['Request']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Request', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Workshops', true), array('controller' => 'workshops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop', true), array('controller' => 'workshops', 'action' => 'add')); ?> </li>
	</ul>
</div>