<?php
/* @var $this ViewCC */
/**
 * Call with Category.supplement_defaults in $supplement_defaults
 *  or not if there are none.
 * 
 * This is the basic edit form for Category records.
 * It doesn't take into account Supplement records attached
 * to a ContentCollection. In that case, use 
 * Element supplementForm_dataFields which builds
 * on a copy of this code
 * 
 * Also pass a set of Supplement records with the field
 *  Supplement.id
 *  Supplement.type
 *  Supplement.data
 *  if they exist
 * 
 * 
 *  */
?>
<?php
if (isset($supplement_defaults)
    && str_word_count($supplement_defaults)>1)
    {
    
    $defaults = unserialize($supplement_defaults);
    $inputs = ''; 
    
    // this handles output of populated field sets
    // in the case where a stored, serialized
    // data packet is sent in
    foreach($defaults as $key => $value){
        $inputs .= oneInput($form, $key, $value);
    }
} else {
    // this handles output of a single, starter
    // field set when now data is provided
    $inputs = oneInput($form);
}

echo $inputs;

/**
 * This function returns one key=>value input field pair
 * 
 * @param object $form The form helper object sent from the View
 * @param string $key The 'key' value for the form input
 * @param string $value The 'value' value for the form input
 * @return string HTML <div><label></label><input/><input/><button/><button/></div>
 */
function oneInput(&$form, $key = '', $value = '') {
    
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