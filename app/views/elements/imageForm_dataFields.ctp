<?php
/* @var $this ViewCC */ 
////These are the anticipated values
//$count = $replace;    //optional
////Pass in $record with these array elements or $object
//$record['Image'] = array( 
//    'img_file'=>$replace,
//    'alt'=>$replace,
//    'title'=>$replace,
//    'category'=>$replace
//);
/**
 * This will output a fieldset with inputs for the Image user selectible data fields
 * 
 * Providing $count will index the fields so multiple records can be processed
 * If $record (array) is set, this will be used to set the field values
 * $doFile controls the ImgFile field in three states:
 *  unset outputs a regular input like the other fields
 *  True outputs a type=file for image uploading
 *  False suppresses output of this field
 * 
 */
$count = (isset($count)) ? $count : null; //multiple records?
$index = ($count != null) ? "[$count]" : false; //data array index
$label = ($count != null) ? "Record $count:" : ''; //legend
//Allow uploads, show existing linked file or supress this field
if(!isset($doFile)) {
    $fileEntry = array('value'=>(isset($record['Image']['img_file'])) ? $record['Image']['img_file'] : null);
} elseif ($doFile) {
    $fileEntry = array('type'=>'file');
} else {
    $fileEntry = false;
}

?> 
	<fieldset id="<?php echo "dataFields$count"; ?>" class="dataFields">
 		<legend><?php __("$label Image data fields"); ?></legend>
	<?php
        if(is_array($fileEntry)){
            echo $this->Form->input('ImgFile',array(
                'name'=>"data{$index}[Image][img_file]",
                'id' => "{$count}ImageImgFile",
                'class' => "ImageImgFile")
                + $fileEntry);
        }
                    
        echo $this->Form->input('Alt',array(
            'name'=>"data{$index}[Image][alt]",
            'id' => "{$count}ImageAlt",
            'class' => "ImageAlt",
            'type'=>'textarea',
            'value'=>(isset($record['Image']['alt'])) ? $record['Image']['alt'] : ''));

        echo $this->Form->input('Title',array(
            'name'=>"data{$index}[Image][title]",
            'id' => "{$count}ImageTitle",
            'class' => "ImageTitle",
            'type'=>'textarea',
            'value'=>(isset($record['Image']['title'])) ? $record['Image']['title'] : ''));

        echo $this->Form->input('Category', array(
            'name'=>"data{$index}[Image][category]",
            'id' => "{$count}ImageCategory",
            'clas' => "ImageCategory",
            'type'=>'radio',
            'value'=>(isset($record['Image']['category'])) ? $record['Image']['category'] : '',
            'options'=> array(
                'dispatches'=>'Dispatch', 'exhibits'=>'Exhibit' 
            )
        ));
	?>
	</fieldset>