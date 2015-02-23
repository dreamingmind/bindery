<?php
while ($sessions->valid()) {
	
	echo NEWLINE.TAB.$this->Html->para('', $sessions->current()->read('title')).NEWLINE;
	echo TAB.TAB.'<ul>'.NEWLINE;
	
	while ($sessions->dates->valid()) {
		
		echo TAB.TAB.TAB.$this->Workshop->dateSlug($sessions->dates).NEWLINE;
		
		$sessions->dates->next();
	}
	
	echo TAB.TAB.'</ul>'.NEWLINE;
	
	$sessions->next();
	
}
