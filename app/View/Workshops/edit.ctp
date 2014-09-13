<div class="workshops form">
<?php echo $this->Form->create('Workshop');?>
	<fieldset>
 		<legend><?php echo __('Edit Workshop'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('hours');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Workshop.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Workshop.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Workshops'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Sessions'), array('controller' => 'sessions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Session'), array('controller' => 'sessions', 'action' => 'add')); ?> </li>
	</ul>
</div>