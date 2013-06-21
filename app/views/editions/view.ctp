<div class="editions view">
<h2><?php  __('Edition');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $edition['Edition']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $edition['Edition']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $edition['Edition']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Collection'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($edition['Collection']['heading'], array('controller' => 'collections', 'action' => 'view', $edition['Collection']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Size'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $edition['Edition']['size']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Edition', true), array('action' => 'edit', $edition['Edition']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Edition', true), array('action' => 'delete', $edition['Edition']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $edition['Edition']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Editions', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Edition', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Copies', true), array('controller' => 'copies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Copy', true), array('controller' => 'copies', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Copies');?></h3>
	<?php if (!empty($edition['Copy'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Edition Id'); ?></th>
		<th><?php __('Number'); ?></th>
		<th><?php __('Status'); ?></th>
		<th><?php __('Location'); ?></th>
		<th><?php __('Notes'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($edition['Copy'] as $copy):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $copy['id'];?></td>
			<td><?php echo $copy['created'];?></td>
			<td><?php echo $copy['modified'];?></td>
			<td><?php echo $copy['edition_id'];?></td>
			<td><?php echo $copy['number'];?></td>
			<td><?php echo $copy['status'];?></td>
			<td><?php echo $copy['location'];?></td>
			<td><?php echo $copy['notes'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'copies', 'action' => 'view', $copy['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'copies', 'action' => 'edit', $copy['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'copies', 'action' => 'delete', $copy['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $copy['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Copy', true), array('controller' => 'copies', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
