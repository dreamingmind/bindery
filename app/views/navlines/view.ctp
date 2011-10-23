<div class="navlines view">
<h2><?php  __('Navline');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Route'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['route']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Route Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['route_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $navline['Navline']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Navline', true), array('action' => 'edit', $navline['Navline']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Navline', true), array('action' => 'delete', $navline['Navline']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $navline['Navline']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Navlines', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Navigators', true), array('controller' => 'navigators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navigator', true), array('controller' => 'navigators', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Navigators');?></h3>
	<?php if (!empty($navline['Navigator'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Parent Id'); ?></th>
		<th><?php __('Lft'); ?></th>
		<th><?php __('Rght'); ?></th>
		<th><?php __('Navline Id'); ?></th>
		<th><?php __('Account'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'navigators', 'action' => 'view', $navigator['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'navigators', 'action' => 'edit', $navigator['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'navigators', 'action' => 'delete', $navigator['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $navigator['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Navigator', true), array('controller' => 'navigators', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
