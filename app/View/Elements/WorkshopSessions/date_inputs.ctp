<?php 
$this->start('scripts');
$this->end();
?>
<!-- Elements/WorkshopSessions/date_inputs.ctp -->
		<tr>
			<td class="cal-widget">
				
			</td>
			<td>
				<?php 
				echo $this->Form->input('Date.id');
				echo $this->Form->input('Date.date', array('type' => 'text')); ?>
				<p class='duration'></p>
			</td>
			<td>
				<?php echo $this->Form->input('Date.start_time', array('type' => 'text', 'div' => FALSE)); ?>
					<input class="start_slide" type="range" min="0" max="38" step="1" value="1" />
				</div>
			</td>
			<td>
				<?php echo $this->Form->input('Date.end_time', array('type' => 'text', 'div' => FALSE)); ?>
					<input class="end_slide" type="range" min="4" max="42" step="1" value="12" />
				</div>
			</td>
			<td>
				<?php echo $this->Form->button('Remove'); ?>
			</td>
		</tr>
<!-- END Elements/WorkshopSessions/date_inputs.ctp END -->
