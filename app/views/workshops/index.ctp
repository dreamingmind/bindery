<div class="workshops index">
	<h2><?php __('Workshops');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('hours');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($workshops as $workshop):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $workshop['Workshop']['id']; ?>&nbsp;</td>
		<td><?php echo $workshop['Workshop']['title']; ?>&nbsp;</td>
		<td><?php echo $workshop['Workshop']['description']; ?>&nbsp;</td>
		<td><?php echo $workshop['Workshop']['hours']; ?>&nbsp;</td>
		<td><?php echo $workshop['Workshop']['created']; ?>&nbsp;</td>
		<td><?php echo $workshop['Workshop']['modified']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $workshop['Workshop']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $workshop['Workshop']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $workshop['Workshop']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $workshop['Workshop']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Workshop', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Sessions', true), array('controller' => 'sessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session', true), array('controller' => 'sessions', 'action' => 'add')); ?> </li>
	</ul>
</div>