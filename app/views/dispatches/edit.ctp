<div class="dispatches form">
<?php echo $this->Form->create('Dispatch');?>
<?php 
if(isset($neighbors['prev']['Dispatch']['id'])) { 
    echo $this->Html->link(__('Previous',true), array('conroller'=>'dispatches','action'=>'edit',$neighbors['prev']['Dispatch']['id'])); 
}
if (isset($neighbors['prev']['Dispatch']['id']) && isset($neighbors['next']['Dispatch']['id'])) {
    echo '&nbsp;|&nbsp;';
}
if(isset($neighbors['next']['Dispatch']['id'])) {
    echo $this->Html->link(__('Next',true), array('controller'=>'dispatches','action'=>'edit',$neighbors['next']['Dispatch']['id']));
}
?>
    <fieldset>
 		<legend><?php __('Edit Dispatch'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('img_file');
		echo $this->Form->input('news_text');
		echo $this->Form->input('gallery');
		echo $this->Form->input('publish');
		echo $this->Form->input('alt');
		echo $this->Form->input('date');
		echo $this->Form->input('image_id');
		echo $this->Form->input('Gallery');
	?>
	</fieldset>
<?php 
if(isset($neighbors['prev']['Dispatch']['id'])) { 
    echo $this->Html->link(__('Previous',true), array('conroller'=>'dispatches','action'=>'edit',$neighbors['prev']['Dispatch']['id'])); 
}
if (isset($neighbors['prev']['Dispatch']['id']) && isset($neighbors['next']['Dispatch']['id'])) {
    echo '&nbsp;|&nbsp;';
}
if(isset($neighbors['next']['Dispatch']['id'])) {
    echo $this->Html->link(__('Next',true), array('controller'=>'dispatches','action'=>'edit',$neighbors['next']['Dispatch']['id']));
}
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