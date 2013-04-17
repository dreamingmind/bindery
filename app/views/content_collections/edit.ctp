<div class="contentCollections form">
<?php echo $this->Form->create('ContentCollection');?>
	<fieldset>
 		<legend><?php __('Edit Content Collection'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('publish');
		echo $this->Form->input('sub_slug');
		echo $this->Form->input('content_id');
		echo $this->Form->input('collection_id');
		echo $this->Form->input('seq');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ContentCollection.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ContentCollection.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Content Collections', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Detail Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Supplements', true), array('controller' => 'supplements', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Supplement', true), array('controller' => 'supplements', 'action' => 'add')); ?> </li>
	</ul>
</div>