<div class="diagrams form">
<?php echo $this->Form->create('Diagram');?>
	<fieldset>
 		<legend><?php echo __('Add Diagram'); ?></legend>
	<?php
		echo $this->Form->input('x');
		echo $this->Form->input('y');
		echo $this->Form->input('part');
		echo $this->Form->input('product_group', array('type' => 'text'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Diagrams'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Catalogs'), array('controller' => 'catalogs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog'), array('controller' => 'catalogs', 'action' => 'add')); ?> </li>
	</ul>
</div>