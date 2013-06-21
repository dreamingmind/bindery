<div class="copies form">
<?php echo $this->Form->create('Copy');?>
	<fieldset>
 		<legend><?php __('Add Copy'); ?></legend>
	<?php
		echo $this->Form->input('edition_id');
		echo $this->Form->input('number');
		echo $this->Form->input('status');
		echo $this->Form->input('location');
		echo $this->Form->input('notes');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Copies', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Editions', true), array('controller' => 'editions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Edition', true), array('controller' => 'editions', 'action' => 'add')); ?> </li>
	</ul>
</div>