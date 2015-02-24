
<!-- Elements/WorkshopSessions/date_inputs.ctp -->
<table>
	<tbody>
		<tr>
			<td>

				<?php 
				echo $this->Form->input('Date.id');
				echo $this->Form->input('Date.date'); ?>

			</td>
			<td>

				<?php echo $this->Form->input('Date.start_time'); ?>

			</td>
			<td>

				<?php echo $this->Form->input('Date.end_time'); ?>

			</td>
		</tr>

	</tbody>
</table>
<!-- END Elements/WorkshopSessions/date_inputs.ctp END -->
