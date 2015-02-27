
<!-- Elements/WorkshopSessions/workshop_session_inputs.ctp -->
<?php 
echo $this->Form->inputs(array('WorkshopSession.id', 
	'WorkshopSession.title' => array(
		'after' => $this->Form->button('Standard')
	), 
	'WorkshopSession.cost', 
	'WorkshopSession.participants', 
	'WorkshopSession.first_day' => array(
		'type' => 'text', 
		'div' => array('class' => 'cal-widget')), 
	'WorkshopSession.last_day' => array(
		'type' => 'text',
		'div' => array('class' => 'cal-widget'),
		'after' => $this->Form->button('One day')
	), 
));
?>
<!-- END Elements/WorkshopSessions/workshop_session_inputs.ctp END -->
