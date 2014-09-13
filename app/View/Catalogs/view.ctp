<div class="catalogs view">
<h2><?php echo __('Catalog');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $catalog['Catalog']['size']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $catalog['Catalog']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Product Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $catalog['Catalog']['product_group']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Price'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $catalog['Catalog']['price']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $catalog['Catalog']['category']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Product Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $catalog['Catalog']['product_code']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Catalog'), array('action' => 'edit', $catalog['Catalog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Catalog'), array('action' => 'delete', $catalog['Catalog']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $catalog['Catalog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Catalogs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog'), array('action' => 'add')); ?> </li>
	</ul>
</div>
