<div class="navigators form">
<?php echo $this->Form->create('Navigator');?>
	<fieldset>
 		<legend><?php echo __('Add Navigator');?></legend>
	<?php
		echo $this->Form->input('parent_id');
		echo $this->Form->input('lft');
		echo $this->Form->input('rght');
		echo $this->Form->input('navline_id');
		echo $this->Form->input('account');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Navigators'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Navlines'), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline'), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>
