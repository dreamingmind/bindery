<div class="dispatches index">
	<h2><?php __('Dispatches');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('img_file');?></th>
			<th><?php echo $this->Paginator->sort('news_text');?></th>
			<th><?php echo $this->Paginator->sort('gallery');?></th>
			<th><?php echo $this->Paginator->sort('publish');?></th>
			<th><?php echo $this->Paginator->sort('alt');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('date');?></th>
			<th><?php echo $this->Paginator->sort('image_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($dispatches as $dispatch):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $dispatch['Dispatch']['id']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['img_file']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['news_text']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['gallery']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['publish']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['alt']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['modified']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['created']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['date']; ?>&nbsp;</td>
		<td><?php echo $dispatch['Dispatch']['image_id']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $dispatch['Dispatch']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $dispatch['Dispatch']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $dispatch['Dispatch']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $dispatch['Dispatch']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Dispatch', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Images', true), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Galleries', true), array('controller' => 'galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gallery', true), array('controller' => 'galleries', 'action' => 'add')); ?> </li>
	</ul>
</div>