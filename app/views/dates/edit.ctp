<div class="dates form">
<?php echo $this->Form->create('Date');?>
	<fieldset>
 		<legend><?php __('Edit Date'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('session_id');
		echo $this->Form->input('date');
		echo $this->Form->input('start_time');
		echo $this->Form->input('end_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Date.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Date.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dates', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sessions', true), array('controller' => 'sessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session', true), array('controller' => 'sessions', 'action' => 'add')); ?> </li>
	</ul>
</div>