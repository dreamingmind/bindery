<div class="optins form">
<?php echo $this->Form->create('Optin');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s'), __('Optin')); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('label');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('live');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Optin.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Optin.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Optins')), array('action' => 'index'));?></li>
	</ul>
</div>