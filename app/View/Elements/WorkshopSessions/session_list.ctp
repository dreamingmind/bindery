<!-- Elements/WorkshopSessions/session_list.ctp -->
	<?php
$t = 1;
echo $this->Html->css('workshop');

$collection_id = 'session_data_provider-' . ($sessions->valid() ? $sessions->current()->read('collection_id') : '');
echo tab($t++)."<ul id=\"$collection_id\">".cr();
while ($sessions->valid()) {
	$session_id = 'session_id-' . $sessions->current()->read('id');
	echo tab($t++)."<li id=\"$session_id\" class=\"prime\">";
	echo cr().tab($t).$this->Html->para('', $sessions->current()->read('title')).'<b>◉</b>'.cr();
	echo tab($t++).'<ul>'.cr();
		echo tab($t).'<li>'.$this->Workshop->sessionSpecs($sessions).'</li>'.cr();
		while ($sessions->dates->valid()) {
			$date_id = 'date_id-' . $sessions->dates->current()->read('id');
			echo tab($t)."<li id=\"$date_id\">".$this->Workshop->dateSlug($sessions->dates).'</li>'.cr();
			$sessions->dates->next();
		}
	echo tab(--$t).'</ul>'.cr().tab(--$t).'</li>'.cr();
	$sessions->next();
}
echo tab(--$t).'</ul>'.cr();
?>
<!-- END Elements/WorkshopSessions/session_list.ctp END -->
