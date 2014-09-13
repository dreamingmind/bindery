<div class="requests form">
<?php echo $this->Form->create('Request');?>
	<fieldset>
 		<legend><?php echo __('Edit Request'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('email');
		echo $this->Form->input('workshop_name');
		echo $this->Form->input('month');
		echo $this->Form->input('year');
		echo $this->Form->input('message');
		echo $this->Form->input('workshop_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Request.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Request.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Requests'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Workshops'), array('controller' => 'workshops', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Workshop'), array('controller' => 'workshops', 'action' => 'add')); ?> </li>
	</ul>
</div>