<div class="products form">
<?php echo $this->Form->create('Product');?>
	<fieldset>
 		<legend><?php __('Add Product'); ?></legend>
	<?php
		echo $this->Form->input('size');
		echo $this->Form->input('product_code');
		echo $this->Form->input('product_group');
		echo $this->Form->input('price');
		echo $this->Form->input('category');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Products', true), array('action' => 'index'));?></li>
	</ul>
</div>