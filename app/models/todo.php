<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.model
 */
/**
 * ToDo Model
 * 
 * @package       bindery
 * @subpackage    bindery.model
 */
class Todo extends AppModel {

	var $name = 'Todo';
	var $actsAs = array('GroupTree');
        var $displayField = 'Todo.alias';

        function parentNode() {
            return null;
        }

}
?>