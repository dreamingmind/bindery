<div class="diagrams view">
<h2><?php  __('Diagram');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $diagram['Diagram']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $diagram['Diagram']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $diagram['Diagram']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('X'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $diagram['Diagram']['x']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Y'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $diagram['Diagram']['y']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Product Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $diagram['Diagram']['product_group']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Diagram', true), array('action' => 'edit', $diagram['Diagram']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Diagram', true), array('action' => 'delete', $diagram['Diagram']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $diagram['Diagram']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Diagrams', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Diagram', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Catalogs', true), array('controller' => 'catalogs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog', true), array('controller' => 'catalogs', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Catalogs');?></h3>
	<?php if (!empty($diagram['Catalog'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Size'); ?></th>
		<th><?php __('Id'); ?></th>
		<th><?php __('Product Group'); ?></th>
		<th><?php __('Price'); ?></th>
		<th><?php __('Category'); ?></th>
		<th><?php __('Product Code'); ?></th>
		<th><?php __('Y Index'); ?></th>
		<th><?php __('X Index'); ?></th>
		<th><?php __('Xx Index'); ?></th>
		<th><?php __('Yy Index'); ?></th>
		<th><?php __('Collection Id'); ?></th>
		<th><?php __('Table Sequence'); ?></th>
		<th><?php __('Column Sequence'); ?></th>
		<th><?php __('Diagram Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($diagram['Catalog'] as $catalog):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $catalog['size'];?></td>
			<td><?php echo $catalog['id'];?></td>
			<td><?php echo $catalog['product_group'];?></td>
			<td><?php echo $catalog['price'];?></td>
			<td><?php echo $catalog['category'];?></td>
			<td><?php echo $catalog['product_code'];?></td>
			<td><?php echo $catalog['y_index'];?></td>
			<td><?php echo $catalog['x_index'];?></td>
			<td><?php echo $catalog['xx_index'];?></td>
			<td><?php echo $catalog['yy_index'];?></td>
			<td><?php echo $catalog['collection_id'];?></td>
			<td><?php echo $catalog['table_sequence'];?></td>
			<td><?php echo $catalog['column_sequence'];?></td>
			<td><?php echo $catalog['diagram_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'catalogs', 'action' => 'view', $catalog['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'catalogs', 'action' => 'edit', $catalog['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'catalogs', 'action' => 'delete', $catalog['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $catalog['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Catalog', true), array('controller' => 'catalogs', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
