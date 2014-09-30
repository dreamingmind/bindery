<div class="carts form">
<?php echo $this->Form->create('Cart'); ?>
	<fieldset>
		<legend><?php echo __('Add Cart'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('phpsession_id', array('type' => 'text'));
		echo $this->Form->input('design_name');
		echo $this->Form->input('data');
		echo $this->Form->input('supplement_id', array('empty' => 'select'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Carts'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements'), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement'), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>
