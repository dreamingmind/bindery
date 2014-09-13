<div class="sessions form">
<?php echo $this->Form->create('Session');?>
	<fieldset>
 		<legend><?php echo __('Add Session'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('cost');
		echo $this->Form->input('participants');
		echo $this->Form->input('first_day');
		echo $this->Form->input('last_day');
		echo $this->Form->input('registered');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sessions'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Workshops'), array('controller' => 'workshops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop'), array('controller' => 'workshops', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Dates'), array('controller' => 'dates', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Date'), array('controller' => 'dates', 'action' => 'add')); ?> </li>
	</ul>
</div>