<div class="editions form">
<?php echo $this->Form->create('Edition');?>
	<fieldset>
 		<legend><?php __('Add Edition'); ?></legend>
	<?php
		echo $this->Form->input('collection_id');
		echo $this->Form->input('size');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Editions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Copies', true), array('controller' => 'copies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Copy', true), array('controller' => 'copies', 'action' => 'add')); ?> </li>
	</ul>
</div>