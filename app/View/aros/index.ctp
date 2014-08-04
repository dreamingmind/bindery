<div class="aros index">
	<h2><?php echo __('Aros');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('model');?></th>
			<th><?php echo $this->Paginator->sort('foreign_key');?></th>
			<th><?php echo $this->Paginator->sort('alias');?></th>
			<th><?php echo $this->Paginator->sort('lft');?></th>
			<th><?php echo $this->Paginator->sort('rght');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($aros as $aro):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $aro['Aro']['id']; ?>&nbsp;</td>
		<td><?php echo $aro['Aro']['parent_id']; ?>&nbsp;</td>
		<td><?php echo $aro['Aro']['model']; ?>&nbsp;</td>
		<td><?php echo $aro['Aro']['foreign_key']; ?>&nbsp;</td>
		<td><?php echo $aro['Aro']['alias']; ?>&nbsp;</td>
		<td><?php echo $aro['Aro']['lft']; ?>&nbsp;</td>
		<td><?php echo $aro['Aro']['rght']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $aro['Aro']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $aro['Aro']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $aro['Aro']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $aro['Aro']['id'])); ?>
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
		<?php echo $this->Paginator->prev('<< '.__('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next').' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Aro')), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Acos')), array('controller' => 'acos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Aco')), array('controller' => 'acos', 'action' => 'add')); ?> </li>
	</ul>
</div>