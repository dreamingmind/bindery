<div class="catalogs index">
	<h2><?php echo __('Catalogs');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('size');?></th>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('product_group');?></th>
			<th><?php echo $this->Paginator->sort('price');?></th>
			<th><?php echo $this->Paginator->sort('category');?></th>
			<th><?php echo $this->Paginator->sort('product_code');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($catalogs as $catalog):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $catalog['Catalog']['size']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['id']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['product_group']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['price']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['category']; ?>&nbsp;</td>
		<td><?php echo $catalog['Catalog']['product_code']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $catalog['Catalog']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $catalog['Catalog']['id'])); ?>
			<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $catalog['Catalog']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $catalog['Catalog']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Catalog'), array('action' => 'add')); ?></li>
	</ul>
</div>