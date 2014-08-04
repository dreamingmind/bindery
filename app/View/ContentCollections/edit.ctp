<div class="contentCollections form">
<?php echo $this->Form->create('ContentCollection');?>
	<fieldset>
 		<legend><?php echo __('Edit Content Collection'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('publish');
		echo $this->Form->input('sub_slug');
		echo $this->Form->input('content_id');
		echo $this->Form->input('collection_id');
		echo $this->Form->input('seq');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('ContentCollection.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('ContentCollection.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Collections'), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detail Collection'), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements'), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement'), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>