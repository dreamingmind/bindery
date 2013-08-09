<div class="supplements form">
<?php echo $this->Form->create('Supplement');?>
	<fieldset>
 		<legend><?php __('Edit Supplement'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type');
		echo $this->Form->input('data');
		echo $this->Form->input('content_collection_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Supplement.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Supplement.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Supplements', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Content Collections', true), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection', true), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>