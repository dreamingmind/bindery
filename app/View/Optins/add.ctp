<div class="optins form">
<?php echo $this->Form->create('Optin');?>
	<fieldset>
 		<legend><?php printf(__('Add %s'), __('Optin')); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(sprintf(__('List %s'), __('Optins')), array('action' => 'index'));?></li>
	</ul>
</div>