<?php

$name = 'Options:63'; // CLOSING BELT
$item = QBModel::InvItem('NAME', $name);


/* @var $this ViewCC */
$options = array(
    'options' => array(
        '1' => 'Yes',
        '0' => 'No'
    )
);
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'show',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : $item['INVITEM']['DESC'],
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        $name => array(
			'label' => $item['INVITEM']['DESC'],
            'price' => $item['INVITEM']['PRICE'],
            'type' => 'radio',
            'options' => array('0' => 'No', '1' => 'Yes'),
            'price' => 16,
            'default' => '0',
            'legend' => false,
            'option' => 'master-belt'.$model, // controls the diagram area belt div
            'setlist' => 'belt',
            'material' => 'leather', //this target diagram div background image
            'div' => array('oldprice' => 0)
        )
    )
);

$htmlBlock =  $this->Fieldset->fieldset($parameters);
/**
 * This is a rough pattern for detailing out a radio button set to act as masters
 * it should work for checkboxes or select lists too
 */
$master = array(
    'nameSpace' => '-belt'.$model,
    'sets' => $options['options']
);

$htmlBlock = preg_replace('/(type="radio")/', "$1 option=\"master{$master['nameSpace']}\"", $htmlBlock);
foreach($master['sets'] as $value => $set){
    $htmlBlock = preg_replace("/(value=\"{$value}\")/", "$1 setlist=\"{$set}\"", $htmlBlock);
}
echo $htmlBlock;
?>