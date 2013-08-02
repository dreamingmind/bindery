<div class="sessions index">
	<h2><?php __('Sessions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('cost');?></th>
			<th><?php echo $this->Paginator->sort('participants');?></th>
			<th><?php echo $this->Paginator->sort('first_day');?></th>
			<th><?php echo $this->Paginator->sort('last_day');?></th>
			<th><?php echo $this->Paginator->sort('registered');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($sessions as $session):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $session['Session']['id']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['title']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['cost']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['participants']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['first_day']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['last_day']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['registered']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['modified']; ?>&nbsp;</td>
		<td><?php echo $session['Session']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $session['Session']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $session['Session']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $session['Session']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $session['Session']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Session', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Workshops', true), array('controller' => 'workshops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop', true), array('controller' => 'workshops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dates', true), array('controller' => 'dates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Date', true), array('controller' => 'dates', 'action' => 'add')); ?> </li>
	</ul>
</div>