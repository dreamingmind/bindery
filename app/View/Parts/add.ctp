<div class="parts form">
<?php echo $this->Form->create('Part'); ?>
	<fieldset>
		<legend><?php echo __('Add Part'); ?></legend>
	<?php
		echo $this->Form->input('code');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('price');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Parts'), array('action' => 'index')); ?></li>
	</ul>
</div>
