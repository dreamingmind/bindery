<div class="copies index">
	<h2><?php __('Copies');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('edition_id');?></th>
			<th><?php echo $this->Paginator->sort('number');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th><?php echo $this->Paginator->sort('location');?></th>
			<th><?php echo $this->Paginator->sort('notes');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($copies as $copy):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $copy['Copy']['id']; ?>&nbsp;</td>
		<td><?php echo $copy['Copy']['created']; ?>&nbsp;</td>
		<td><?php echo $copy['Copy']['modified']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($copy['Edition']['id'], array('controller' => 'editions', 'action' => 'view', $copy['Edition']['id'])); ?>
		</td>
		<td><?php echo $copy['Copy']['number']; ?>&nbsp;</td>
		<td><?php echo $copy['Copy']['status']; ?>&nbsp;</td>
		<td><?php echo $copy['Copy']['location']; ?>&nbsp;</td>
		<td><?php echo $copy['Copy']['notes']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $copy['Copy']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $copy['Copy']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $copy['Copy']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $copy['Copy']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Copy', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Editions', true), array('controller' => 'editions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Edition', true), array('controller' => 'editions', 'action' => 'add')); ?> </li>
	</ul>
</div>