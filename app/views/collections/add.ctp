<div class="collections form">
<?php echo $this->Form->create('Collection');?>
	<fieldset>
 		<legend><?php __('Add Collection'); ?></legend>
	<?php
		echo $this->Form->input('heading');
		echo $this->Form->input('publish');
		echo $this->Form->input('text');
		echo $this->Form->input('role');
		echo $this->Form->input('category');
		echo $this->Form->input('id_dispatch');
		echo $this->Form->input('id_exhibit');
		echo $this->Form->input('Content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Collections', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>