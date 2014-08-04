<div class="workshops view">
<h2><?php echo __('Workshop');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Hours'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['hours']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $workshop['Workshop']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Workshop'), array('action' => 'edit', $workshop['Workshop']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Workshop'), array('action' => 'delete', $workshop['Workshop']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $workshop['Workshop']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Workshops'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sessions'), array('controller' => 'sessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session'), array('controller' => 'sessions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Sessions');?></h3>
	<?php if (!empty($workshop['Session'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Workshop Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Cost'); ?></th>
		<th><?php echo __('Participants'); ?></th>
		<th><?php echo __('First Day'); ?></th>
		<th><?php echo __('Last Day'); ?></th>
		<th><?php echo __('Registered'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View'), array('controller' => 'sessions', 'action' => 'view', $session['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sessions', 'action' => 'edit', $session['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'sessions', 'action' => 'delete', $session['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $session['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Session'), array('controller' => 'sessions', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
