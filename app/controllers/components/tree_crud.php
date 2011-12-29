<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.component
 */
/**
 * TreeCrud Component
 * 
 * Handle tasks to impliment an editing system for tree data
 * 
 * @package       bindery
 * @subpackage    bindery.component
 */
class TreeCrudComponent extends Object {

    var $components = array('Session');
    var $tree_crud = array();
//    var $controller = null;
    var $helpers = array(
        'TreeCrud'
    );

    function beforeFilter() {
        parent::beforeFilter();
        //$this->controller->{$this->controller->modelClass}->displayField = "alias";
    }

    /**
     * The display field
     *
     * Just like you might set it in the moddel
     * 'Profile.name' or 'alias'
     *
     * @var string
     * @access public
     */
	var $displayField = null;

    /**
     * Name of the model that contains the displayField
     *
     * @var string
     * @access public
     */
	var $displayFieldModel = null;

    /**
     * Name of the field that is the displayField
     *
     * @var string
     * @access public
     */
	var $displayFieldField = null;

    /**
     * Name of the field that contains the displayFields id
     * if that field is foreign
     *
     * @var string
     * @access public
     */
	var $displayFieldLink = null;

    /**
     * id field for the displayField table
     *
     * @var string
     * @access public
     */
	var $displayFieldValue = null;

    /*
     * Initialize the component
     *
     * Make the calling controller and it's primary model available.
     * Read the settings that will manage node naming variations
     * @param object $controller A reference to the instantiating controller object
     * @param array $settings The component settings
     * @return void
     * @access public
     */
    function initialize(&$controller, $settings=array()) {
        $this->controller = $controller;
        $this->model = &$controller->{$this->controller->modelClass};
        $this->data = &$controller->data;
        $this->_set($settings);
        $this->deduceDisplayField();
    }
    
//    function  __construct() {
//               $this->deduceDisplayField();
//
//        }

    /**
     * Provide the default logic for displayField handling
     * 
     * For the properties displayFieldModel, displayFieldField
     * and displayFieldLink that were not configured by the user
     * make default assumptions about their values.
     * 
     * Case 1: displayField is in the primary model
     * Case 2: displayField is in a linked model, this model contains the foreign id
     * 
     * dispayField might be in the form 'modelName.fieldName' or 'fieldName'
     *   - if modelName == primary model || missing
     *       displayFieldModel = primary model name
     *       displayFieldField = displayField 'fieldName'
     *   - if modelName != primary model
     *       displayFieldModel = displayField 'modelName'
     *       displayFieldField = displayField 'fieldName'
     *       displayFieldLink = 'modelName_id"
     *
     * If displayField isn't set in the Model, you probably won't be able
     * to get it set in time for the component init to see it,
     * so do the controllers component configuration.
     *
     * This routine will fill in any values not set in the configuration
     * 
     * @access private
     * @return void
     */
    function deduceDisplayField() {
        if (!isset($this->displayField)) {
            $this->displayField = $this->model->displayField;
        }
        //$display[3] = $this->displayField;
        $display = array_reverse(explode('.', $this->displayField));

        //  we now have $display[0] = field, $display[1] = model or unset
        $display[1] =
                (isset($display[1]))
                ? $display[1]
                : $this->model->alias;
        //  we now have $display[0] = field, $display[1] = model
        $display[2] =
                ($display[1] == $this->model->alias)
                ? FALSE
                : Inflector::underscore($display[1]) . '_id';
        //  we now have $display[0] = field, $display[1] = model, $display[2] = link field name or false
        $display[3] =
                ($display[2])
                ? $display[1].'.id'
                : $this->displayField;
        // now we know the source of actual data will be stored in the primary model as the 'name'
                
        $this->displayFieldField =
                ($this->displayFieldField == null)
                ? $display[0]
                : $this->displayFieldField;
        
        $this->displayFieldModel =
                ($this->displayFieldModel == null)
                ? $display[1]
                : $this->displayFieldModel;
        
        $this->displayFieldLink =
                ($this->displayFieldLink == null)
                ? $display[2]
                : $this->displayFieldLink;

        $this->displayFieldValue =
                ($this->displayFieldValue == null)
                ? $display[3]
                : $this->displayFieldValue;
        
    }

    function tree_crud() {

        $this->controller->set('model_name',$this->model->alias); // start assembling packet of data to return to controller
        $this->model->virtualFields = array (
            'indexed_name' => "CONCAT({$this->model->alias}.{$this->model->primaryKey}, \": \", {$this->displayField})"
        );

        if (isset($this->data)) {
            switch ($this->data[$this->model->alias]['action']) {
                case 'e': //New Element
                    $this->newTreeElement();
                    break;
                case 'r': //Remane Element
                    $this->renameTreeElement();
                    break;
                case 'd': //Delete Element
                    $this->deleteTreeElement();
                    break;
                case 'u': //Move Element Up
                    $this->moveUPTreeElement();
                    break;
                case 'w': //Move Element Down
                    $this->moveDownTreeElement();
                    break;
                case 'p': //New Parent for Element
                    $this->asignParentTreeElement();
                    break;
                case 'f': //Focus on Element
                    $this->focusTreeElement();
                    break;
                default :
                    $this->Session->setFlash('No action or unknown action was selected.');
            }
        //debug($_SESSION['Message']);
        }

        /**
         * The four field-targeted inputs to handle
         * Select a node
         * Select and existing node name
         * New node name
         * Select a parent node
         */
        $this->selectLists();
        $this->treeDisplay();

        // tuck away all the displayField properties for page assembly/function logic
        $this->data['displayField'] = array(
            'displayField' => $this->displayField,
            'model' => $this->displayFieldModel,
            'field' => $this->displayFieldField,
            'link' => $this->displayFieldLink,
            'displayValue' => $this->displayFieldValue
        );
        $this->data['primaryModel'] = $this->model->alias;

        // If the name field is in primaryModel, the two input choices for new/rename name
        // text input or select input will both point to the same field. To correct
        // this ambiguity, we'll detect this and assign a suffix to the field reference
        // in the form.
        if (!$this->displayFieldLink) {
            //true means local name field so direct and select name input go to the same field
            $this->data['displayField']['suffix'] = array('direct'=>'-d', 'select'=>'-s');
        } else {
            $this->data['displayField']['suffix'] = array('direct'=>'', 'select'=>'');
        }

        return $this->tree_crud; //the array with all the assembled lists in it
    }

        function selectLists() {
                /*
                 * Pull the ID => Name array for select lists
                 *
                 * First, the full, index-labeled list of nodes so the user can select one
                 */
                
		$parentList = $this->model->find('list', array(
                    'fields' => array($this->model->primaryKey, "indexed_name"),
                    'order'=>"{$this->model->alias}.lft desc",
                    'recursive' => 2));
                $parentList[0] = 'Root';
                $parentList[-1] = 'Select a parent node';
                $parentList = array_reverse($parentList, true);
                
                /*
                 * Next, pull distinct node aliases so the user can re-use a name if desired
                 */
                $selectList = $parentList;
                unset($selectList[0]);
                $selectList[-1] = 'Select a node';

                $distinctList = $this->model->find('list', array(
                    'fields' => array($this->displayFieldValue, $this->displayField),
                    'order'=> "{$this->model->displayField} desc",
                    'recursive' => 0));
                $distinctList[-1] = 'Select an existing node name';

                // this may be $distinctList[integer]=>string
                // or $distinctList[string]=>string
                // if string/string, dups will aready have compressed out
                // and flip is illegal on string keys
                if ($this->displayFieldValue != $this->displayField) {
                    $distinctList = array_flip(array_flip($distinctList));
                }
                
                $distinctList = array_reverse($distinctList, true);
                
                $this->data['treeCrudList'] = array(
                    'select' => $selectList,
                    'parent' => $parentList,
                    'distinct' => $distinctList
                );

}
                
        function treeDisplay($condition = array()) {
            $params = $this->controller->params;
                if (isset($params['named']['lft']) && isset($params['named']['rght'])) {
                    //result of a focus request
                    $condition = array("{$this->model->alias}.lft between {$params['named']['lft']} and {$params['named']['rght']}");
                }
                /*
                 * Pull the indented tree for the reference display
                 *
                 * generatetreelist requires stringified params
                 * and problems arise with local vs foreign displayFields
                 * For local the Model must be prepended,
                 * foreign already has the model
                 */
//                $displayModel = (!strstr($this->model->displayField, '.')) ? $this->model->alias . '.' : '';

            // example condition array('lft between 3 and 18') numbers are lft and rt of parent
                
		$formattedTree = $this->model->generatetreelist(
                        $condition,
                        "{n}.". $this->model->alias . "." . $this->model->primaryKey,
			//"{n}.$displayModel" . $this->model->displayField ,
			"{n}." . $this->model->alias . ".indexed_name" ,
			//"{n}.name" ,
                        '&nbsp;&nbsp;&nbsp;',
                        0);
                //debug($formattedTree);
		$this->controller->set('formatted_tree',$formattedTree); //$this->model->virtualFields;
                $this->data['treeCrudList']['tree'] = $formattedTree;
//		debug($formatted_tree);

                //foreach ($formatted_tree as $key => $value) {

        }

		/*
                 *  move delta select dropdown
                 * ******** TO DO ********
                 * each 'select' line should have its own appropriate
                 * Up and Down delta range. This requires a solid understanding
                 * of the tree nodes since range relates to siblings
                 */
//		$delta = array('-1' => 'No Move');
//		for ($i = 1; $i < count($formatted_tree)+1; $i++) {
//		    $delta[$i] = $i;
//		}
//		$tree_crud['data']['delta'] = $delta;
////                debug($delta);
//                return $tree_crud['data'];
                /*
                 * PARENT NODE STUDIES
                 * ********* TO DO ************
                 * This explores a method for generating the data
                 * needed to have tailored delta ranges.
                 * I was thinking about passing this array via json
                 * to the page javascript. 
                 */
//                $root_children = $this->model->children('',
//                        true,
//                        array('id', 'lft', 'rght'),
//                        "lft ASC");
//                $master = array();
//                //debug($root_children);
//                $sibling_count = count($root_children);
//                /*
//                 * This creates an array, index = id
//                 * elements identify max moves up, down and # of children
//                 */
//                foreach ($root_children as $index => $node) {
//                    $childcount = $this->model->childcount($root_children[$index][$this->model->alias]['id'],true);
//                    $master[$root_children[$index][$this->model->alias]['id']] = array (
//                        'up' => $index,
//                        'down' => $sibling_count - $index,
//                        'children' => $childcount,
//                        'lft' => $node[$this->model->alias]['lft'],
//                        'rght' => $node[$this->model->alias]['rght']
//                    );
//                }
//                debug($master);
//                debug(json_encode($master));
//                $parent = $this->model->getparentnode(1,'id');
//                $children = $this->model->children($parent[$this->model->alias]['id'], true);
                //debug($children);
//                debug($this->model->getparentnode(7,null,2));
      
        function newNameError($form) {
            if ($this->displayFieldLink) {
                // foreign name in use
                $directModel = $this->displayFieldModel;
                $directField = $this->displayFieldField."-$form";
                $selectModel = $this->model->alias;
                $selectField = $this->displayFieldLink."-$form";
                
                // while we're here, massage the data array for standard access
                $this->data[$directModel][$this->displayFieldField] = $this->data[$directModel][$directField];
                $this->data[$selectModel][$this->displayFieldLink] = $this->data[$selectModel][$selectField];
                
            } else {
                // local name in use
                $directModel = $this->model->alias;
                $directField = $this->displayFieldField."-d-$form";
                $selectModel = $this->model->alias;
                $selectField = $this->displayFieldField."-s-$form";
                
                // while we're here, massage the data array for standard access
                $this->data[$this->model->alias][$this->displayFieldField]= 
                        ($this->data[$selectModel][$selectField] != -1)
                        ? $this->data[$selectModel][$selectField]
                        : $this->data[$directModel][$directField];
            }
            $flashMessage = (
                    $this->data[$selectModel][$selectField] == -1 &&
                    $this->data[$directModel][$directField] == '') 
                    ? "Enter or select a name for your new element" : null;
            $flashMessage .= (
                    $this->data[$selectModel][$selectField] != -1 &&
                    $this->data[$directModel][$directField] != '')
                    ? "You've got the new name indicated in two ways. Please clarify" : null;

            return $flashMessage;
            
        }

        function newTreeElement() {
            $flashMessage = ($this->data[$this->model->alias]['parent_id'] == -1) ? "Select a parent for your new element. " : null;
            $flashMessage .= $this->newNameError('e');

            if (!$flashMessage) {
//                $this->setNodeParent($this->model,$this->data['New']['parent_id']);
		if ($this->data[$this->model->alias]['parent_id']==0){
                    unset($this->data[$this->model->alias]['parent_id']);
                }
                //debug($this->data);
                // had a bit of trouble when the foreign table didn't need work
                // so just a check and suppress it when it's not needed
                if (isset($this->displayFieldLink) && $this->data[$this->displayFieldModel][$this->displayFieldField] != '') {
                    $this->model->saveAll($this->data);
                } else {
                    $this->model->save($this->data[$this->model->alias]);
                }
            } else {
                $this->flashMessage($flashMessage,'new');
            }
	}

	function renameTreeElement() {
            $flashMessage = ($this->data[$this->model->alias]['id'] == -1) ? "Select a node to rename. " : null;
            $flashMessage .= $this->newNameError('r');

            if (!$flashMessage) {
                $this->model->id = $this->data[$this->model->alias]['id'];
                // had a bit of trouble when the foreign table didn't need work
                // so just a check and suppress it when it's not needed
                if (isset($this->displayFieldLink) && $this->data[$this->displayFieldModel][$this->displayFieldField] != '') {
                    $this->model->saveAll($this->data);
                } else {
                    $this->model->save($this->data[$this->model->alias]);
                }
                //$this->model->saveAll($this->data);
            } else {
                $this->flashMessage($flashMessage,'rename');
            }
	}

	function deleteTreeElement() {

            $flashMessage = ($this->data[$this->model->alias]['id'] == -1) ? "Select a node to delete. " : null;

            if (!$flashMessage) {
		$this->model->id = $this->data[$this->model->alias]['id'];
		$this->model->delete();
            } else {
                $this->flashMessage($flashMessage,'delete');
            }
	}

	function focusTreeElement() {

            $flashMessage = ($this->data[$this->model->alias]['id'] == -1) ? "Select a node to focus. " : null;

            if (!$flashMessage) {
		$this->model->id = $this->data[$this->model->alias]['id'];
		$this->model->read();
                //debug($this->model->data);
                $this->controller->redirect(array('action'=>"manage_tree/lft:{$this->model->data[$this->model->alias]['lft']}/rght:{$this->model->data[$this->model->alias]['rght']}"));
            } else {
                $this->flashMessage($flashMessage,'focus');
            }
	}

	function moveUpTreeElement() {
            $flashMessage = ($this->data[$this->model->alias]['id'] == -1) ? "Select a node to move. " : null;
            $flashMessage .= ($this->data[$this->model->alias]['delta'] < 1) ? "Enter a positive number of steps. " : null;

            if (!$flashMessage) {
                $this->model->id = $this->data[$this->model->alias]['id'];
                $this->model->moveup($this->model->id, intval($this->data[$this->model->alias]['delta']));
            } else {
                $this->flashMessage($flashMessage,'up');
            }
	}
        
	function moveDownTreeElement() {
            $flashMessage = ($this->data[$this->model->alias]['id'] == -1) ? "Select a node to move. " : null;
            $flashMessage .= ($this->data[$this->model->alias]['delta'] < 1) ? "Enter a positive number of steps. " : null;

            if (!$flashMessage) {
		$this->model->id = $this->data[$this->model->alias]['id'];
		$this->model->movedown($this->model->id, intval($this->data[$this->model->alias]['delta']));
            } else {
                $this->flashMessage($flashMessage,'down');
            }
	}

	function asignParentTreeElement() {
            $flashMessage = ($this->data[$this->model->alias]['id'] == -1) ? "Select a node to assign to a parent. " : null;
            $flashMessage .= ($this->data[$this->model->alias]['parent_id'] == -1  ? "Select a parent." : null);
            $flashMessage = ($this->data[$this->model->alias]['id'] == $this->data[$this->model->alias]['parent_id'] ?
                    "A node can't be its own parent" : $flashMessage);
            if (!$flashMessage) {
		$this->model->id = $this->data[$this->model->alias]['id'];
		if ($this->data[$this->model->alias]['parent_id']==0){
                    $this->data[$this->model->alias]['parent_id'] = null;
                }
		$this->model->save($this->data);
            } else {
                $this->flashMessage($flashMessage,'parent');
            }
	}

        function flashMessage($flashMessage,$name) {
            $this->Session->setFlash($flashMessage,'default',array(),$name);
        }

}
?>
