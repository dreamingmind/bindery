<!-- WorkshopSessions/edit_sessions.ctp -->
	<?php
	$this->start('css');
	echo $this->Html->css('edit_session');
	$this->end();
	
	$this->start('scripts');
	echo $this->Html->script('CoreObjects/page_manager');
	echo $this->Html->script('ws');
	echo $this->Html->script('Mediators/session_data_provider');
	
	echo $this->Html->script('Mediators/data_table');
	$this->end();
	
	echo $this->Html->tag('article', 
			cr().$this->Html->tag('h2', $feature['Workshop']['heading']).cr()
			.tab(1).$this->Markdown->transform($feature['ContentCollection'][0]['Content']['content']).cr());
	
	echo $this->element('WorkshopSessions/session_form');
	echo $this->element('WorkshopSessions/calendar');

	echo $this->element('WorkshopSessions/session_list');
//dmDebug::ddd($feature, 'feature');
?>
<!-- END WorkshopSessions/edit_sessions.ctp END -->
