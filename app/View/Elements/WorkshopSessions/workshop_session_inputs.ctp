
<!-- Elements/WorkshopSessions/workshop_session_inputs.ctp -->
<?php 
echo $this->Form->inputs(array('WorkshopSession.id', 
	'WorkshopSession.title' => array(
		'after' => $this->Form->button('Standard')
	), 
	'WorkshopSession.cost', 
	'WorkshopSession.participants', 
	'WorkshopSession.first_day', 
	'WorkshopSession.last_day' => array(
		'after' => $this->Form->button('Same as first')
	), 
));
?>
<!-- END Elements/WorkshopSessions/workshop_session_inputs.ctp END -->
