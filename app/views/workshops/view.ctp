<div class="workshops view">
<h2><?php  __('Workshop');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hours'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['hours']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Workshop', true), array('action' => 'edit', $workshop['Workshop']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Workshop', true), array('action' => 'delete', $workshop['Workshop']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $workshop['Workshop']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Workshops', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sessions', true), array('controller' => 'sessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session', true), array('controller' => 'sessions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Sessions');?></h3>
	<?php if (!empty($workshop['Session'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Workshop Id'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Cost'); ?></th>
		<th><?php __('Participants'); ?></th>
		<th><?php __('First Day'); ?></th>
		<th><?php __('Last Day'); ?></th>
		<th><?php __('Registered'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Created'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($workshop['Session'] as $session):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $session['id'];?></td>
			<td><?php echo $session['workshop_id'];?></td>
			<td><?php echo $session['title'];?></td>
			<td><?php echo $session['cost'];?></td>
			<td><?php echo $session['participants'];?></td>
			<td><?php echo $session['first_day'];?></td>
			<td><?php echo $session['last_day'];?></td>
			<td><?php echo $session['registered'];?></td>
			<td><?php echo $session['modified'];?></td>
			<td><?php echo $session['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'sessions', 'action' => 'view', $session['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'sessions', 'action' => 'edit', $session['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'sessions', 'action' => 'delete', $session['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $session['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Session', true), array('controller' => 'sessions', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
