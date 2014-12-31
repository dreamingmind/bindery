<?php
/* @var $this ViewCC */ 

// do special funky logic to show inputs or a summary label 
// based on values in the cart record. We'll stop asking for 
// contact info once an name and email are provided.

$contact_present = FALSE;
if (isset($record['Cart'])) {
	if (
			isset($record['Cart']['name'])
			&& isset($record['Cart']['email'])
			&& (preg_match('/[a-zA-Z]+ [a-zA-Z]+/', $record['Cart']['name']))
			&& (preg_match('/[a-zA-Z\.]+@[a-zA-Z\.]+/', $record['Cart']['email']))
		) {
		$contact_present = TRUE;
	}
}

// another funky hack to suppress the placehoder prompts in pallet views 
// to reduce the preceived pressure on the user
if ($this->request->controller == 'checkout') {
	$prompt_require = '(required)';
	$prompt_optional = '(optional)';
} else  {
	$prompt_require = $prompt_optional = '';
}

$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))? $display : ($contact_present) ? 'hide' : 'show',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend: ($contact_present) ? $record['Cart']['name'] . ' • ' . $record['Cart']['email'] :'Contact',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
		'id' => array('type' => 'hidden'),
        'name' => array('placeholder' => $prompt_require),
        'email' => array('placeholder' => $prompt_require),
		'phone' => array('placeholder' => $prompt_optional)
        )
);

echo $this->Fieldset->fieldset($parameters);
?>