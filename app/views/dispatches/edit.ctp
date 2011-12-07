<div class="dispatches form">
<?php echo $this->Form->create('Dispatch');?>
<?php 
    echo $html->neighborRecords($this->model, $neighbors);
?>
    <fieldset>
 		<legend><?php __('Edit Dispatch'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('text');
		//echo $this->Form->input('gallery');
		echo $this->Form->input('publish');
		echo $this->Form->input('alt');
		echo $this->Form->input('title');
		echo $this->Form->input('image_id');
		echo $this->Form->input('Gallery');
	?>
	</fieldset>
<?php 
    echo $html->neighborRecords($this->model, $neighbors);
    echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Dispatch.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Dispatch.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Dispatches', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Images', true), array('controller' => 'images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Image', true), array('controller' => 'images', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Galleries', true), array('controller' => 'galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gallery', true), array('controller' => 'galleries', 'action' => 'add')); ?> </li>
	</ul>
</div>