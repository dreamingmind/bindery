<div class="exhibits form">
<?php echo $this->Form->create('Exhibit',array('type' => 'file'));?>
	<fieldset>
 		<legend><?php printf(__('Add %s', true), __('Exhibit', true)); ?></legend>
	<?php
		echo $this->Form->input('img_file', array('type' => 'file'));
		echo $this->Form->input('heading');
		echo $this->Form->input('prose');
		echo $this->Form->input('prose_t');
		echo $this->Form->input('top_val');
		echo $this->Form->input('left_val');
		echo $this->Form->input('height_val');
		echo $this->Form->input('width_val');
		echo $this->Form->input('headstyle');
		echo $this->Form->input('pgraphstyle');
		echo $this->Form->input('alt');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Exhibits', true)), array('action' => 'index'));?></li>
	</ul>
</div>


