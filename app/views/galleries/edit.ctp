<div class="galleries form">
<?php echo $this->Form->create('Gallery');?>
	<fieldset>
 		<legend><?php __('Edit Gallery'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('label');
		echo $this->Form->input('id');
		echo $this->Form->input('description');
		echo $this->Form->input('Dispatch');
		echo $this->Form->input('Exhibit');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Gallery.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Gallery.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Galleries', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Dispatches', true), array('controller' => 'dispatches', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dispatch', true), array('controller' => 'dispatches', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exhibits', true), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exhibit', true), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
	</ul>
</div>