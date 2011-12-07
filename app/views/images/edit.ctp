<div class="images form">
<?php echo $this->Form->create('Image');?>
	<fieldset>
 		<legend><?php __('Edit Image'); ?></legend>
	<?php
            echo date('r', intval($this->data['Image']['date']));
            echo $this->data['Image']['date'];
            echo $this->Form->input('img_file');
            echo $this->Form->input('id');
            echo $this->Form->input('alt');
            echo $this->Form->input('title');
            echo $this->Form->input('category');
            echo $this->Form->input('date');
            echo $this->Form->input('mimetype');
            echo $this->Form->input('filesize');
            echo $this->Form->input('width');
            echo $this->Form->input('height');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Image.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Image.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dispatches', true), array('controller' => 'dispatches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dispatch', true), array('controller' => 'dispatches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibits', true), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
	</ul>
</div>