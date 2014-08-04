<div class="navigators form">
<?php echo $this->Form->create('Navigator');?>
	<fieldset>
 		<legend><?php echo __('Edit Navigator');?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('lft');
		echo $this->Form->input('rght');
		echo $this->Form->input('navline_id');
		echo $this->Form->input('account');
		echo $this->Form->input('publish');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Navigator.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Navigator.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Navigators'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Navlines'), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline'), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>
