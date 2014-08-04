<div class="diagrams form">
<?php echo $this->Form->create('Diagram');?>
	<fieldset>
 		<legend><?php echo __('Edit Diagram'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('x');
		echo $this->Form->input('y');
		echo $this->Form->input('product_group');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Diagram.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Diagram.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Diagrams'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Catalogs'), array('controller' => 'catalogs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog'), array('controller' => 'catalogs', 'action' => 'add')); ?> </li>
	</ul>
</div>