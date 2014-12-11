<?php /* @var $this ViewCC */ ?> 
<?php
//debug($duplicate);
//debug($disallowed);
//debug($new);
echo $this->Session->flash();
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
 		<legend><?php echo __("Add Image $file"); ?></legend>
	<?php
                echo $this->Session->flash($file);
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
<?php echo $this->Form->end(__('Submit'));
}?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Images'), array('action' => 'index'));?></li>
	</ul>
</div>
