<div class="navigators form">
<?php echo $form->create('Navigator');?>
	<fieldset>
 		<legend><?php __('Edit Navigator');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('parent_id');
		echo $form->input('lft');
		echo $form->input('rght');
		echo $form->input('navline_id');
		echo $form->input('account');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Navigator.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Navigator.id'))); ?></li>
		<li><?php echo $html->link(__('List Navigators', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Navlines', true), array('controller' => 'navlines', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Navline', true), array('controller' => 'navlines', 'action' => 'add')); ?> </li>
	</ul>
</div>
