<div class="carts form">
<?php echo $this->Form->create('CartItem'); ?>
	<fieldset>
		<legend><?php echo __('Edit Cart'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id', array(
			'type' => 'select',
			'options' => $users,
			'empty' => 'Pick a user'
		));
		echo $this->Form->input('session_id', array('type' => 'text'));
		echo $this->Form->input('design_name');
		echo $this->Form->input('data');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cart.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Cart.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Carts'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
