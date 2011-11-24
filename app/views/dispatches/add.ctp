<div class="dispatches form">
<?php echo $this->Form->create('Dispatch');?>
	<fieldset>
 		<legend><?php __('Add Dispatch'); ?></legend>
	<?php
		echo $this->Form->input('img_file');
		echo $this->Form->input('news_text');
		echo $this->Form->input('gallery');
		echo $this->Form->input('publish');
		echo $this->Form->input('alt');
		echo $this->Form->input('date');
		echo $this->Form->input('Image');
		echo $this->Form->input('Gallery');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dispatches', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Images', true), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Galleries', true), array('controller' => 'galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gallery', true), array('controller' => 'galleries', 'action' => 'add')); ?> </li>
	</ul>
</div>