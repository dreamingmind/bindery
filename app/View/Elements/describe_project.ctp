<?php
$product = ucwords(str_replace('-', ' ', $this->request->params['pname']));
$legend = $product . ' Project Description';

echo $this->Html->tag('h2', $product, array('class' => 'checkout'));

echo $this->element('options_project_description', array('legend' => $legend));
//echo $this->element('options_page_count');

dmDebug::ddd($tableSet, '$tableSet');
dmDebug::ddd($this->request->params, 'params');
