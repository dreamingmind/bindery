<div class="supplements form">
<?php echo $this->Form->create('Supplement');?>
	<fieldset>
 		<legend><?php echo __('Edit Supplement'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type');
		echo $this->Form->input('data');
		echo $this->Form->input('content_collection_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Supplement.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Supplement.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Supplements'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>