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
//    debug($new);die;
    foreach($new as $fileIndex => $object) { ?>
     
        
	<fieldset>
 		<legend><?php __("Add Image $fileIndex"); ?></legend>
	<?php
$file = array(     //required
    'name'=> $fileIndex,
    'type'=> $object->exif['FILE']['MimeType'],
    'tmp_file'=> $object->path,
    'size'=> $object->exif['FILE']['FileSize']
    );
                echo $this->Html->image("images/upload/$fileIndex", array('style'=>'width:120px;'));
                    
                echo $this->element('imageForm_fileFields',array(
                    'count'=>$count,
                    'file'=>$file
                ));
                echo $this->element('imageForm_metaFields',array(
                    'prefix'=>array($count),
                    'record'=>array(
                        'Image'=>array(
                            'upload'=>$lastUpload+1,
                            'created'=>  date('Y-m-d H:i:s',time())
                        )
                    )
                ));
                echo $this->element('imageForm_dataFields',array(
                    'prefix'=>array($count),
                    'record'=>array(
                        'Image'=>array(
                            'recent_titles'=>array('options'=>$recentTitles)
                        )
                    )
                ));
                echo $this->element('imageForm_exifFields',array(
                    'prefix'=>array($count),
                    'record'=>$object
                ));

                echo $this->Form->input('Task', array(
                    'name'=>"data[$count][Image][task]",
                    'id' => "{$count}ImageImgTask",
                    'value'=>'hold',
                    'type'=>'radio', 'options'=> array(
                        'delete'=>'Delete', 'upload'=>'Upload', 'hold'=>'Hold'
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