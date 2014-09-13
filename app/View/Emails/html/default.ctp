<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<?php
App::uses('User', 'Model');
	echo '<p><b>After 10:30 version</b></p>';
//	echo '<p><b>This is the result of a model, instantiated in the view and performing a query.</b></p>';
//	$this->User = new User();
//	debug($this->User->find('first', array(
//		'conditions' => array('id' => '3'),
//		'contain' => false
//	)));
//debug($data);
//foreach ($messages as $key => $object) {
//	if (preg_match('/\d{4}-[A-Z]{4}/', $key)) {
//		echo '<p><b>Status Change</b></p>';
//		echo $this->element('Email/submitted', array('data' => $object->data()));
//	} elseif (preg_match('/I\d+/', $key)) {
////		debug($key);
////		debug($object);
//		echo '<p><b>Low Inventory</b></p>';
//		echo $this->element('Email/lowInventory', array('data' => $object->data()));
//	}
	
//	$object->output();
//}
//$content = explode("\n", $content);
//
//foreach ($content as $line):
//	echo '<p> ' . $line . "</p>\n";
//endforeach;
?>