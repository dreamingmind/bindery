<div class="contentCollections index">
	<h2><?php __('Content Collections');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('gallery_id');?></th>
			<th><?php echo $this->Paginator->sort('dispatch_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('visible');?></th>
			<th><?php echo $this->Paginator->sort('sub_gallery');?></th>
			<th><?php echo $this->Paginator->sort('content_id');?></th>
			<th><?php echo $this->Paginator->sort('exhibit_id');?></th>
			<th><?php echo $this->Paginator->sort('collection_id');?></th>
			<th><?php echo $this->Paginator->sort('seq');?></th>
			<th class="actions"><?php __('Actions');?></th>
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
		<td>
			<?php echo $this->Html->link($contentCollection['Gallery']['role'], array('controller' => 'galleries', 'action' => 'view', $contentCollection['Gallery']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentCollection['Dispatch']['title'], array('controller' => 'dispatches', 'action' => 'view', $contentCollection['Dispatch']['id'])); ?>
		</td>
		<td><?php echo $contentCollection['ContentCollection']['created']; ?>&nbsp;</td>
		<td><?php echo $contentCollection['ContentCollection']['modified']; ?>&nbsp;</td>
		<td><?php echo $contentCollection['ContentCollection']['id']; ?>&nbsp;</td>
		<td><?php echo $contentCollection['ContentCollection']['visible']; ?>&nbsp;</td>
		<td><?php echo $contentCollection['ContentCollection']['sub_gallery']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contentCollection['Content']['title'], array('controller' => 'contents', 'action' => 'view', $contentCollection['Content']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentCollection['Exhibit']['heading'], array('controller' => 'exhibits', 'action' => 'view', $contentCollection['Exhibit']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contentCollection['Collection']['id'], array('controller' => 'collections', 'action' => 'view', $contentCollection['Collection']['id'])); ?>
		</td>
		<td><?php echo $contentCollection['ContentCollection']['seq']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $contentCollection['ContentCollection']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $contentCollection['ContentCollection']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $contentCollection['ContentCollection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contentCollection['ContentCollection']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Content Collection', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Galleries', true), array('controller' => 'galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gallery', true), array('controller' => 'galleries', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dispatches', true), array('controller' => 'dispatches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dispatch', true), array('controller' => 'dispatches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibits', true), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
	</ul>
</div>