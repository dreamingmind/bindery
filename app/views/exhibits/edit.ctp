<div class="exhibits form">
    <?php echo $this->Form->create('Exhibit',array('type' => 'file'));?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Exhibit', true)); ?></legend>
	<?php
                echo $html->para(null, $this->data['Exhibit']['img_file'])."\n";
		echo $this->Form->input('img_file',array('type' => 'file'))."\n";
		echo $this->Form->input('heading')."\n";
		echo $this->Form->input('prose_t')."\n";
		echo $this->Form->input('id')."\n";
		echo $this->Form->input('top_val')."\n";
		echo $this->Form->input('left_val')."\n";
		echo $this->Form->input('height_val')."\n";
		echo $this->Form->input('width_val')."\n";
		echo $this->Form->input('headstyle')."\n";
		echo $this->Form->input('pgraphstyle')."\n";
		echo $this->Form->input('alt')."\n";
                echo $this->Form->input('filesize')."\n";
                echo $this->Form->input('height')."\n";
                echo $this->Form->input('width')."\n";
	?>
	</fieldset>
    <?php echo $this->Form->button('Save & Previous',array('value'=>$neighbors['prev']['Exhibit']['id'], 'name'=>'data[button]')); ?>
    <?php echo $this->Form->button('Save & Stay',array('value'=>$this->data['Exhibit']['id'], 'name'=>'data[button]')); ?>
    <?php echo $this->Form->button('Save & Next',array('value'=>$neighbors['next']['Exhibit']['id'], 'name'=>'data[button]')); ?>
<?php echo $this->Form->end(__('Save & List', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Exhibit.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Exhibit.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Exhibits', true)), array('action' => 'index'));?></li>
                <li><?php echo $this->Html->image('exhibits'.DS.'thumb'.DS.'x75y56'.DS.$this->data['Exhibit']['img_file']) ?></li>
	</ul>
</div>
<?php echo $this->Html->image('exhibits'.DS.'thumb'.DS.'x320y240'.DS.$this->data['Exhibit']['img_file']) ?>
