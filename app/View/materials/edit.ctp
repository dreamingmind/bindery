<div class="materials form">
<?php echo $this->Form->create('Material');?>
	<fieldset>
 		<legend><?php echo __('Edit Material'); ?></legend>
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

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Material.mat_id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Material.mat_id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Materials'), array('action' => 'index'));?></li>
	</ul>
</div>