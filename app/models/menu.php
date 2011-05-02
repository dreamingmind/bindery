<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 *
 * @copyright     Copyright 2010, Dreaming Mind (http://dreamingmind.org)
 * @link          http://dreamingmind.com
 * @package       bindery
 * @subpackage    bindery.model
 */
class Menu extends AppModel {
var $name = 'Menu';
var $useTable = false;
function main ($selected = 'home') {
return array(
	'divClass' => 'menu',
	'ulClass' => 'menu',
	'tabs' => array(
		array(
			'controller' => 'dispatch',
			'action' => 'index',
			'params' => '',
			'aClass' => $selected == 'dispatch' ? 'selected' : '',
			'liClass' => '',
			'text' => 'Dispatch'
		),
		array(
			'controller' => 'gallery',
			'action' => 'index',
			'params' => '',
			'aClass' => $selected == 'gallery' ? 'selected' : '',
			'liClass' => '',
			'text' => 'Gallery'
	),
		array(
			'controller' => 'dispatch_gallery',
			'action' => 'index',
			'params' => '',
			'aClass' => $selected == 'dispatch_gallery' ? 'selected' : '',
			'liClass' => '',
			'text' => 'Gallery'
),
	)
);
}
function admin ($selected = 'clients') {
	return array(
	'divClass' => 'submenu',
	'ulClass' => 'submenu',
	'tabs' => array(
		array(
			'controller' => 'clients',
			'action' => 'index',
			'params' => '',
			'aClass' => $selected == 'clients' ? 'selected' : '',
			'liClass' => '',
			'text' => 'Clients'
		),
		array(
			'controller' => 'groups',
			'action' => 'index',
			'params' => '',
			'aClass' => $selected == 'groups' ? 'selected' : '',
			'liClass' => '',
			'text' => 'Groups'
		)
		)
	);
}
}
?>