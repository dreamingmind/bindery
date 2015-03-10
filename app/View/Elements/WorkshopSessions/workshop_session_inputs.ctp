<?php 
$this->start('scripts');
echo $this->Html->script('Mediators/date_range');
$this->end();
?>

<!-- Elements/WorkshopSessions/workshop_session_inputs.ctp -->
<?php 
echo $this->Form->inputs(array('WorkshopSession.id', 
	'WorkshopSession.title' => array(
		'after' => $this->Form->button('Standard', array('id' => 'standard_title'))
	), 
	'WorkshopSession.cost', 
	'WorkshopSession.participants', 
	'WorkshopSession.first_day' => array(
		'type' => 'text', 
		'class' => 'cal-widget'), 
	'WorkshopSession.last_day' => array(
		'type' => 'text',
		'class' => 'cal-widget',
		'after' => $this->Form->button('One day', array('id' => 'one_day'))
	),
	'fieldset' => FALSE
));
echo $this->Form->Html->div(null,'', array('id' => 'day_pattern'));
//echo $this->Form->select('day_pattern', array('Sun','Mon','Tue','Wed','Thu','Fri','Sat'), array('multiple' => 'checkbox'));
?>
<!-- END Elements/WorkshopSessions/workshop_session_inputs.ctp END -->
