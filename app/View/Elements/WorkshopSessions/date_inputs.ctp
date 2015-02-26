<?php 
$this->start('scripts');
echo $this->Html->script('bootstrap-datetimepicker');
echo $this->Html->css('bootstrap-datetimepicker');
echo $this->Html->css('bootstrap-');
echo $this->Html->css('bootstrap-theme');
$this->end();
?>
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
				<?php // echo $this->Form->input('Date.start_time', array('type' => 'text')); ?>
				<div class="input-append date form_datetime" data-date="2012-12-21T15:25:00Z">
				<input size="16" type="text" value="" readonly>
				<span class="add-on"><i class="icon-remove"></i></span>
				<span class="add-on"><i class="icon-th"></i></span>
				</div>
			</td>
			<td>
				<?php // echo $this->Form->input('Date.end_time', array('type' => 'text')); ?>
				<input type="text" id="mirror_field" value="" readonly />
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
     
    <script type="text/javascript">
    $(".form_datetime").datetimepicker({
    format: "dd MM yyyy - hh:ii",
    linkField: "mirror_field",
    linkFormat: "yyyy-mm-dd hh:ii"
    });
    </script> 