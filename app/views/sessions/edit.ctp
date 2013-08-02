<div class="sessions form">
<?php echo $this->Form->create('Session');?>
	<fieldset>
 		<legend><?php __('Edit Session'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('cost');
		echo $this->Form->input('participants');
		echo $this->Form->input('first_day');
		echo $this->Form->input('last_day');
		echo $this->Form->input('registered');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Session.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Session.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Sessions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Workshops', true), array('controller' => 'workshops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop', true), array('controller' => 'workshops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dates', true), array('controller' => 'dates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Date', true), array('controller' => 'dates', 'action' => 'add')); ?> </li>
	</ul>
</div>