<?php
$product = ucwords(str_replace('-', ' ', $this->request->params['pname']));
$legend = $product . ' Project Description';
$record = array('Option' => array(
	'project_name' => 'my totally custom project',
	'time_frame' => '2nd week of January 2015',
	'budget' => '$600',
	'project_description' => 'This is the lengthy description of the project'
));


echo $this->Html->tag('h2', $product, array('class' => 'checkout'));

echo $this->element('options_project_description', array('legend' => $legend, 'record' => $record));
//echo $this->element('options_page_count');

//dmDebug::ddd($tableSet, '$tableSet');
//dmDebug::ddd($this->request->params, 'params');