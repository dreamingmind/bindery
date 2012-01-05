<?php
/* @var $this ViewCC */ 
?>
<?php
$parameters = array(
    'record'=> (isset($record))?$record:false,
    'legend'=>'Image meta fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Image',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'id',
        'upload',
        'modified',
        'created',
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