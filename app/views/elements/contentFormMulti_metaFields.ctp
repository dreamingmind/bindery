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
 * This will output a fieldset with inputs for the Content user selectible data fields
 * 
 * Providing $count will index the fields so multiple records can be processed
 * If $record (array) is set, this will be used to set the field values
 */
$count = (isset($count)) ? $count : null; //multiple records?
$index = ($count != null) ? "[$count]" : false; //data array index
$label = ($count != null) ? "Record $count:" : ''; //legend

foreach($record['Content'] as $linkNumber => $linkRecord){
?> 
	<fieldset id="<?php echo "contentMetaFields$count.$linkNumber"; ?>" class="metaFields">
 		<legend><?php __("$label.$linkNumber: Content meta fields"); ?></legend>
	<?php
        echo $this->Form->input('Content',array(
            'name'=>"data{$index}[Content][{$linkNumber}][id]",
            'id' => "{$count}.{$linkNumber}ContentId",
            'class' => "ContentId",
            'value'=>(isset($linkRecord['id'])) ? $linkRecord['id'] : ''));
         
        echo $this->Form->input('Content',array(
            'name'=>"data{$index}[Content][{$linkNumber}][image_id",
            'id' => "{$count}.{$linkNumber}ContentImageId",
            'class' => "ContentImageId",
            'type'=>'textarea',
            'value'=>(isset($linkRecord['image_id'])) ? $linkRecord['image_id'] : ''));
         
        echo $this->Form->input('Alt',array(
            'name'=>"data{$index}[Content][{$linkNumber}][created]",
            'id' => "{$count}.{$linkNumber}ContentCreated",
            'class' => "ContentCreated",
            'type'=>'textarea',
            'value'=>(isset($linkRecord['created'])) ? $linkRecord['created'] : ''));

        echo $this->Form->input('Title',array(
            'name'=>"data{$index}[Content][{$linkNumber}][modified]",
            'id' => "{$count}.{$linkNumber}ContentModified",
            'class' => "ContentModified",
            'value'=>(isset($linkRecord['modified'])) ? $linkRecord['modified'] : ''));
	?>
	</fieldset>
<?php
}
?>