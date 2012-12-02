<?php
/* @var $this ViewCC */ 
?> 
	<?php
                    
if(is_object($record)){
    $recordArray = array();
    $recordArray['Image']['mimetype'] = $record->exif['FILE']['MimeType'];
    $recordArray['Image']['filesize'] = $record->exif['FILE']['FileSize'];
    $recordArray['Image']['date'] = strtotime($record->exif['EXIF']['DateTimeOriginal']);
    $recordArray['Image']['width'] = $record->exif['COMPUTED']['Width'];
    $recordArray['Image']['height'] = $record->exif['COMPUTED']['Height'];
    $record = $recordArray;
}

$parameters = array(
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=>'Image exif fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Image',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'mimetype',
        'filesize',
        'width',
        'height',
        'date',
        'img_file'=>array('type'=>'hidden'),
        'reread_exif'=>array(
            'type'=>'checkbox',
            'options'=>array(
                'yes'
            )
        )
    )
);

echo $fieldset->fieldset($parameters);
       
       $this->Js->buffer(
               "$('#{$fieldset->unique}').click(function() {
  $('.{$fieldset->unique}').toggle(50, function() {
    // Animation complete.
  });
});
");
	?>
