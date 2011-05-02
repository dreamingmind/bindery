<div class="exhibitGalleries form">
<?php echo $this->Form->create('ExhibitGallery');?>
	<fieldset>
 		<legend><?php printf(__('Edit %s', true), __('Exhibit Gallery', true)); ?></legend>
	<?php
		echo $this->Form->input('parent_id', array('type'=>'text'));
		echo $this->Form->input('lft');
		echo $this->Form->input('rght');
		echo $this->Form->input('exhibit_id');
		echo $this->Form->input('seq');
		echo $this->Form->input('id');
		echo $this->Form->input('gallery_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('ExhibitGallery.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('ExhibitGallery.id'))); ?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Exhibit Galleries', true)), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Exhibits', true)), array('controller' => 'exhibits', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Exhibit', true)), array('controller' => 'exhibits', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('List %s', true), __('Galleries', true)), array('controller' => 'galleries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(sprintf(__('New %s', true), __('Gallery', true)), array('controller' => 'galleries', 'action' => 'add')); ?> </li>
	</ul>
</div>