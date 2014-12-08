<?php
$product = ucwords(str_replace('-', ' ', $this->request->params['pname']));
$legend = $product . ' Project Description';
$model = $this->request->params['pname'];
$record = array($model => array(
	'project_name' => 'my totally custom project',
	'time_frame' => '2nd week of January 2015',
	'budget' => '$600',
	'project_description' => 'This is the lengthy description of the project'
));

echo $this->Html->tag('h2', $product, array('class' => 'checkout'));

echo $this->Form->create($model);
echo $this->element('options_project_description', array('legend' => $legend, 'record' => $record, 'model' => $model));
echo $this->Form->input('generic', array('type' => 'hidden', 'value' => 'generic', 'name' => 'data[generic]'));
echo $this->element('Cart/product_purchase_button');
echo $this->Form->end();
//echo $this->element('options_page_count');

//dmDebug::ddd($tableSet, '$tableSet');
//dmDebug::ddd($this->request->params, 'params');