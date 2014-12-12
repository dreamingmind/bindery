<?php

/**
 * CartEditView injects data into normally empty element form inputs
 * 
 * Let's the elements do double duty with changing them or loading them with logic. 
 * The View extension is brought on-line only during rendering of Custom or Generic 
 * product forms when existing data will populate those forms. 
 * During cart-item editing or pre-spec'd product pruchasing
 *
 * @author dondrake
 */
class CartEditView extends View {

	/**
	 * Whether we've entered an element that needs data injection
	 * 
	 * There are two wrapper elements, one for Custom and one for Generic prodcuts. 
	 * Inside of each, elements are called that require trd to be sent in as $record 
	 * for proper value population. This boolean tracks when we've entered these interiors.
	 * 
	 * @var boolean
	 */
	protected $inner = FALSE;
	
	/**
	 * Are we editing a cart item or purchasing a pre-spec'd product
	 * 
	 * In either case we'll need to poplulate the form. But the form submission 
	 * button will need to trigger different processes
	 * -----------------------
	 * is that true? can't the presence/absence of the ID field value decide?
	 *
	 * @var string
	 */
	protected $action;


	/**
	 * Conditionally send addtional data to form elements
	 * 
	 * Custom and Generic product forms are made up of elements that normally have 
	 * valuless inputs, allowing the user to specify and purchase the products. 
	 * This override element() method allows those elements to recieve data. This 
	 * allows all the elements to be re-used for cart-item editing and for the 
	 * refinement and purchase of pre-spec'd products without duplicating or 
	 * modifying the existing elements.
	 * 
	 * @param string $name See View->element for descriptions of all params
	 * @param array $data
	 * @param array $options
	 * @return string
	 */
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
