<?php
/* @var $this ViewCC */ 
////These are the anticipated values
//$count = $replace;    //optional
////Pass in $record with these array elements or $object
//$record['Image'] = array( 
//    'id'=>$replace,
//    'upload'=>$replace
//    'modified'=>$replace
//    'created'=>$replace
//);
/**
 * This will output a fieldset with inputs for the Image metadata fields
 * 
 * Providing $count will index the fields so multiple records can be processed
 * If $record (array) is set, this will be used to set the field values
 * Many values store exif data. If $object (object) is set, 
 * this will provide the data instead of $record.
 * If neither is set, values will be empty
 * 
 * I'm not 100% sure about the universality of $object indexing. Cross your fingers
 */
$count = (isset($count)) ? $count : null; //multiple records?
$index = ($count != null) ? "[$count]" : false; //data array index
$label = ($count != null) ? "Record $count:" : ''; //legend
?> 
	<fieldset id="<?php echo "metaFields$count"; ?>" class="metaFields">
 		<legend><?php __("$label Image meta fields"); ?></legend>
	<?php
		echo $this->Form->input('Id',array(
                    'name'=>"data{$index}[Image][id]",
                    'id' => "{$count}ImagegId",
                    'class' => "ImagegId",
                    'type'=>'textarea',
                    'value'=>(isset($record['Image']['id'])) ? $record['Image']['id'] : null));
                     
		echo $this->Form->input('Upload',array(
                    'name'=>"data{$index}[Image][upload]",
                    'id' => "{$count}ImageUpload",
                    'class' => "ImageUpload",
                    'value'=>(isset($record['Image']['upload'])) ? $record['Image']['upload'] : $lastUpload+1));
                    
		echo $this->Form->input('Modified',array(
                    'name'=>"data{$index}[Image][modified]",
                    'id' => "{$count}ImageModified",
                    'class' => "ImageModified",
                    'type'=>'textarea',
                    'value'=>(isset($record['Image']['modified'])) ? $record['Image']['modified'] : null));
                     
		echo $this->Form->input('Created',array(
                    'name'=>"data{$index}[Image][created]",
                    'id' => "{$count}ImageCreated",
                    'class' => "ImageCreated",
                    'value'=>(isset($record['Image']['created'])) ? $record['Image']['created'] : null));
                    
	?>
	</fieldset>