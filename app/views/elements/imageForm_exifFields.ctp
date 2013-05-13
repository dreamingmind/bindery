<?php
/* @var $this ViewCC */ 
/**
 * Record array (accepts standard array or file object with exif data in it)
 * Image.mimetype
 * Image.filesize
 * Image.date
 * Image.width
 * Image.height
 * Image.img_file (this is hidden and won't allow file uploads)
 * 
 * Image.reread_exif (I don't think this has to be in the array. It's for post-processing)
 */
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
    $dateLabel = 'Date: '.$record->exif['EXIF']['DateTimeOriginal'];
}
$dateLabel = (isset($dateLabel)) ? $dateLabel : date('m-j-Y h:m',$record['Image']['date']);

$parameters = array(
    'post_fields'=>$dateLabel,
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
	?>
