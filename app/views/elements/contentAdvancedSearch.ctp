<?php
/* @var $this ViewCC */ 

/**
 * Content.heading
 * Content.content
 * Content.alt
 * Content.title
 */
?> 
	<?php
$parameters = array(
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend:'Content data fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Content',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'heading'=>array(
            'label'=>'Title'
        ),
        'content'
    )
);

echo $fieldset->fieldset($parameters);
       
//       $this->Js->buffer(
//               "$('#{$fieldset->unique}').click(function() {
//  $('.{$fieldset->unique}').toggle(50, function() {
//    // Animation complete.
//  });
//});
//");
	?>
