<div class="dates form">
<?php echo $this->Form->create('Date');?>
	<fieldset>
 		<legend><?php echo __('Edit Date'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('session_id');
		echo $this->Form->input('date');
		echo $this->Form->input('start_time');
		echo $this->Form->input('end_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Date.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Date.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dates'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sessions'), array('controller' => 'sessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session'), array('controller' => 'sessions', 'action' => 'add')); ?> </li>
	</ul>
</div>