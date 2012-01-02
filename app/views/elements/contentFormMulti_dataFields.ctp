<?php
/* @var $this ViewCC */ 
////These are the anticipated values
//$count = $replace;    //optional
////Pass in $record with these array elements or $object
//$record['Content'] = array( 
//    'heading'=>$replace,
//    'content'=>$replace,
//    'alt'=>$replace,
//    'title'=>$replace,
//    'publish'=>$replace
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

foreach($record['Content'] as $linkNumber => $linkRecord){
?> 
	<fieldset id="<?php echo "contentDataFields$count.$linkNumber"; ?>" class="dataFields">
 		<legend><?php __("$label.$linkNumber: Content data fields"); ?></legend>
	<?php
        echo $this->Form->input('Content',array(
            'name'=>"data{$index}[Content][{$linkNumber}][heading]",
            'id' => "{$count}.{$linkNumber}ContentHeading",
            'class' => "ContentHeading",
            'value'=>(isset($linkRecord['heading'])) ? $linkRecord['heading'] : ''));
         
        echo $this->Form->input('Content',array(
            'name'=>"data{$index}[Content][{$linkNumber}][content]",
            'id' => "{$count}.{$linkNumber}ContentContent",
            'class' => "ContentContent",
            'type'=>'textarea',
            'value'=>(isset($linkRecord['content'])) ? $linkRecord['content'] : ''));
         
        echo $this->Form->input('Alt',array(
            'name'=>"data{$index}[Content][{$linkNumber}][alt]",
            'id' => "{$count}.{$linkNumber}ContentAlt",
            'class' => "ContentAlt",
            'type'=>'textarea',
            'value'=>(isset($linkRecord['alt'])) ? $linkRecord['alt'] : ''));

        echo $this->Form->input('Title',array(
            'name'=>"data{$index}[Content][{$linkNumber}][title]",
            'id' => "{$count}.{$linkNumber}ContentTitle",
            'class' => "ContentTitle",
            'value'=>(isset($linkRecord['title'])) ? $linkRecord['title'] : ''));

        echo $this->Form->input('Category', array(
            'name'=>"data{$index}[Content][{$linkNumber}][publish]",
            'id' => "{$count}.{$linkNumber}ContentPublish",
            'clas' => "ContentPublish",
            'type'=>'radio',
            'value'=>(isset($linkRecord['publish'])) ? $linkRecord['publish'] : '',
            'options'=> array(
                '1'=>'Publish', '0'=>'Hold' 
            )
        ));
	?>
	</fieldset>
<?php
}
?>