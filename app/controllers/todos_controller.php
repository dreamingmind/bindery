<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.controller
 */
class TodosController extends AppController {

	var $name = 'Todos';
        var $components = array('TreeCrud');
        var $helpers = array('TreeCrud');

        function beforeFilter() {
            $this->Auth->allow('*');
            parent::beforeFilter();
	}

        function manage_tree() {
                $this->TreeCrud->tree_crud();
        }

        function fix() {
            $this->Todo->recover('tree');
            $this->redirect(array('controller'=>'todos', 'action'=>'manage_tree'));
        }

        function index() {
            
        }
        
}
?>