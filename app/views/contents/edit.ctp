<div class="contents form">
<?php echo $this->Form->create('Content');?>
	<fieldset>
 		<legend><?php __('Edit Content'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('navline_id');
		echo $this->Form->input('content');
		echo $this->Form->input('image_id');
		echo $this->Form->input('alt');
		echo $this->Form->input('title');
		echo $this->Form->input('heading');
		echo $this->Form->input('publish');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Content.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Content.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Navlines', true), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline', true), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images', true), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibit Supliments', true), array('controller' => 'exhibit_supliments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit Supliment', true), array('controller' => 'exhibit_supliments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections', true), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection', true), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>