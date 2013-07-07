<?php
/* @var $this ViewCC */ 

/**
 * Content.heading
 * Content.content
 * Content.alt
 * Content.title
 */
$options = array(
    'options' => array(
        '1' => 'Yes',
        '0' => 'No'
    )
);
?> 
<?php
$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))?$display:'show',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend:'Hot Stamping and Titling Options',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'title_choice' => array(
            'type' => 'radio',
            'options' => array(
                '0' => 'No',
                '1' => 'Yes'
            ),
            'default' => 0,
            'legend' => false
        ),
        'foil-color' => array(
            'type'=> 'select',
            'options'=> array(
                '' => 'Select Foil Color',
                'blind' => 'Blind',
                'black' => 'Black',
                'lightgray' => 'Light Gray',
                'white' => 'White',
                'gold' => 'Gold',
                'silver' => 'Silver'
            ),
            'div' => array(
                'option' => 'slave-titling',
                'setList' => 'Yes'
            )
        ),
        'title_text' => array(
            'type' => 'textarea',
            'rows' => 2,
            'div' => array(
                'option' => 'slave-titling',
                'setlist' => 'Yes'
            )
        )
    )
);

$htmlBlock =  $fieldset->fieldset($parameters);
/**
 * This is a rough pattern for detailing out a radio button set to act as masters
 * it should work for checkboxes or select lists too
 */
$master = array(
    'nameSpace' => '-titling',
    'sets' => $options['options']
);

$htmlBlock = preg_replace('/(type="radio")/', "$1 option=\"master{$master['nameSpace']}\"", $htmlBlock);
foreach($master['sets'] as $value => $set){
    $htmlBlock = preg_replace("/(value=\"{$value}\")/", "$1 setlist=\"{$set}\"", $htmlBlock);
}
echo $htmlBlock;
?>
