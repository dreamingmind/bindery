<?php
/* @var $this ViewCC */ 
/**
 * Date.year
 * Date.season
 * Date.month
 * Date.week
 * 
 * Image.recent_titles (array for drop list)
 * 
 */
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
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=>'Date ranges',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'DateRange',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'month'=>array(
            'options'=>$month
        ),
        'year'=>array(
            'options'=>$year
        ),
        'week'=>array(
            'options'=>$week
        )
    )
);

echo $this->Fieldset->fieldset($parameters);
?>
