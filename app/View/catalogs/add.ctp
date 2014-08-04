<div class="catalogs form">
<?php echo $this->Form->create('Catalog');?>
	<fieldset>
 		<legend><?php echo __('Add Catalog'); ?></legend>
	<?php
		echo $this->Form->input('size');
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

		<li><?php echo $this->Html->link(__('List Catalogs'), array('action' => 'index'));?></li>
	</ul>
</div>