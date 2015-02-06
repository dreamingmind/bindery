<div class="policies view">
<h2><?php echo __('Policy'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Policy'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['policy']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name Display'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['name_display']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Policy Display'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['policy_display']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parent Policy'); ?></dt>
		<dd>
			<?php echo $this->Html->link($policy['ParentPolicy']['name'], array('controller' => 'policies', 'action' => 'view', $policy['ParentPolicy']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sequence'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['sequence']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Lft'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['lft']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rght'); ?></dt>
		<dd>
			<?php echo h($policy['Policy']['rght']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Policy'), array('action' => 'edit', $policy['Policy']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Policy'), array('action' => 'delete', $policy['Policy']['id']), null, __('Are you sure you want to delete # %s?', $policy['Policy']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Policies'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Policy'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Policies'), array('controller' => 'policies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Policy'), array('controller' => 'policies', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Policies'); ?></h3>
	<?php if (!empty($policy['ChildPolicy'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Policy'); ?></th>
		<th><?php echo __('Name Display'); ?></th>
		<th><?php echo __('Policy Display'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Sequence'); ?></th>
		<th><?php echo __('Lft'); ?></th>
		<th><?php echo __('Rght'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($policy['ChildPolicy'] as $childPolicy): ?>
		<tr>
			<td><?php echo $childPolicy['id']; ?></td>
			<td><?php echo $childPolicy['created']; ?></td>
			<td><?php echo $childPolicy['modified']; ?></td>
			<td><?php echo $childPolicy['name']; ?></td>
			<td><?php echo $childPolicy['policy']; ?></td>
			<td><?php echo $childPolicy['name_display']; ?></td>
			<td><?php echo $childPolicy['policy_display']; ?></td>
			<td><?php echo $childPolicy['parent_id']; ?></td>
			<td><?php echo $childPolicy['sequence']; ?></td>
			<td><?php echo $childPolicy['lft']; ?></td>
			<td><?php echo $childPolicy['rght']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'policies', 'action' => 'view', $childPolicy['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'policies', 'action' => 'edit', $childPolicy['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'policies', 'action' => 'delete', $childPolicy['id']), null, __('Are you sure you want to delete # %s?', $childPolicy['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Policy'), array('controller' => 'policies', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
