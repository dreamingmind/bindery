<?php
/* @var $this ViewCC */
/**
 * Record array
 * Image.id
 * Image.upload
 */
?>
<?php
$parameters = array(
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=>'Image meta fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Image',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'id',
        'upload'//,
//        'modified',
//        'created'
    )
);

echo $this->Fieldset->fieldset($parameters);
?>