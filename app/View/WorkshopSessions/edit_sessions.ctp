<!-- WorkshopSessions/edit_sessions.ctp -->
	<?php
	echo $this->Html->tag('article', 
			cr().$this->Html->tag('h2', $feature['Workshop']['heading']).cr()
			.tab(1).$this->Markdown->transform($feature['ContentCollection'][0]['Content']['content']).cr());
	
	echo $this->element('WorkshopSessions/session_form');
	echo $this->element('WorkshopSessions/calendar');

	echo $this->element('WorkshopSessions/session_list');
dmDebug::ddd($feature, 'feature');
?>
<!-- END WorkshopSessions/edit_sessions.ctp END -->
