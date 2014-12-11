<div class="contents index">
	<h2><?php echo __('Contents');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('content');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('image_id');?></th>
			<th><?php echo $this->Paginator->sort('alt');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('heading');?></th>
			<!--<th><?php // echo $this->Paginator->sort('publish');?></th>-->
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contents as $content):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $content['Content']['id']; ?>&nbsp;</td>
		<td><?php echo $content['Content']['content']; ?>&nbsp;</td>
		<td><?php echo $content['Content']['created']; ?>&nbsp;</td>
		<td><?php echo $content['Content']['modified']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($content['Image']['img_file'], array('controller' => 'images', 'action' => 'view', $content['Image']['id'])); ?>
		</td>
		<td><?php echo $content['Content']['alt']; ?>&nbsp;</td>
		<td><?php echo $content['Content']['title']; ?>&nbsp;</td>
		<td><?php echo $content['Content']['heading']; ?>&nbsp;</td>
		<!--<td><?php // echo $content['Content']['publish']; ?>&nbsp;</td>-->
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $content['Content']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $content['Content']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $content['Content']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $content['Content']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Content'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>