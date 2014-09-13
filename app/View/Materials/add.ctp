<div class="materials form">
<?php echo $this->Form->create('Material');?>
	<fieldset>
 		<legend><?php echo __('Add Material'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('category');
		echo $this->Form->input('file_name');
		echo $this->Form->input('title');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Materials'), array('action' => 'index'));?></li>
	</ul>
</div>