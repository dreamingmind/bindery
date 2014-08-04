<div class="navlines view">
<h2><?php echo __('Navline');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Route'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['route']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Route Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['route_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Navline'), array('action' => 'edit', $navline['Navline']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Navline'), array('action' => 'delete', $navline['Navline']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $navline['Navline']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Navlines'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Navigators'), array('controller' => 'navigators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navigator'), array('controller' => 'navigators', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Navigators');?></h3>
	<?php if (!empty($navline['Navigator'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
		<th><?php echo __('Navline Id'); ?></th>
		<th><?php echo __('Account'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($navline['Navigator'] as $navigator):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $navigator['id'];?></td>
			<td><?php echo $navigator['parent_id'];?></td>
			<td><?php echo $navigator['lft'];?></td>
			<td><?php echo $navigator['rght'];?></td>
			<td><?php echo $navigator['navline_id'];?></td>
			<td><?php echo $navigator['account'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'navigators', 'action' => 'view', $navigator['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'navigators', 'action' => 'edit', $navigator['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'navigators', 'action' => 'delete', $navigator['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $navigator['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Navigator'), array('controller' => 'navigators', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
