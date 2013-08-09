<div class="supplements index">
	<h2><?php __('Supplements');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th><?php echo $this->Paginator->sort('content_collection_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($supplements as $supplement):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $supplement['Supplement']['id']; ?>&nbsp;</td>
		<td><?php echo $supplement['Supplement']['modified']; ?>&nbsp;</td>
		<td><?php echo $supplement['Supplement']['created']; ?>&nbsp;</td>
		<td><?php echo $supplement['Supplement']['type']; ?>&nbsp;</td>
		<td><?php echo $supplement['Supplement']['data']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($supplement['ContentCollection']['id'], array('controller' => 'content_collections', 'action' => 'view', $supplement['ContentCollection']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $supplement['Supplement']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $supplement['Supplement']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $supplement['Supplement']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $supplement['Supplement']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Supplement', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Content Collections', true), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection', true), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>