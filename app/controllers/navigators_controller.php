<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
/**
 * Functions related to Navigator Model, the nested tree that is the main site navigation menu source
 * 
 * Included here are all the basic data access and simple CRUD functions as well
 * as the CRUD functions for managing the Navigator model as a Tree. Data access
 * for the actual menus will be found in the Menu Controller. Also, Navline contains
 * the display text for the navigator entries because the specific displayed text
 * may appear more than once in the generated menu
 */
class NavigatorsController extends AppController {

	var $name = 'Navigators';
	//var $helpers = array('Html', 'Form', 'Session');
        //var $uses = array('Navigator', 'Navline');
        var $components = array('TreeCrud');
        var $helpers = array(
            'TreeCrud'
        );

        /**
         * Sets variables and objects required by the Navigator index view
         * 
         * The array of Navigator/Navline records for the current page (default 20/page)
         * is available as $navigators. $paginator will contain the paginator object
         */

	function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allowedActions = array('*');
	}

        function index() {
		$this->Navigator->recursive = 0;
		$this->set('navigators', $this->paginate());
	}

        /**
         * Sets variables required by the Navigator 'view' view
         * or redirects to the index view if no id is provided
         * 
         * $navigator will be contain an array of the requested Navigator record
         * and related data from Navline
         *
         * @param integer $id Id of the requested Navigator record
         */
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Navigator.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('navigator', $this->Navigator->read(null, $id));
	}

        /**
         * Save the posted data array
         *
         * If $_POST['data'] is not empty, attempt to save it.
         * Success redirects to 'index' view with a success message. Failure displays
         * a failure message on the current page ('new' view).
         * If $_POST['data'] is empty the save fails, a Navline list is constructed for the
         * related record drop-down list
         */
	function add() {
		if (!empty($this->data)) {
			$this->Navigator->create();
			if ($this->Navigator->save($this->data)) {
				$this->Session->setFlash(__('The Navigator has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Navigator could not be saved. Please, try again.', true));
			}
		}
		$navlines = $this->Navigator->Navline->find('list');
		$this->set(compact('navlines'));
	}

        /**
         * Set all the variables needed for the Navigator 'edit' view
         * 
         * If there is no id provided and no data array, set an 
         * error message and redirect to 'index' view.
         * 
         * If there is a data array try to save it. Success sets a message
         * and redirect to 'index' view. Failure sets a message and stays in 'edit' view
         * 
         * If data arra is empty (and id is provided), read the Navigator record
         *
         * Construct the Navline drop list
         * 
         * @param <type> $id Id of the Navigator record to edit
         */
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Navigator', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Navigator->save($this->data)) {
				$this->Session->setFlash(__('The Navigator has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Navigator could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Navigator->read(null, $id);
		}
		$navlines = $this->Navigator->Navline->find('list');
		$this->set(compact('navlines'));
	}

        /**
         * Delete the indicated Navigator record
         *
         * If no id is provided set an error message and redirect to 'index' action.
         * Otherwise, delete the record set success message and redirect to 'index' action
         *
         * @param <type> $id Id of the Navigator record to delete
         */
	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Navigator', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Navigator->delete($id)) {
			$this->Session->setFlash(__('Navigator deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

        function fix() {
            $this->Navigator->recover('tree');
            $this->redirect(array('controller'=>'navigators', 'action'=>'manage_tree'));
        }
        /**
         * Set values for the view and call for processing of data posted from the view
         *
         * # $lineNames - array of existing tree elements for use in select inputs
         *                with empty element 0 unshifted onto the begining
         * # $names - array of possible names if the tree draws names from a related file
         *            with empty element 0 unshifted onto the begining
         * # $foreign_name - automatically sets to true based on $displayField if you're using
         *                   a related file to hold a pool of element names. This controls
         *                   creation of form components in the view
         * # $displayField - ModelName.fieldName version of $this->Model->displayField
         *
         * @param int $id Id of the record to edit
         */

	function manage_tree($id=null) {
            $options = $this->User->Group->find('list');
            $this->set('options',$options);
            $this->set('treecrud_data',$this->TreeCrud->tree_crud($this->{$this->modelClass}));
	}


}