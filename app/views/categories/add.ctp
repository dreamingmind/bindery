<div class="categories form">
<?php echo $this->Form->create('Category');?>
	<fieldset>
 		<legend><?php __('Add Category'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
                
                //this assembles content for 1 div
                //KEY input, =>, VALUE input, + button, - button
                //it should be an element since edit.ctp uses it too
		$sl = $this->Form->input('supplement_list',array(
                    'name'=>'data[Category][supplement_key][]',
                    'class'=>'supplement_list',
                    'id'=>false,
                    'div'=>false
                    ))
                .'&nbsp;=>&nbsp;'.
		$this->Form->input('supplement_list',array(
                    'name'=>'data[Category][supplement_value][]',
                    'class'=>'supplement_list',
                    'id'=>false,
                    'div'=>false,
                    'label'=>false
                    ))
                 .$this->Form->button('+',array(
                     'class'=>'supplement_list clone',
                     'type'=>'button',
                     'title'=>'Clone this'

                 ))
                 .$this->Form->button('-',array(
                     'class'=>'supplement_list remove',
                     'type'=>'button',
                     'title'=>'Remove this'
                ));
                
                //this actually outputs the assembly
                //this div is the clonable or deletable unit
                //that javascript works on when the +/- buttons are clicked
                echo $html->div('input text', $sl);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Categories', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
	</ul>
</div>