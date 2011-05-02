<div class="aros form">
<?php echo $this->Form->create('Aro');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Aro', true)); ?></legend>
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
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Aro.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Aro.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Aros', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Acos', true)), array('controller' => 'acos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Aco', true)), array('controller' => 'acos', 'action' => 'add')); ?> </li>
	</ul>
</div>