<?php /* @var $this ViewCC */ ?> 
<?php
//debug($duplicate);
//debug($disallowed);
//debug($new);
echo $session->flash();
?>
<div class="images form">
<?php 
if($new) {
    echo $this->Form->create('Image',array(
    'type' => 'file',
    'url'=>(array ('action'=>'new_uploads', count($new))))) ;

    $count = 0;
    
    foreach($new as $file => $object) { ?>
     
        
	<fieldset>
 		<legend><?php __("Add Image $file"); ?></legend>
	<?php
                echo $this->Html->image("images/upload/$file", array('style'=>'width:120px;'));
		echo $this->Form->hidden('Name',array(
                    'name'=>"data[$count][Image][img_file][name]",
                    'id' => "{$count}ImageImgFileName",
                    'value'=>$file));
		echo $this->Form->hidden('Type',array(
                    'name'=>"data[$count][Image][img_file][type]",
                    'id' => "{$count}ImageImgFileType",
                    'value'=>$object->exif['FILE']['MimeType']));
		echo $this->Form->hidden('TmpFile',array(
                    'name'=>"data[$count][Image][img_file][tmp_file]",
                    'id' => "{$count}ImageImgFileTmpFile",
                    'value'=>$object->path));
		echo $this->Form->hidden('Error',array(
                    'name'=>"data[$count][Image][img_file][error]",
                    'id' => "{$count}ImageImgFileTmpFile",
                    'value'=>0));
		echo $this->Form->hidden('Size',array(
                    'name'=>"data[$count][Image][img_file][size]",
                    'id' => "{$count}ImageImgFileSize",
                    'value'=>$object->exif['FILE']['FileSize']));
                    
		echo $this->Form->input('Alt',array(
                    'name'=>"data[$count][Image][alt]",
                    'id' => "{$count}ImageImgAlt",
                    'type'=>'textarea'));
		echo $this->Form->input('Date',array(
                    'name'=>"data[$count][Image][date]",
                    'id' => "{$count}ImageImgDate",
                    'value'=>strtotime($object->exif['EXIF']['DateTimeOriginal'])));
		echo $this->Form->input('Mimetype',array(
                    'name'=>"data[$count][Image][mimetype]",
                    'id' => "{$count}ImageImgMimetype",
                    'value'=>$object->exif['FILE']['MimeType']));
		echo $this->Form->input('Filesize',array(
                    'name'=>"data[$count][Image][filesize]",
                    'id' => "{$count}ImageImgFilesize",
                    'value'=>$object->exif['FILE']['FileSize']));
		echo $this->Form->input('Width',array(
                    'name'=>"data[$count][Image][width]",
                    'id' => "{$count}ImageImgWidth",
                    'value'=>$object->exif['COMPUTED']['Width']));
		echo $this->Form->input('Height',array(
                    'name'=>"data[$count][Image][height]",
                    'id' => "{$count}ImageImgHeight",
                    'value'=>$object->exif['COMPUTED']['Height']));
		echo $this->Form->input('Upload',array(
                    'name'=>"data[$count][Image][upload]",
                    'id' => "{$count}ImageImgUpload",
                    'value'=>$lastUpload+1));
                echo $this->Form->input('Category', array(
                    'name'=>"data[$count][Image][category]",
                    'id' => "{$count}ImageImgCategory",
                    'type'=>'radio', 'value'=>'dispatches', 'options'=> array(
                        'dispatches'=>'Dispatch', 'exhibits'=>'Exhibit' 
                    )
                ));
                echo $this->Form->input('Task', array(
                    'name'=>"data[$count][Image][task]",
                    'id' => "{$count}ImageImgTask",
                    'value'=>'upload',
                    'type'=>'radio', 'options'=> array(
                        'delete'=>'Delete', 'upload'=>'Upload'
                    )
                ));
//		echo $this->Form->hidden('Modified',array(
//                    'name'=>"data[$count][Image][modified]",
//                    'id' => "{$count}ImageImgModified",
//                    'value'=>time()));
//                    if (isset($this->params['pass'][1])) { 
		echo $this->Form->hidden('batch',array(
                    'name'=>"data[$count][Image][batch]",
                    'id' => "{$count}ImageImgBatch",
                    'value'=>1));                        
//                    }
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
