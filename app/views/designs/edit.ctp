<div class="designs form">
<?php echo $this->Form->create('Design');?>
	<fieldset>
 		<legend><?php __('Edit Design'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('design_name');
		echo $this->Form->input('data');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Design.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Design.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Designs', true), array('action' => 'index'));?></li>
	</ul>
</div>