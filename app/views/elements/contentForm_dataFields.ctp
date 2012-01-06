<?php
/* @var $this ViewCC */ 
?> 
	<?php
$parameters = array(
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend:'Content data fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Content',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'heading',
        'content' => array(
            'type'=> 'textarea'
        ),
        'alt',
        'title',
        'publish'=> array(
            'type'=>'radio',
            'options'=> array(
                '1'=>'Publish', '0'=>'Hold' 
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
