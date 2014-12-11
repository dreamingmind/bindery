<div class="navlines form">
<?php echo $this->Form->create('Navline');?>
	<fieldset>
 		<legend><?php echo __('Edit Navline'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('route');
		echo $this->Form->input('route_type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Navline.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Navline.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Navlines'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Navigators'), array('controller' => 'navigators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navigator'), array('controller' => 'navigators', 'action' => 'add')); ?> </li>
	</ul>
</div>