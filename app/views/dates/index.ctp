<div class="dates index">
	<h2><?php __('Dates');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('session_id');?></th>
			<th><?php echo $this->Paginator->sort('date');?></th>
			<th><?php echo $this->Paginator->sort('start_time');?></th>
			<th><?php echo $this->Paginator->sort('end_time');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($dates as $date):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $date['Date']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($date['Session']['title'], array('controller' => 'sessions', 'action' => 'view', $date['Session']['id'])); ?>
		</td>
		<td><?php echo $date['Date']['date']; ?>&nbsp;</td>
		<td><?php echo $date['Date']['start_time']; ?>&nbsp;</td>
		<td><?php echo $date['Date']['end_time']; ?>&nbsp;</td>
		<td><?php echo $date['Date']['modified']; ?>&nbsp;</td>
		<td><?php echo $date['Date']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $date['Date']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $date['Date']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $date['Date']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $date['Date']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Date', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sessions', true), array('controller' => 'sessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session', true), array('controller' => 'sessions', 'action' => 'add')); ?> </li>
	</ul>
</div>