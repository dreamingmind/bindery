<div class="exhibitSupliments form">
<?php echo $this->Form->create('ExhibitSupliment');?>
	<fieldset>
 		<legend><?php __('Add Exhibit Supliment'); ?></legend>
	<?php
		echo $this->Form->input('img_file');
		echo $this->Form->input('heading');
		echo $this->Form->input('prose');
		echo $this->Form->input('prose_t');
		echo $this->Form->input('top_val');
		echo $this->Form->input('left_val');
		echo $this->Form->input('height_val');
		echo $this->Form->input('width_val');
		echo $this->Form->input('headstyle');
		echo $this->Form->input('pgraphstyle');
		echo $this->Form->input('alt');
		echo $this->Form->input('image_id');
		echo $this->Form->input('mimetype');
		echo $this->Form->input('filesize');
		echo $this->Form->input('width');
		echo $this->Form->input('height');
		echo $this->Form->input('exhibit_id');
		echo $this->Form->input('content_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Exhibit Supliments', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Images', true), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibits', true), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents', true), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content', true), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>