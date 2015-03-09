
<!-- Elements/WorkshopSessions/session_form.ctp -->
<?php
$t = 0;
echo cr().tab($t++).$this->Form->create('WorkshopSessions', array('action' => 'edit_sessions')).cr();

echo tab($t).$this->Html->tag('fieldset', $this->element('WorkshopSessions/workshop_session_inputs'), array('id' => 'workshop')).cr();
?>
<table class='session_dates'>
	<tbody>
		<?php // echo tab(2).$this->element('WorkshopSessions/date_inputs').cr(); ?>
		<tr id="control">
			<td colspan='4'>
				<?php echo $this->Form->button('New date', array('id' => 'new', 'type' => 'button')); ?>
			</td>
		</tr>
	</tbody>
</table>

<?php
echo tab(--$t).$this->Form->end().cr();
?>
<!-- END Elements/WorkshopSessions/session_form.ctp END -->
