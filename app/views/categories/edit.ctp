<div class="categories form">
<?php echo $this->Form->create('Category');?>
	<fieldset>
 		<legend><?php __('Edit Category'); ?></legend>
	<?php
//        debug($this->data);die;
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
//		echo $html->para('',$this->data['Category']['supplement_list']);
                if (str_word_count($this->data['Category']['supplement_list'])>1){
                    $defaults = unserialize($this->data['Category']['supplement_list']);
                    foreach($defaults as $key => $value){
                        $sl = $this->Form->input('supplement_list',array(
                            'name'=>'data[Category][supplement_key][]',
                            'class'=>'supplement_list',
                            'id'=>false,
                            'div'=>false,
                            'value'=>$key
                            ))
                        .'&nbsp;=>&nbsp;'.
                        $this->Form->input('supplement_list',array(
                            'name'=>'data[Category][supplement_value][]',
                            'class'=>'supplement_list',
                            'id'=>false,
                            'div'=>false,
                            'label'=>false,
                            'value'=>$value
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
                         ))
                                ;
                        echo $html->div('input text', $sl);

                    }
                } 
                
//                foreach($this->data){
//                    
//                }
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Category.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Category.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Categories', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Collections', true), array('controller' => 'collections', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Collection', true), array('controller' => 'collections', 'action' => 'add')); ?> </li>
	</ul>
</div>