<div class="catalogs form">
<?php echo $this->Form->create('Catalog');?>
	<fieldset>
 		<legend><?php echo __('Edit Catalog'); ?></legend>
	<?php
		echo $this->Form->input('size');
		echo $this->Form->input('id');
		echo $this->Form->input('product_group');
		echo $this->Form->input('price');
		echo $this->Form->input('category');
		echo $this->Form->input('product_code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Catalog.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Catalog.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Catalogs'), array('action' => 'index'));?></li>
	</ul>
</div>