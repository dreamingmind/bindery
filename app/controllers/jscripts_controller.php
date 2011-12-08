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
 * JscriptsController
 */
class JscriptsController extends AppController {

	var $name = 'Jscripts';
	var $helpers = array('Js');
        function viewActive() {
            $this->set('title_for_layout', 'Jquery Tutorial Workpage');
            $this->layout = 'javascript';
        }
        
        function tutorial() {
            //$this->viewActive();
            $this->set('title_for_layout', 'Jquery Tutorial Workpage');
            $this->layout = 'javascript';
        }

}
?>