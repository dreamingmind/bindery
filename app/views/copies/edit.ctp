<div class="copies form">
<?php echo $this->Form->create('Copy');?>
	<fieldset>
 		<legend><?php __('Edit Copy'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Copy.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Copy.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Copies', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Editions', true), array('controller' => 'editions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Edition', true), array('controller' => 'editions', 'action' => 'add')); ?> </li>
	</ul>
</div>