<div class="categories form">
<?php echo $this->Form->create('Category');?>
	<fieldset>
 		<legend><?php echo __('Edit Category'); ?></legend>
	<?php
//        debug($this->request->data);die;
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
//		echo $this->Html->para('',$this->request->data['Category']['supplement_list']);
                echo $this->element('supplement_default_fields', array(
                    'form',$this->Form,
                    'supplement_defaults'=>$this->request->data['Category']['supplement_list']
                    ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $this->Form->value('Category.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('Category.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Categories'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Collections'), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection'), array('controller' => 'collections', 'action' => 'add')); ?> </li>
	</ul>
</div>