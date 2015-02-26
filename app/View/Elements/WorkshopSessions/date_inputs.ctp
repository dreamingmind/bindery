
<!-- Elements/WorkshopSessions/date_inputs.ctp -->
<table>
	<tbody>
		<tr>
			<td>
				<?php 
				echo $this->Form->input('Date.id');
				echo $this->Form->input('Date.date', array('type' => 'text')); ?>
			</td>
			<td>
				<?php echo $this->Form->input('Date.start_time', array('type' => 'text')); ?>
			</td>
			<td>
				<?php echo $this->Form->input('Date.end_time', array('type' => 'text')); ?>
			</td>
			<td>
				<?php echo $this->Form->button('Remove'); ?>
			</td>
		</tr>
		<tr>
			<td colspan='4'>
				<?php echo $this->Form->button('New'); ?>
			</td>
		</tr>
	</tbody>
</table>
<!-- END Elements/WorkshopSessions/date_inputs.ctp END -->
