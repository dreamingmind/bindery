<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.helper
 */
/**
 * @package bindery
 * @subpackage bindery.helper
 */
class FieldsetHelper extends AppHelper {
    
    function input($field = null, $options = array()){
        $name = $this->prefix.$this->model.$this->linkNumber.$field;
        $id = str_replace(array('data[','[',']'), '', $name);
        $options = array(
            'name' => $name,
            'id' => $id,
            'class' => 'input $fieldsetId',
            'value' => $this->value
        ) + $options;
                
        return FormHelper::input($field, $options);
    }
}

