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
$fields = 0;
$allCount = FALSE;
if (isset($record['Cart'])) {
	foreach($record['Cart'] as $f) {
		$allcount = count($record['Cart']);
		$fields += ($f != '' && !is_null($f)) ? 1 : 0;
	}
}
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))? $display : ($fields == $allcount) ? 'hide' : 'show',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend: ($fields == $allcount) ? $record['Cart']['name'] . '<br />' . $record['Cart']['email'] . '<br />' . $record['Cart']['phone'] :'Contact',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
		'id' => array('type' => 'hidden'),
        'name',
        'email',
		'phone'
        )
);

echo $this->Fieldset->fieldset($parameters);
?>