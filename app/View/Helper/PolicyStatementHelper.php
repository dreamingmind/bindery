<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP PolicyHelper
 * @author dondrake
 */
class PolicyStatementHelper extends AppHelper {
	
	protected $scehdule_alert_span = '<span style="color: firebrick">Schedule alert: </span>';
	
	/**
	 * Number of days before vacation to start displaying notification
	 *
	 * @var int
	 */
	protected $advanced_vacation_notice = 21; 
	
	/**
	 * The Policy Model
	 *
	 * @var Model
	 */
	public $Policy;

// <editor-fold defaultstate="collapsed" desc="Callbacks">
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);
		$this->Policy = ClassRegistry::init('Policy');
	}

	public function beforeRender($viewFile) {
		
	}

	public function afterRender($viewFile) {
		
	}

	public function beforeLayout($viewLayout) {
		
	}

	public function afterLayout($viewLayout) {
		
	}

// </editor-fold>

	/**
	 * Get the policy statement for one policy
	 * 
	 * @param string $policy
	 * @return string
	 */
	public function statement($policy){
		$policy_record = $this->Policy->policyRecord($policy);
		return $this->renderOnePolicy($policy_record);
	}
	
	/**
	 * Given a parent policy name, render it and all descendent policies
	 * 
	 * @param string $policy
	 * @return string
	 */
	public function collection($policy){
		$collection = $this->Policy->collection($policy);
		if (empty($collection)) {
			return '';
		}
		return $this->parseCollection('', $collection);
	}
	
	/**
	 * Recursivlely assemble a collection of policy statements
	 * 
	 * @param string $statements The accumulated policy statements
	 * @param array $collection The array to parse
	 * @return string
	 */
	protected function parseCollection($statements, $collection) {
		
		if (isset($collection['policy'])) {
			return $this->renderOnePolicy($collection);
			
		} elseif (is_array($collection)) {
			foreach ($collection as $collection_children) {
				$statements .= $this->parseCollection($statements, $collection_children);	
			}
			
		}
		return $statements;
	}
	
	/**
	 * Look for special policy logic and choose a render strategy
	 * 
	 * @param array $policy_record
	 * @return string
	 */
	protected function renderOnePolicy($policy_record) {
		$method = $this->policyLogicHandlerName($policy_record['name']);
		
		if (method_exists($this, $method)) {
			return $this->$method($policy_record);
			
		} else {
			return $this->renderThisPolicy($policy_record); 
		}
	}
	
	/**
	 * Return a rendered policy string
	 * 
	 * @param array $policy_record
	 * @return string
	 */
	private function renderThisPolicy($policy_record) {
		return ($policy_record['policy_display'] != NEVER) ? $this->Markdown->transform($policy_record['policy']) : '';
	}

	/**
	 * Calculate the name of a policy logic method
	 * 
	 * The method may or may not actually exists. 
	 * But if it does, its name is derived from the policy name
	 * 
	 * @param string $policy_name
	 * @return string
	 */
	protected function policyLogicHandlerName($policy_name) {
		return Inflector::slug(Inflector::underscore($policy_name));
	}
	
	/**
	 * Special holiday policy logic
	 * 
	 * @param array $policy_record
	 * @return string
	 */
	private function holiday_orders($policy_record) {
		$month = date('n', time());
		if ($month == '11' || $month == '12') {
		return $this->Markdown->transform($this->renderThisPolicy($policy_record));
		} else {
			return '';
		}
	}
	
	public function vacation($dates) {
		$vacation_notice = FALSE;
		
		foreach ($dates as $vacation) {
			$start = strtotime($vacation[0]);
			$end = strtotime($vacation[1]);
			$name = $vacation[2];
			$today = time();
			if ( ($today + ($this->advanced_vacation_notice * DAY)) >= $start && $today <= $end ) {
				$vacation_notice .= $this->vacationNotice($vacation[0], $vacation[1], $vacation[2]);
			}
		}
		
		if ($vacation_notice) {
			return $this->Markdown->transform($this->scehdule_alert_span . "\n\n" . $vacation_notice);
		} else {
			return '';
		}
	}
	
	public function allVacations($dates) {
		$vacation_notice = FALSE;
		
		foreach ($dates as $vacation) {
			$start = strtotime($vacation[0]);
			$end = strtotime($vacation[1]);
			$name = $vacation[2];
			$today = time();

			if ($today < $end) {
				$vacation_notice .= $this->vacationNotice($vacation[0], $vacation[1], $vacation[2]);
			}			
		}
		
		if ($vacation_notice) {
			return $this->Markdown->transform($this->scehdule_alert_span . "\n\n" . $vacation_notice);
		} else {
			return '';
		}
	}
	
	
	protected function vacationNotice($start, $end, $name) {
		return "- $name: $start - $end\n";
	}

}
