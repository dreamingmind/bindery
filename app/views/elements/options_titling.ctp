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
    'legend'=> (isset($legend))?$legend:'Hot Stamping and Titling Options',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Option',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array(
        'title_choice' => array(
            'type' => 'radio',
            'options' => array(
                '1' => 'Yes',
                '0' => 'No'
            ),
            'default' => 0,
            'option' => 'master-titling',
            'class' => 'titling',
            'label' => 'Title, Name or Initials?'
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
            'option' => 'slave-titling',
            'class' => 'titling',
            'div' => array(
                'option' => 'slave-titling',
                'class' => 'Hot_Stamping_and_Titling_Options'
            )
        ),
        'title_text' => array(
            'type' => 'textarea',
            'option' => 'slave-titling',
            'class' => 'titling',
            'div' => array(
                'option' => 'slave-titling',
                'class' => 'Hot_Stamping_and_Titling_Options'
            )
        )
    )
);

echo $fieldset->fieldset($parameters);
?>
