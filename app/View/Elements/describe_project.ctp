<?php
if (is_a($this, 'CartEditView')) {
	$p = array_keys($this->request->data);
	$this->request->params['pname'] = $p[0];
}
$product = ucwords(str_replace('-', ' ', $this->request->params['pname']));
$legend = $product . ' Project Description';
$model = $this->request->params['pname'];
$record = false;
//$record = array($model => array(
//	'project_name' => 'my totally custom project',
//	'time_frame' => '2nd week of January 2015',
//	'budget' => '$600',
//	'project_description' => 'This is the lengthy description of the project'
//));

echo $this->Html->tag('h2', $product, array('class' => 'checkout'));

echo $this->Form->create($model);
echo $this->element('email', array('model' => $model));
echo $this->Cart->cartItemIdInput(); // concrete helpers decides what the CartItem id is (NULL or something)
echo $this->element('options_project_description', array('legend' => $legend, 'record' => $record, 'model' => $model));
echo $this->Form->input('generic', array('type' => 'hidden', 'value' => 'generic', 'name' => 'data[generic]'));
echo $this->Form->input('edit_path', array('type' => 'hidden', 'value' => $product_group, 'name' => 'data[edit_path]'));
echo $this->element('Cart/product_purchase_button');
echo $this->Form->end();
//echo $this->element('options_page_count');

//dmDebug::ddd($tableSet, '$tableSet');
//dmDebug::ddd($this->request->params, 'params');