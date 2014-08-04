<div class="contents form">
<?php echo $this->Form->create('Content');?>
	<fieldset>
 		<legend><?php echo __('Add Content'); ?></legend>
	<?php
		echo $this->Form->input('navline_id');
		echo $this->Form->input('content');
		echo $this->Form->input('image_id');
		echo $this->Form->input('alt');
		echo $this->Form->input('title');
		echo $this->Form->input('heading');
		echo $this->Form->input('publish');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Contents'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Navlines'), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Navline'), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Images'), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image'), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibit Supliments'), array('controller' => 'exhibit_supliments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit Supliment'), array('controller' => 'exhibit_supliments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>