<div class="acos view">
<h2><?php echo __('Aco');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $aco['Aco']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Parent Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $aco['Aco']['parent_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Model'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $aco['Aco']['model']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Foreign Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $aco['Aco']['foreign_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Alias'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $aco['Aco']['alias']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Lft'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $aco['Aco']['lft']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rght'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $aco['Aco']['rght']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(sprintf(__('Edit %s'), __('Aco')), array('action' => 'edit', $aco['Aco']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('Delete %s'), __('Aco')), array('action' => 'delete', $aco['Aco']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $aco['Aco']['id'])); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Acos')), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Aco')), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Aros')), array('controller' => 'aros', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Aro')), array('controller' => 'aros', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php printf(__('Related %s'), __('Aros'));?></h3>
	<?php if (!empty($aco['Aro'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Model'); ?></th>
		<th><?php echo __('Foreign Key'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($aco['Aro'] as $aro):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $aro['id'];?></td>
			<td><?php echo $aro['parent_id'];?></td>
			<td><?php echo $aro['model'];?></td>
			<td><?php echo $aro['foreign_key'];?></td>
			<td><?php echo $aro['alias'];?></td>
			<td><?php echo $aro['lft'];?></td>
			<td><?php echo $aro['rght'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'aros', 'action' => 'view', $aro['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'aros', 'action' => 'edit', $aro['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'aros', 'action' => 'delete', $aro['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $aro['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Aro')), array('controller' => 'aros', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
