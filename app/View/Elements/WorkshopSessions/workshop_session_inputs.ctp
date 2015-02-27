<?php 
$this->start('scripts');
echo $this->Html->script('Mediators/workshop_session');
$this->end();
?>

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
		'after' => $this->Form->button('One day', array('class' => 'one_day'))
	), 
));
?>
<table class='session_dates'>
	<tbody>
		<?php echo tab(2).$this->element('WorkshopSessions/date_inputs').cr(); ?>
		<tr>
			<td colspan='5'>
				<?php echo $this->Form->button('New date', array('class' => 'new_date')); ?>
			</td>
		</tr>
	</tbody>
</table>
<!-- END Elements/WorkshopSessions/workshop_session_inputs.ctp END -->
