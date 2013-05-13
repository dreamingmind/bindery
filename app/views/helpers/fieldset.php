<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.Data
 */
/**
 * Fieldset Helper
 * 
 * @package bindery
 * @subpackage bindery.Data
 */
class FieldsetHelper extends AppHelper {

    var $helpers = array('Html', 'Form', 'Session');

    /**
     * A general purpose fieldset output procedure
     * 
     * This can be called from a Veiw for a one-off fieldset, or create
     * Elements that generate reusable and portable fieldsets. Here's a 
     * sample Element:
     * 
     *  <code>$parameters = array(
     *     'display'=> (isset($display))?$display:'hide',
     *     'record'=> (isset($record))?$record:false,
     *     'legend'=>'Content meta fields',
     *     'prefix'=> (isset($prefix))?$prefix:false,
     *     'model'=>'Content',
     *     'linkNumber'=> (isset($linkNumber))?$linkNumber:false,
     *     'fields'=>array(
     *         'id',
     *         'image_id',
     *         'modified',
     *         'created',
     *         'publish'=> array(
     *             'type'=>'radio',
     *             'options'=> array(
     *                 '1'=>'Publish', '0'=>'Hold' 
     *             )
     *          )
     *     )
     * );</code>

     * The fieldset will toggle open/closed by clicking on the fieldset legend.
     * Use 'display' set to 'show' or 'hide' to set the initial state
     * 
     * Providing data in 'record' will populate the inputs, otherwise
     * they'll be empty
     * 
     * 'prefix', 'model' and 'linkNumber' are used to assemble the
     * Html name attribute (which controls the returned data array).
     * This can handle any Cake-style data array for models.
     * 'prefix' is an array, the others are strings. All three components
     * are combined to make the data array index pattern:
     * <code>//prefix=null,model='Image',linkNumber=null
     * data[Image][fieldName] 
     * 
     * //prefix=array('Post'),model='Content',linkNumber=3
     * data[Post][Content][3][fieldName] 
     * 
     * //prefix=array('2','Post'),model='Author',linkNumber=null
     * data[2][Post][Author][fieldName] </code>
     * 
     * 'fields' is an array which controls what will be in the fieldset.
     * If the element is a string, you'll get a default cake input for
     * that field. If it's an array, the index will be the field name
     * and array will be the options to pass to the cake input helper.
     * 
     * Controls:
     *  - display
     *  - legend
     *  - record
     *  - prefix
     *  - model
     *  - linkNumber
     *  - fields
     * 
     * 'pre_fields' and 'post_fields' accept ready-to-go HTML fragments.
     *  
     * javascript/css hooks
     * 
     * --------------------
     * 
     * In addition to the standard structure Cake gives to inputs:
     * Each fieldset gets a UUID id attribute
     * Each field get UUID-fieldname id attribute
     * The field inputs are wrapped in a div with class UUID
     * Each input gets a class attribute set to the legend with spaces replaced with _
     * 
     * @param array $params The control-block to describe all aspects of the fieldset to be created
     * @return string The complete fieldset HTML code 
     */
    function fieldset($params = array()){
        
        // calling from a View, these values might not be set
        // but in the element they exist but may or may not get a value.
        // so if they didn't get a good value in the Element
        // we normalize make it look the same as a View call for simplicity
        if (isset($params['prefix']) && $params['prefix']===false){
            unset( $params['prefix']);
        }

        if (isset($params['linkNumber']) && $params['linkNumber']===false){
            unset( $params['linkNumber']);
        }

        if (isset($params['record']) && $params['record']===false){
            unset( $params['record']);
        }
        
        // arrbitrary content to insert before and after the fields
        $this->pre_fields = (!isset($params['pre_fields']))?'':$params['pre_fields']; 
        $this->post_fields = (!isset($params['post_fields']))?'':$params['post_fields'];
        
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
            array('id'=>$this->unique,'class'=>'toggle'));
        
        //Bundle the legend and inputs into a fieldset, wrapping 
        // the inputs in a div that keys to the legend
        // for show/hide toggling
        $this->fieldset = $this->Html->tag('fieldset',
            $this->legendTag . $this->Html->div(
                    $this->unique.' '.$this->display,
                    $this->pre_fields . implode('', $this->inputs) . $this->post_fields
                    )
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
            'id' => "$this->unique-$field",
            'class' => "input $this->legendSlug",
            'value' => $value
        ) + $options;
        
        return $this->Form->input(Inflector::camelize($field), $options);
    }
    
}

