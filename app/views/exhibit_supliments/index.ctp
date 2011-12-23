<div class="exhibitSupliments index">
	<h2><?php __('Exhibit Supliments');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('img_file');?></th>
			<th><?php echo $this->Paginator->sort('heading');?></th>
			<th><?php echo $this->Paginator->sort('prose');?></th>
			<th><?php echo $this->Paginator->sort('prose_t');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('top_val');?></th>
			<th><?php echo $this->Paginator->sort('left_val');?></th>
			<th><?php echo $this->Paginator->sort('height_val');?></th>
			<th><?php echo $this->Paginator->sort('width_val');?></th>
			<th><?php echo $this->Paginator->sort('headstyle');?></th>
			<th><?php echo $this->Paginator->sort('pgraphstyle');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('alt');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('image_id');?></th>
			<th><?php echo $this->Paginator->sort('mimetype');?></th>
			<th><?php echo $this->Paginator->sort('filesize');?></th>
			<th><?php echo $this->Paginator->sort('width');?></th>
			<th><?php echo $this->Paginator->sort('height');?></th>
			<th><?php echo $this->Paginator->sort('exhibit_id');?></th>
			<th><?php echo $this->Paginator->sort('content_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($exhibitSupliments as $exhibitSupliment):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['img_file']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['heading']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['prose']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['prose_t']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['id']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['top_val']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['left_val']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['height_val']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['width_val']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['headstyle']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['pgraphstyle']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['modified']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['alt']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['created']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($exhibitSupliment['Image']['img_file'], array('controller' => 'images', 'action' => 'view', $exhibitSupliment['Image']['id'])); ?>
		</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['mimetype']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['filesize']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['width']; ?>&nbsp;</td>
		<td><?php echo $exhibitSupliment['ExhibitSupliment']['height']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($exhibitSupliment['Exhibit']['heading'], array('controller' => 'exhibits', 'action' => 'view', $exhibitSupliment['Exhibit']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($exhibitSupliment['Content']['title'], array('controller' => 'contents', 'action' => 'view', $exhibitSupliment['Content']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $exhibitSupliment['ExhibitSupliment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $exhibitSupliment['ExhibitSupliment']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $exhibitSupliment['ExhibitSupliment']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $exhibitSupliment['ExhibitSupliment']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Exhibit Supliment', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Images', true), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibits', true), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>