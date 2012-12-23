<?php
/* @var $this ViewCC */ 
?> 
<?php

// This has been modified so it requires $record
// but $record does not need to carry the field data
// which still remains optional. But the calling
// view needs to add 'options'=>'recent_title'
// (an array of... duh, recent titles).
// This could/should be expanded to include
// 'options'=>'category' so the category radio list
// will be dynamic too.
$parameters = array(
    'display'=> (isset($display))?$display:'hide',
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
        'recent_titles'=>array(
            'options'=>(isset($record)&&isset($record['recent_titles']))?$record['recent_titles']:''
        ),
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
