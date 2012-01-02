<?php
/* @var $this ViewCC */ 
////These are the anticipated values
//$count = $replace;    //optional
////Pass in $record with these array elements or $object
//$record['Image'] = array( 
//    'date'=>$replace,
//    'mimetype'=>$replace,
//    'filesize'=>$replace,
//    'width'=>$replace,
//    'height'=>$replace,
//);
////Pass in $object with these properties or $record
//$object->exif['EXIF'] = array(
//    'DateTimeOriginal'=>$replace
//);
//$object->exif['FILE'] = array(
//    'MimeType'=>$replace,
//    'FileSize'=>$replace
//);
//$object->exif['COMPUTED'] = array(
//    'Width'=>$replace,
//    'Height'=>$replace
//);
/**
 * This will output a fieldset with inputs for all the Image fields
 * 
 * Providing $count will index the fields so multiple records can be processed
 * Many values store exif data and might be set from two sources. 
 * If $record (array) is set, this will be used to set the field values
 * If $object (object) is set, this will provide the data instead of $record.
 * If neither is set, values will be empty
 * 
 * I'm not 100% sure about the universality of $object indexing. Cross your fingers
 */
$count = (isset($count)) ? $count : null; //multiple records?
$index = ($count != null) ? "[$count]" : false; //data array index
$label = ($count != null) ? "Record $count:" : ''; //legend
?> 
	<fieldset id="<?php echo "exifFields$count"; ?>" class="exifFields">
 		<legend><?php __("$label Image exif fields"); ?></legend>
	<?php                   
		echo $this->Form->input('Date',array(
                    'name'=>"data{$index}[Image][date]",
                    'id' => "{$count}ImageDate",
                    'class' => "ImageDate",
                    'value'=>
                        (isset($object) && is_object($object)) 
                            ? strtotime($object->exif['EXIF']['DateTimeOriginal'])
                            : ((isset($record['Image']['date']))
                                ? $record['Image']['date']
                                : '')
                    ));
                    
		echo $this->Form->input('Mimetype',array(
                    'name'=>"data{$index}[Image][mimetype]",
                    'id' => "{$count}ImageMimetype",
                    'class' => "ImageMimetype",
                    'value'=>
                        (isset($object) && is_object($object)) 
                            ? $object->exif['FILE']['MimeType']
                            : ((isset($record['Image']['mimetype']))
                                ? $record['Image']['mimetype']
                                : '')
                    ));
                    
		echo $this->Form->input('Filesize',array(
                    'name'=>"data{$index}[Image][filesize]",
                    'id' => "{$count}ImageFilesize",
                    'class' => "ImageFilesize",
                    'value'=>
                        (isset($object) && is_object($object)) 
                            ? $object->exif['FILE']['FileSize']
                            : ((isset($record['Image']['filesize']))
                                ? $record['Image']['filesize']
                                : '')
                    ));
                    
		echo $this->Form->input('Width',array(
                    'name'=>"data{$index}[Image][width]",
                    'id' => "{$count}ImageWidth",
                    'class' => "ImageWidth",
                    'value'=>
                        (isset($object) && is_object($object)) 
                            ? $object->exif['COMPUTED']['Width']
                            : ((isset($record['Image']['width']))
                                ? $record['Image']['width']
                                : '')
                    ));
                    
		echo $this->Form->input('Height',array(
                    'name'=>"data{$index}[Image][height]",
                    'id' => "{$count}ImageHeight",
                    'class' => "ImageHeight",
                    'value'=>
                        (isset($object) && is_object($object)) 
                            ? $object->exif['COMPUTED']['Height']
                            : ((isset($record['Image']['height']))
                                ? $record['Image']['height']
                                : '')
                    ));
	?>
	</fieldset>
