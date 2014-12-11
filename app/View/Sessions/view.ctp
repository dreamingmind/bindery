<div class="sessions view">
<h2><?php echo __('Session');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Cost'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['cost']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Participants'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['participants']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('First Day'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['first_day']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Last Day'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['last_day']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Registered'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['registered']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $session['Session']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Session'), array('action' => 'edit', $session['Session']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Session'), array('action' => 'delete', $session['Session']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $session['Session']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sessions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Workshops'), array('controller' => 'workshops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop'), array('controller' => 'workshops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dates'), array('controller' => 'dates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Date'), array('controller' => 'dates', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Dates');?></h3>
	<?php if (!empty($session['Date'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Session Id'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th><?php echo __('Start Time'); ?></th>
		<th><?php echo __('End Time'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($session['Date'] as $date):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $date['id'];?></td>
			<td><?php echo $date['session_id'];?></td>
			<td><?php echo $date['date'];?></td>
			<td><?php echo $date['start_time'];?></td>
			<td><?php echo $date['end_time'];?></td>
			<td><?php echo $date['modified'];?></td>
			<td><?php echo $date['created'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'dates', 'action' => 'view', $date['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'dates', 'action' => 'edit', $date['id'])); ?>
				<?php echo $this->Html->link(__('Delete'), array('controller' => 'dates', 'action' => 'delete', $date['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $date['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Date'), array('controller' => 'dates', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
