<?php
/* @var $this ViewCC */ 
////These are the anticipated values
//$count = $replace;    //optional
////Pass in $record with these array elements or $object
//$record['Content'] = array( 
//    'id'=>$replace,
//    'upload'=>$replace
//    'modified'=>$replace
//    'created'=>$replace
//);
/**
 * This will output a fieldset with inputs for the Content metadata fields
 * 
 * Providing $count will index the fields so multiple records can be processed
 * If $record (array) is set, this will be used to set the field values
 */
$count = (isset($count)) ? $count : null; //multiple records?
$index = ($count != null) ? "[$count]" : false; //data array index
$label = ($count != null) ? "Record $count:" : ''; //legend
?> 
	<fieldset id="<?php echo "metaFields$count"; ?>" class="metaFields">
 		<legend><?php __("$label Content meta fields"); ?></legend>
	<?php
		echo $this->Form->input('Id',array(
                    'name'=>"data{$index}[Content][id]",
                    'id' => "{$count}ContentgId",
                    'class' => "ContentgId",
                    'type'=>'textarea',
                    'value'=>(isset($record['Content']['id'])) ? $record['Content']['id'] : null));
                     
		echo $this->Form->input('ImageId',array(
                    'name'=>"data{$index}[Content][image_id]",
                    'id' => "{$count}ContentImageId",
                    'class' => "ContentImageId",
                    'value'=>(isset($record['Content']['image_id'])) ? $record['Content']['image_id'] : $lastUpload+1));
                    
		echo $this->Form->input('Modified',array(
                    'name'=>"data{$index}[Content][modified]",
                    'id' => "{$count}ContentModified",
                    'class' => "ContentModified",
                    'type'=>'textarea',
                    'value'=>(isset($record['Content']['modified'])) ? $record['Content']['modified'] : null));
                     
		echo $this->Form->input('Created',array(
                    'name'=>"data{$index}[Content][created]",
                    'id' => "{$count}ContentCreated",
                    'class' => "ContentCreated",
                    'value'=>(isset($record['Content']['created'])) ? $record['Content']['created'] : null));
                    
	?>
	</fieldset>