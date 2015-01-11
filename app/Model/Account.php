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
 * Account Model
 * 
 * Alias for the User Model.
 * 
 * Provides a Cake-y way of having URL's point to /account/method
 * rather than /user/method. Just a little more friendly.
 * 
 * @package       bindery
 * @subpackage    bindery.User
 * @todo figure out why this is separate from User
 */
class Account extends AppModel {
    var $name = 'Account';
    var $useTable = 'users';
	var $hasMany = array(
		'OptinUser',
		'WishList' => array(
			'className' => 'OrderItem',
			'foreignKey' => 'user_id',
			'conditions' => "WishList.state = 'Wish'"
		));
}
?>
