<div class="contentCollections index">
	<h2><?php echo __('Content Collections');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('publish');?></th>
			<th><?php echo $this->Paginator->sort('sub_slug');?></th>
			<th><?php echo $this->Paginator->sort('content_id');?></th>
			<th><?php echo $this->Paginator->sort('collection_id');?></th>
			<th><?php echo $this->Paginator->sort('seq');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contentCollections as $contentCollection):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $contentCollection['ContentCollection']['created']; ?>&nbsp;</td>
		<td><?php echo $contentCollection['ContentCollection']['modified']; ?>&nbsp;</td>
		<td><?php echo $contentCollection['ContentCollection']['id']; ?>&nbsp;</td>
		<td><?php echo $contentCollection['ContentCollection']['publish']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contentCollection['DetailCollection']['id'], array('controller' => 'collections', 'action' => 'view', $contentCollection['DetailCollection']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentCollection['Content']['heading'], array('controller' => 'contents', 'action' => 'view', $contentCollection['Content']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentCollection['Collection']['id'], array('controller' => 'collections', 'action' => 'view', $contentCollection['Collection']['id'])); ?>
		</td>
		<td><?php echo $contentCollection['ContentCollection']['seq']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contentCollection['ContentCollection']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contentCollection['ContentCollection']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $contentCollection['ContentCollection']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $contentCollection['ContentCollection']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Collections'), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detail Collection'), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements'), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement'), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>