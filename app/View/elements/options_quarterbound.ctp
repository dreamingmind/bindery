<?php

/* @var $this ViewCC */
$options = array(
    'options' => array(
        '0' => 'Match liners to cover',
        '1' => 'Set liner cloth'
    )
);

$parameters = array(
    'fieldsetOptions'=>(isset($fieldsetOptions))?$fieldsetOptions:'',
    'pre_fields' => (isset($pre_fields)) ? $pre_fields : '',
    'post_fields' => (isset($post_fields)) ? $post_fields : '',
    'display' => (isset($display)) ? $display : 'show',
    'record' => (isset($record)) ? $record : false,
    'legend' => (isset($legend)) ? $legend : 'Cover Material Selection',
    'prefix' => (isset($prefix)) ? $prefix : false,
    'model' => (isset($model)) ? $model : 'Option',
    'linkNumber' => (isset($linkNumber)) ? $linkNumber : false,
    'fields' => array(
        'leather' => array(
            'type' => 'select',
            'options' => $leatherOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'FullLeather QuarterBound'
            ),
            'material' => 'leather' //this target diagram div background image
        ),
        'cloth' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'QuarterBound'
            ),
            'material' => 'cloth board' //this target diagram div background image
        ),
        // this one has some hacky tricks. See comments at the end
        'uniqueliner' => array(
            'type' => 'radio',
            'options' => $options['options'],
//            'options' => array(
//                '0' => 'Match liners to cover',
//                '1' => 'Set liner cloth' // These get modified by code at the bottom of this page
//                ),
            'legend' => false,
            'div' => array(
                'option' => 'slave-'.$productCategory,
                'setList' => 'QuarterBound'
            )
        ),
        'liner' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
            'option' => 'slave-'.$productCategory,
            'setList' => 'FullLeather'
            ),
            'material' => 'cloth liners'
        ),
        'liners' => array(
            'type' => 'select',
            'options' => $clothOptions,
            'div' => array(
                'option' => 'slave-uniqueliner',
                'setList' => 'Set'
            ),
            'material' => 'cloth liners',
//        ),
//        'endpapers' => array(
//            'type' => 'select',
//            'options' => $endpaperOptions,
//            'div' => array(
//                'option' => 'slave-'.$productCategory,
//                'setList' => 'endpapers'
//            ),
//            'material' => 'endpaper' //this target diagram div background image
        )
    )
);

/**
 * Things are getting a bit complicated.
 * 
 * I've got one liner field slaved to FullLeather
 * and the liners field slaved to the radios on QuarterBound
 * Journals have none of this. Just kill all the liner stuff.
 */

if ($parameters['model'] == 'Journal') {
    unset($parameters['fields']['uniqueliner']);
    unset($parameters['fields']['liners']);
    unset($parameters['fields']['liner']);
}

$htmlBlock =  $this->Fieldset->fieldset($parameters);

if ($parameters['model'] != 'Journal'){
    //debug($htmlBlock);die;
    /**
     * This is a rough pattern for detailing out a radio button set to act as masters
     * it should work for checkboxes or select lists too
     */
    $master = array(
        'nameSpace' => '-uniqueliner',
        'sets' => $options['options']
    );

    $htmlBlock = preg_replace('/(type="radio")/', "$1 option=\"master{$master['nameSpace']}\"", $htmlBlock);
    foreach($master['sets'] as $value => $set){
        $htmlBlock = preg_replace("/(value=\"{$value}\")/", "$1 setlist=\"{$set}\"", $htmlBlock);
    }

}
echo $htmlBlock;
/** UNIQUE LINER
 * To tie cover cloth and liner cloth together by default, this radio
 * button supressess the liner cloth. But journals have cloth on the 
 * cover without the liner. So, Journals unset uniqueliner to prevent
 * this feature from showing up.
 * 
 */
?>