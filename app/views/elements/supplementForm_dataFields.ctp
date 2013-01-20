<?php
/* @var $this ViewCC */ 

/**
 * this one could get pre-compiled field pairs
 * which get dropped into post_fields
 * That would make a more compact unit
 * Supplement.type
 * Supplement.data
 * 
 * Three additional parameters have been added to this fieldset element
 * $supplement_defaults: the Categories serialized defaults array
 * $supplements: the set of Supplement records for the current ContentCollection record
 * $form_helper: since this element generates HTML it needs the Form Helper
 * 
 */
?> 
	<?php
//        $post_fields = $this->element('supplement_default_fields', array('supplement_defaults'=>$data['ContentCollection'][0]['Collection']['Category']['supplement_list']));
//        debug($data['ContentCollection'][0]['Collection']['Category']['supplement_list']);
//        debug($data['ContentCollection'][0]['Supplement']);
$parameters = array(
    'supplement_defaults' => (isset($supplement_defaults)?$supplement_defaults:false),
    'supplements' => (isset($supplements)?$supplements:false),
    
    'pre_fields' => (isset($pre_fields))?$pre_fields:'',
    'post_fields' => (isset($post_fields))?$post_fields:'',
    'display'=> (isset($display))?$display:'hide',
    'record'=> (isset($record))?$record:false,
    'legend'=> (isset($legend))?$legend:'Supplement fields',
    'prefix'=> (isset($prefix))?$prefix:false,
    'model'=>'Content',
    'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
    'fields'=>array()
//        'type',
//        'data'    )
);
//

$merged_supplements = mergeSupplements($parameters);

if($merged_supplements){
    
} else {
    $parameters['post_fields'] = oneInput($form_helper);
}

echo $fieldset->fieldset($parameters);
       
       $this->Js->buffer(
               "$('#{$fieldset->unique}').click(function() {
  $('.{$fieldset->unique}').toggle(50, function() {
    // Animation complete.
  });
});
");
  
//    if (isset($supplement_defaults)
//        && str_word_count($supplement_defaults)>1)
//        {
//
//        $defaults = unserialize($supplement_defaults);
//        $inputs = ''; 
//
//        // this handles output of populated field sets
//        // in the case where a stored, serialized
//        // data packet is sent in
//        foreach($defaults as $key => $value){
//            $inputs .= oneInput($form, $key, $value);
//        }
//    } else {
//        // this handles output of a single, starter
//        // field set when now data is provided
//        $inputs = oneInput($form);
//    }
//
//echo $inputs;


    /**
     * 
     * @param array $params The entire parameter set
     * @return array|false False if there are no Supplements, default or stored; merged array otherwise
     */
    function mergeSupplements($params){  
        //indicate no supplement data provided
        $merged = false;
        if($params['supplement_defaults']){
            //get a starter array from the Category defaults
            $merged = unserialize($params['supplement_defaults']);
        }
        if($params['supplements']){
            //overlay the stored ContentCollection data
            //add the Supplement.id for later save and
            //as an indicator of a non-default, stored value
            foreach($params['supplements'] as $count => $record){
                $merged[$record['type']] = $record['data'];
                $merged[$record['type']]['id'] = $record['id'];
            }
        }
        return $merged;
    }

    /**
     * This function returns one key=>value input field pair
     * 
     * @param object $form The form helper object sent from the View
     * @param string $key The 'key' value for the form input
     * @param string $value The 'value' value for the form input
     * @return string HTML <div><label></label><input/><input/><button/><button/></div>
     */
    function oneInput(&$form, $key = '', $value = '') {
    //function oneInput($key = '', $value = '') {

        $i1 = $form->input('supplement_list',array(
            'name'=>'data[Category][supplement_key][]',
            'class'=>'supplement_list',
            'id'=>false,
            'div'=>false,
            'value'=>$key
            ))
        .'&nbsp;=>&nbsp;'.
        $form->input('supplement_list',array(
            'name'=>'data[Category][supplement_value][]',
            'class'=>'supplement_list',
            'id'=>false,
            'div'=>false,
            'label'=>false,
            'value'=>$value
            ))
         .$form->button('+',array(
             'class'=>'supplement_list clone',
             'type'=>'button',
             'title'=>'Clone this'

         ))
         .$form->button('-',array(
             'class'=>'supplement_list remove',
             'type'=>'button',
             'title'=>'Remove this'
         ))
         ."\n";

        return '<div class="input text">' . $i1. '</div>';
    }
    
	?>
