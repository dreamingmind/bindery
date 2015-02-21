<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP WorkshopHelper
 * @author dondrake
 */
class WorkshopHelper extends AppHelper {

	public $helpers = array();

	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
	}

	public function beforeRender($viewFile) {
		parent::beforeRender($viewFile);
	}

	public function afterRender($viewFile) {
		parent::afterRender($viewFile);
	}

	public function beforeLayout($viewLayout) {
		parent::beforeLayout($viewLayout);
	}

	public function afterLayout($viewLayout) {
		parent::afterLayout($viewLayout);
	}

	public function functionName($param) {
		
	}
}
