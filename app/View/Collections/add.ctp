<div class="collections form">
<?php echo $this->Form->create('Collection');?>
	<fieldset>
 		<legend><?php echo __('Add Collection'); ?></legend>
	<?php
		echo $this->Form->input('heading');
		echo $this->Form->input('publish');
		echo $this->Form->input('text');
		echo $this->Form->input('role');
		echo $this->Form->input('category_id');
		echo $this->Form->input('slug');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Collections'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Content Collections'), array('controller' => 'content_collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content Collection'), array('controller' => 'content_collections', 'action' => 'add')); ?> </li>
	</ul>
</div>