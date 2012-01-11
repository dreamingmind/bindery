<?php
/* @var $this ViewCC */ 
?> 
	<?php
$parameters = array(
    'record'=> (isset($record))?$record:false,
    'legend'=>'Image data fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Image',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        //'img_file',
        'alt'=>array(
            'type'=>'textarea'
        ),
        'title',
        'category'=>array(
            'type'=>'radio',
            'options'=> array(
                'dispatches'=>'Dispatch', 'exhibits'=>'Exhibit'
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
