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
 * DispatchGalleriesController
 * 
 * System that links Dispatches to their organizing Galleries
 * @package       bindery
 * @subpackage    bindery.controller
 */
class DispatchGalleriesController extends AppController {
	var $name = 'DispatchGalleries';
	//var $scaffold;
        
        function add() {
            if (!empty($this->data)) {
//                debug($this->data); die;
                if ($this->DispatchGallery->saveAll($this->data)) {
                    $this->Session->setFlash('successful');
                } else {
                    $this->Session->setFlash('failure');
                }
            }
        }
        
	}
?>