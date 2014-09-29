<?php
echo $this->Html->image('transparent.png', array('height' => '100px'));
//echo $this->Html->nestedList($out);
foreach ($out as $label =>$group){
	
	echo "<ul>"
		. "<li id=\"$label\" class=\"toggle\"> $label"
			. "<ul class=\"$label hide\">";
	
	foreach ($group as $index => $path) {
		$elements = explode('/', $path);
	//	debug($elements);
		$c = array_chunk($elements, 8);
	//	debug($c);
		$s = implode('-', $c[1]);
		echo '<ul>';
		echo $this->Html->tag('li', $this->Html->link(array_pop($elements), array('action' => 'read', $s)));
		echo '</ul>';
	}
	echo '</ul></li></ul>';
}