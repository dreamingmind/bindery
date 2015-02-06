<div class="policies form">
<?php echo $this->Form->create('Policy'); ?>
	<fieldset>
		<legend><?php echo __('Add Policy'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('policy');
		echo $this->Form->input('name_display', array('options' => $name_displays, 'empty' => 'Select a display mode'));
		echo $this->Form->input('policy_display', array('options' => $policy_displays, 'empty' => 'Select a display mode'));
		echo $this->Form->input('parent_id', array('empty' => 'Select a parent'));
		echo $this->Form->input('sequence');
		echo $this->Form->input('lft');
		echo $this->Form->input('rght');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Policies'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Policies'), array('controller' => 'policies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Policy'), array('controller' => 'policies', 'action' => 'add')); ?> </li>
	</ul>
</div>
