<div class="contents form">
<?php echo $this->Form->create('Content');?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Content', true)); ?></legend>
	<?php
        //debug($navlines);
                echo $this->Form->input('navline_id',array('options'=>$navline));
		echo $this->Form->input('content');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Contents', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Navlines', true)), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Navline', true)), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>