<div class="diagrams index">
	<h2><?php __('Diagrams');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('x');?></th>
			<th><?php echo $this->Paginator->sort('y');?></th>
			<th><?php echo $this->Paginator->sort('product_group');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($diagrams as $diagram):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $diagram['Diagram']['id']; ?>&nbsp;</td>
		<td><?php echo $diagram['Diagram']['created']; ?>&nbsp;</td>
		<td><?php echo $diagram['Diagram']['modified']; ?>&nbsp;</td>
		<td><?php echo $diagram['Diagram']['x']; ?>&nbsp;</td>
		<td><?php echo $diagram['Diagram']['y']; ?>&nbsp;</td>
		<td><?php echo $diagram['Diagram']['product_group']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $diagram['Diagram']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $diagram['Diagram']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $diagram['Diagram']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $diagram['Diagram']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Diagram', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Catalogs', true), array('controller' => 'catalogs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog', true), array('controller' => 'catalogs', 'action' => 'add')); ?> </li>
	</ul>
</div>