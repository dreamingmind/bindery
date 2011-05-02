<?php
/**
 * The possible Opt-ins for the form will be pulled from Models
 *
 * Opt-in labels will be in optins, the current setting for the user in optin_users
 */
foreach ($optins as $val) {
    $options[$val['Optin']['id']] = $val['Optin']['label'];
}
$selected = array();
if(isset($selections)){
    foreach ($selections as $val) {
       array_push($selected, $val['OptinUser']['optin_id']);
    }
}


echo $form->create('Account', array('class'=>'float_form', 'action'=> 'opt_in'));
echo "<fieldset>";
echo "<legend>Select your notification options</legend>";
echo $form->input('OptinUser.optin_id',
    array(
        'label'=>'',
        'type' => 'select',
        'multiple' => 'checkbox',
        'options' => $options,
    'selected' => $selected
));
echo "</fieldset>";
echo $form->end('Accept changes');

//debug($records);
//debug($selections);
//debug($selected);
//debug($this->data);
//debug($options);
?>
