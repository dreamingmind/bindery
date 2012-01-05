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

    var $helpers = array('Html', 'Form', 'Session');

    /**
     *
     * @param type $params
     * @return type 
     */
    function fieldset($params = array()){
        
        // calling from a View, these values might not be set
        // but in the element they exist but may or may not get a value.
        // so if they didn't get a good value in the Element
        // we normalize make it look the same as a View call for simplicity
        if ($params['prefix']===false){
            unset( $params['prefix']);
        }

        if ($params['linkNumber']===false){
            unset( $params['linkNumber']);
        }

        if ($params['record']===false){
            unset( $params['record']);
        }
        
        $this->display = (isset($params['display'])&& $params['display']=='show')
            ? 'toggleShow'
            : 'toggleHide';
                
        $this->unique = String::uuid(); // uniquely target fieldset for show/hide
        $this->inputs = array();              // collect the input-html
        
        // assemble the 'prefix' portion of the 'name' attribute
        $this->prefixName = (isset($params['prefix']))
                ?'data['.implode('][', $params['prefix']).']'
                :'data';
        
        // assemble the 'prefix' portion of an id
        $this->prefixId = (isset($params['prefix']))
                ?implode('', $params['prefix'])
                :null;
        
        // would there ever NOT be a model?
        $this->model = (isset($params['model']))?$params['model']:null;
        
        // the related record number in a hasMany relationship
        $this->linkNumber = (isset($params['linkNumber']))?$params['linkNumber']:null;

        // flesh out the basic legend with prefix identifier strings
        $this->legend = (isset($params['legend']))
                ?$params['legend']
                :'';
        $this->legend = 
            ((!is_null($this->prefixId)) ? 'Record '.$this->prefixId.':' : '')
            . $this->legend .
            ((!is_null($this->linkNumber)) ? ':Link '.$this->linkNumber : '');
        
        // turn the legend+prefix into a slug for attribute use
        $this->legendSlug = str_replace(' ','_',$this->legend);
        
        // the requested fields to render
        $fields = $params['fields'];
        
        // the array of data
        $this->record = (isset($params['record']))?$params['record']:array();
        
        //compile the set of input tags
        foreach($fields as $index=>$field){
            if(is_string($params['fields'][$index])){
                //just a field name
               $this->inputs[$index]=$this->countingInput($params['fields'][$index]);
            } else {
                //a field name as index and its options as an array
               $this->inputs[$index]=$this->countingInput($index, $params['fields'][$index]);
            }            
        }
        
        //create the fieldset legend hml
        $this->legendTag = $this->Html->tag('legend',$this->legend,
            array('id'=>$this->unique));
        
        //Bundle the legend and inputs into a fieldset, wrapping 
        // the inputs in a div that keys to the legend
        // for show/hide toggling
        $this->fieldset = $this->Html->tag('fieldset',
            $this->legendTag
            . $this->Html->div($this->unique.' '.$this->display,implode('', $this->inputs))
        );
        
        //return the assembled fieldset
        return $this->fieldset;
    }
    
    /**
     *
     * @param type $field
     * @param type $options
     * @return type 
     */
    function countingInput($field = null, $options = array()){
        // assemble the name attribute
        $name = $this->prefixName.
                ((!is_null($this->model))?"[$this->model]":'').
                ((!is_null($this->linkNumber))?"[$this->linkNumber]":'').
                "[$field]";
        
        // assemble the id attribute (but it might not be unique)
        $id = $this->prefixId.$this->model.$this->linkNumber.Inflector::camelize($field);
        
        // this demands $this->model be set. up to this point it's been optional
        // but again, when would it NOT be set?
        if(!is_null($this->linkNumber)){
            $value = (isset($this->record[$this->model][$this->linkNumber][$field]))
                    ? $this->record[$this->model][$this->linkNumber][$field]
                    : '';
        } else {
            $value = (isset($this->record[$this->model][$field]))
                    ? $this->record[$this->model][$field]
                    : '';
        }
        $options = array(
            'name' => $name,
            'id' => $id,
            'class' => "input $this->legendSlug",
            'value' => $value
        ) + $options;
        
        return $this->Form->input(Inflector::camelize($field), $options);
    }
    
}

