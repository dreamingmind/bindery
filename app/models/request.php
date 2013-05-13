<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.User
 */
/**
 * Request Model
 * 
 * Requests manages storage of data submitted by visitors through provided forms
 * on the Workshop landing page. The requests are Workshop date requests.
 * 
 * @package       bindery
 * @subpackage    bindery.User
 * @todo Can this module be generalized to store other user interaction data?
 * 
*/
class Request extends AppModel {
	var $name = 'Request';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Workshop' => array(
			'className' => 'Workshop',
			'foreignKey' => 'workshop_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>