<div class="designs index">
	<h2><?php __('Designs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('design_name');?></th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th><?php echo $this->Paginator->sort('supplement_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($designs as $design):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $design['Design']['id']; ?>&nbsp;</td>
		<td><?php echo $design['Design']['created']; ?>&nbsp;</td>
		<td><?php echo $design['Design']['modified']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($design['User']['username'], array('controller' => 'users', 'action' => 'view', $design['User']['id'])); ?>
		</td>
		<td><?php echo $design['Design']['design_name']; ?>&nbsp;</td>
		<td><?php echo $design['Design']['data']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($design['Supplement']['id'], array('controller' => 'supplements', 'action' => 'view', $design['Supplement']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $design['Design']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $design['Design']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $design['Design']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $design['Design']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Design', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements', true), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement', true), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>