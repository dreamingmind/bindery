<div class="editions index">
	<h2><?php __('Editions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('collection_id');?></th>
			<th><?php echo $this->Paginator->sort('size');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($editions as $edition):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $edition['Edition']['id']; ?>&nbsp;</td>
		<td><?php echo $edition['Edition']['created']; ?>&nbsp;</td>
		<td><?php echo $edition['Edition']['modified']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($edition['Collection']['heading'], array('controller' => 'collections', 'action' => 'view', $edition['Collection']['id'])); ?>
		</td>
		<td><?php echo $edition['Edition']['size']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $edition['Edition']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $edition['Edition']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $edition['Edition']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $edition['Edition']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Edition', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Copies', true), array('controller' => 'copies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Copy', true), array('controller' => 'copies', 'action' => 'add')); ?> </li>
	</ul>
</div>