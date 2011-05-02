<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.helper
 */

class TreeCrudHelper extends AppHelper {
    var $helpers = array('Html', 'Form', 'Session');

    var $cr = "\n";
    var $t1 = "\t";
    var $t2 = "\t\t";
    var $newFormStart = null;
    var $newFormEnd = null;


/**
 * Return a select input element for the tree_crud form
 *
 * @param string $label The input label to prompt the user
 * @param array $options modelName, fieldName and selectList to override defaults
 */
    function select($label, $model, $field, $list) {

        return $this->Form->input(
            "$model.$field",
            array('type'=>'select',
                'options'=>$list,
                'label'=>$label
       ));
    }

    function distinct_select($link=null, $list='distinct', $label="Available names") {
        if ($link) {
            $model = $this->data['primaryModel'];
            $field = $link.'-'.$this->data['displayField']['suffix']['form'];
        } else {
            $model = $this->data['primaryModel'];
            $field = $this->data['displayField']['field']
                    .$this->data['displayField']['suffix']['select']
                    .'-'.$this->data['displayField']['suffix']['form'];
        }
        $list = ($list == 'distinct') ? $this->data['treeCrudList']['distinct'] : $list;
        return $this->select($label, $model, $field, $list);
    }

    function element_select($label="Element", $model=null, $field='id', $list='select') {
        $model = $this->data['primaryModel'];
        $list = $this->data['treeCrudList'][$list];
        return $this->select($label, $model, $field, $list);
    }

    function parent_select($label="Element", $model=null, $field='parent_id', $list='parent') {
        $model = $this->data['primaryModel'];
        $list = $this->data['treeCrudList'][$list];
        return $this->select($label, $model, $field, $list);
    }

    function newName($model=null, $field=null, $label="New name"){
        return $this->Form->input(
                "$model.$field"
                .$this->data['displayField']['suffix']['direct']
                .'-'.$this->data['displayField']['suffix']['form']
                , array('label'=>'New name'));
    }
/**
 * DELETE
 * select a node
 */
    function deleteForm() {
        $form = '';
        $form .= $this->element_select('Element to delete');
        $legend = 'Delete';
        $this->deleteFormStart = $this->formWrapperOpen($form, $legend, 'delete', 'd');
        $this->deleteFormEnd = $this->formWrapperClose($legend);
    }

/**
 * FOCUS
 * select a node
 */
    function focusForm() {
        $form = '';
        $form .= $this->element_select('Element to focus');
        $legend = 'Focus on a node';
        $this->focusFormStart = $this->formWrapperOpen($form, $legend, 'focus', 'f');
        $this->focusFormEnd = $this->formWrapperClose($legend);
    }

/**
 * MOVE UP/MOVE DOWN
 * select a node
 * delta
 * @param string $move 'up' or 'down'
 */
    function moveForm() {
        $form = '';
        $form .= $this->element_select('Element to move');
        $form .= $this->Form->input($this->data['primaryModel'].'.delta', array('label'=>'Steps'));
        return $form;
    }
    
    function upForm() {
        $form = $this->moveForm('up');
        $legend = 'Move up';
        $this->upFormStart = $this->formWrapperOpen($form, $legend, 'up', 'u');
        $this->upFormEnd = $this->formWrapperClose($legend);
   }

    function downForm() {
        $form = $this->moveForm('down');
        $legend = 'Move down';
        $this->downFormStart = $this->formWrapperOpen($form, $legend, 'down', 'w');
        $this->downFormEnd = $this->formWrapperClose($legend);
    }

 /**
 * NEW NODE
 * select a node
 * new node name
 * existing node name
  * @param string $action 'new' or 'rename'
 */
    function newForm() {
        $this->data['displayField']['suffix']['form'] = 'e'; //pass along to make id's unique for javascript function assignment
        $form = '';
        $form .= $this->parent_select('Parent Element');
        $form .= $this->newName($this->data['displayField']['model'], $this->data['displayField']['field']);
        $form .= $this->distinct_select($this->data['displayField']['link']);
        $legend = 'New Element';
        $this->newFormStart = $this->formWrapperOpen($form, $legend, 'new', $this->data['displayField']['suffix']['form']);
        $this->newFormEnd = $this->formWrapperClose($legend);
    }
    
 /**
 * RENAME NODE
 * select a node
 * new node name
 * existing node name
  * @param string $action 'new' or 'rename'
 */
    function renameForm($action='new') {
        $this->data['displayField']['suffix']['form'] = 'r'; //pass along to make id's unique for javascript function assignment
        $form = '';
        $form .= $this->element_select('Element to rename');
        $form .= $this->newName($this->data['displayField']['model'], $this->data['displayField']['field']);
        $form .= $this->distinct_select($this->data['displayField']['link']);
        $legend = 'Rename Element';
        $this->renameFormStart =  $this->formWrapperOpen($form, $legend, 'rename', $this->data['displayField']['suffix']['form']);
        $this->renameFormEnd =  $this->formWrapperClose($legend);
    }

/**
 * MOVE TO DIFFERENT PARENT
 * select a node
 * select a parent node
 * @return string
 */
    function parentForm() {
        //$form = $this->cr.$this->t1.$this->t2;
        $form = $this->element_select('Element');
        $form .= $this->cr.$this->t1.$this->t2;
        $form .= $this->parent_select('New Parent');
        $legend = 'New Parent';
        $this->parentFormStart =  $this->formWrapperOpen($form, $legend,'parent', 'p');
        $this->parentFormEnd =  $this->formWrapperClose($legend);
    }

    /**
     * Wrap fom content in an id'd fieldset with a named flash message
     *
     * The fieldset tag is left open so the element can get
     * additional fields can be added to the basic tree set
     *
     * @param string $form Form content to be wrapped in an id'd fieldset
     * @param string $legend Legend to be used for this fieldset
     * @param string $name Name attribute for the fieldset to label and identify appropriate flash message
     * @param string $id The id for this fieldset
     * @return string the fieldset HTML excluding the closing fieldset tag
     */
    function formWrapperOpen($form, $legend, $name, $id) {
//         $this->Form->create($name, array('action'=>'manage_tree', 'class'=>'function'))//
//                .$this->cr.$this->t1.
        return  "<fieldset id='$id' class='function'>"
                .$this->cr.$this->t2
                .$this->Html->tag('legend', $legend)
                .$this->cr.$this->t2
                ."<!-- Flash '$name' message -->" . $this->Session->flash($name)
                .$this->cr.$this->t1.$this->t2
                .$form;
    }
    
    function formWrapperClose($legend) {
        return $this->cr.$this->t2
        .$this->Form->button($legend)
        .$this->cr.$this->t1
        ."</fieldset>"
        .$this->cr; // view element adds the </legend> required for this wrapper

    }
    
 /**
  * Work out the field id names and logic for the newForm/renameForm javascript
  * 
  * There are two ways to input a new name; directly as text or by 
  * selecting an existing name from a list. Depending on whether the 
  * name is in stored in primaryModel or in a belongsTo table, the
  * process is quite different.
  */
    function newNameJavascript($formKey) {
        if ($this->data['displayField']['link']) {
            //true means foreign name field and direct vs select
            //name input go to different fields
            $directInput = $this->data['displayField']['model'].Inflector::camelize($this->data['displayField']['field'].$formKey);
            $selectInput = $this->data['primaryModel'].Inflector::camelize($this->data['displayField']['link'].$formKey);
        } else {
            //false means local name and direct vs select
            //name input go to the same field reference.
            //They have been suffixed to remove ambiguity
            $input = $this->data['primaryModel'].Inflector::camelize($this->data['displayField']['field']);
            $directInput = $input.$this->data['displayField']['suffix']['direct'].$formKey;
            $selectInput = $input.$this->data['displayField']['suffix']['select'].$formKey;
        }
            return "
    $('#$directInput').change(
        function(){
            $('#$selectInput').val(-1);
        }
    );
    $('#$selectInput').change(
        function(){
            $('#$directInput').val('');
        }
    );";
    }

}
?>
