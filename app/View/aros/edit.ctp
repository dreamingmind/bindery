<div class="aros form">
<?php echo $this->Form->create('Aro');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s'), __('Aro')); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('parent_id');
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('alias');
		echo $this->Form->input('lft');
		echo $this->Form->input('rght');
		echo $this->Form->input('Aco');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Aro.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Aro.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Aros')), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Acos')), array('controller' => 'acos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s'), __('Aco')), array('controller' => 'acos', 'action' => 'add')); ?> </li>
	</ul>
</div>