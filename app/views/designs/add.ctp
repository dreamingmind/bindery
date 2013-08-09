<div class="designs form">
<?php echo $this->Form->create('Design');?>
	<fieldset>
 		<legend><?php __('Add Design'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('design_name');
		echo $this->Form->input('data');
		echo $this->Form->input('supplement_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Designs', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements', true), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement', true), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>