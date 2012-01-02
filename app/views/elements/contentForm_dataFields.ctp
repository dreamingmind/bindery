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

?> 
	<fieldset id="<?php echo "contentDataFields$count"; ?>" class="dataFields">
 		<legend><?php __("$label Content data fields"); ?></legend>
	<?php
        echo $this->Form->input('Content',array(
            'name'=>"data{$index}[Content][heading]",
            'id' => "{$count}ContentHeading",
            'class' => "ContentHeading",
            'value'=>(isset($record['Content']['heading'])) ? $record['Content']['heading'] : ''));
         
        echo $this->Form->input('Content',array(
            'name'=>"data{$index}[Content][content]",
            'id' => "{$count}ContentContent",
            'class' => "ContentContent",
            'type'=>'textarea',
            'value'=>(isset($record['Content']['content'])) ? $record['Content']['content'] : ''));
         
        echo $this->Form->input('Alt',array(
            'name'=>"data{$index}[Content][alt]",
            'id' => "{$count}ContentAlt",
            'class' => "ContentAlt",
            'type'=>'textarea',
            'value'=>(isset($record['Content']['alt'])) ? $record['Content']['alt'] : ''));

        echo $this->Form->input('Title',array(
            'name'=>"data{$index}[Content][title]",
            'id' => "{$count}ContentTitle",
            'class' => "ContentTitle",
            'value'=>(isset($record['Content']['title'])) ? $record['Content']['title'] : ''));

        echo $this->Form->input('Category', array(
            'name'=>"data{$index}[Content][publish]",
            'id' => "{$count}ContentPublish",
            'clas' => "ContentPublish",
            'type'=>'radio',
            'value'=>(isset($record['Content']['publish'])) ? $record['Content']['publish'] : '',
            'options'=> array(
                '1'=>'Publish', '0'=>'Hold' 
            )
        ));
	?>
	</fieldset>