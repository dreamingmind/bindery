<?php

/**
 * Description of EditView
 *
 * @author dondrake
 */
class CartEditView extends View {

	protected $inner = FALSE;
	
	public function element($name, $data = array(), $options = array()) {
		if ($this->inner) {
			$data['record'] = $this->request->data;
		}
		if ($name === 'options_all' || $name === 'describe_project') {
			$this->inner = TRUE;
		} 
		return parent::element($name, $data, $options);
	}
}
