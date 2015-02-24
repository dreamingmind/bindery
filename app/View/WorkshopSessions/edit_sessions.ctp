<?php
echo $this->Html->css('workshop');
$t = 1;
echo tab($t++).'<ul>'.cr();
while ($sessions->valid()) {
	echo tab($t++).'<li class="prime">';
	echo cr().tab($t).$this->Html->para('', $sessions->current()->read('title')).'<b>◉</b>'.cr();
	echo tab($t++).'<ul>'.cr();
		echo tab($t).'<li>'.$this->Workshop->sessionSpecs($sessions).'</li>'.cr();
		while ($sessions->dates->valid()) {
			echo tab($t).'<li>'.$this->Workshop->dateSlug($sessions->dates).'</li>'.cr();
			$sessions->dates->next();
		}
	echo tab(--$t).'</ul>'.cr().tab(--$t).'</li>'.cr();
	$sessions->next();
}
echo tab(--$t).'</ul>'.cr();
