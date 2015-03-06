<?php 
$this->start('scripts');
echo $this->Html->script('Mediators/date_range');
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
		'class' => 'cal-widget'), 
	'WorkshopSession.last_day' => array(
		'type' => 'text',
		'class' => 'cal-widget',
		'after' => $this->Form->button('One day', array('class' => 'one_day'))
	),
	'fieldset' => FALSE
));
?>
<table class='session_dates'>
	<tbody>
		<?php // echo tab(2).$this->element('WorkshopSessions/date_inputs').cr(); ?>
		<tr class="control">
			<td colspan='4'>
				<?php echo $this->Form->button('New date', array('class' => 'new', 'type' => 'button')); ?>
			</td>
		</tr>
	</tbody>
</table>
<!-- END Elements/WorkshopSessions/workshop_session_inputs.ctp END -->
