<div class="navlines form">
<?php echo $this->Form->create('Navline');?>
	<fieldset>
 		<legend><?php __('Edit Navline'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('route');
		echo $this->Form->input('route_type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Navline.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Navline.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Navlines', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Navigators', true), array('controller' => 'navigators', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navigator', true), array('controller' => 'navigators', 'action' => 'add')); ?> </li>
	</ul>
</div>