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

	/**
	 * Output date and times from the iterators current()
	 * 
	 * Nov 27 2011, 10:00AM - 3:30PM 
	 * 
	 * @param ArrayIterator $date 
	 * @return type
	 */
	public function dateSlug(ArrayIterator $date) {
		$format = '<p class="day"><time datetime="%s"><span class="day">%s</span> - %s</time><span class="%s"> %s</span> - %s<span class="%s"> %s</span></p>';
		return sprintf($format,
				$date->seconds('start'),
				$date->day('start'), "{$date->date('start')}, {$date->oClock('start')}", $date->amPm('start', FALSE), $date->amPm('start', TRUE),
				$date->oClock('end'), $date->amPm('end', FALSE), $date->amPm('end', TRUE));
	}
	
	public function sessionSpecs(ArrayIterator $session) {
		$student_label = $session->current()->read('participants') > 1 ? 'students' : 'student';
		$format = "<p><span class=\"cost\">$%s</span>, %s hours, %s $student_label</p>";
		return sprintf($format,
				$session->current()->read('cost'),
				$session->dates->duration(),
				$session->current()->read('participants'));
	}
}
