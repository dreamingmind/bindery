<div class="diagrams form">
<?php echo $this->Form->create('Diagram');?>
	<fieldset>
 		<legend><?php __('Edit Diagram'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('x');
		echo $this->Form->input('y');
		echo $this->Form->input('product_group');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Diagram.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Diagram.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Diagrams', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Catalogs', true), array('controller' => 'catalogs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Catalog', true), array('controller' => 'catalogs', 'action' => 'add')); ?> </li>
	</ul>
</div>