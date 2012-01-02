<div class="images form">
<?php echo $this->Form->create('Image');?>
	<fieldset>
 		<legend><?php __('Edit Image'); ?></legend>
	<?php
		echo $this->Form->input('img_file');
		echo $this->Form->input('id');
		echo $this->Form->input('mimetype');
		echo $this->Form->input('filesize');
		echo $this->Form->input('width');
		echo $this->Form->input('height');
		echo $this->Form->input('title');
		echo $this->Form->input('category');
		echo $this->Form->input('alt');
		echo $this->Form->input('upload');
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Image.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Image.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>