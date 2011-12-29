<?php /* @var $this ViewCC */ ?> 
<?php
//debug($duplicate);
//debug($disallowed);
//debug($new);
echo $session->flash();
?>
<div class="images form">
<?php 
if($duplicate) {
    echo $this->Form->create('Image',array(
    'type' => 'file',
    'url'=>(array ('action'=>'duplicate_uploads', count($duplicate))))) ;

    $count = 0;
    
    foreach($duplicate as $file => $object) { ?>
     
        
	<fieldset>
 		<legend><?php __("Add Image $file"); ?></legend>
	<?php
                echo $session->flash($file);
                echo $this->Html->image("images/upload/$file", array('title'=>'New Image to Upload','style'=>'width:160px;'));
                echo $this->Html->image("images/thumb/x160y120/$file", array('title'=>'Existing Image'));
		echo $this->Form->input('Name',array(
                    'name'=>"data[$count][Image][img_file]",
                    'id' => "{$count}ImageImgFile",
                    'value'=>$file));
                echo $this->Form->hidden('oldName',array(
                    'name'=>"data[$count][Image][oldName]",
                    'value'=>$file));
                echo $this->Form->input('Task', array(
                    'name'=>"data[$count][Image][task]",
                    'id' => "{$count}ImageImgTask",
                    'value'=>'delete',
                    'type'=>'radio', 'options'=> array(
                        'delete'=>'Delete', 'rename'=>'Rename'
                    )
                ));
	?>
	</fieldset>
 
   <?php $count++; }  ?>
<?php echo $this->Form->end(__('Submit', true));
}?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images', true), array('action' => 'index'));?></li>
	</ul>
</div>
