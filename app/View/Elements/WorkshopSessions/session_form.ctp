
<!-- Elements/WorkshopSessions/session_form.ctp -->
<?php
$t = 0;
echo cr().tab($t++).$this->Form->create('WorkshopSessions', array('action' => 'edit_sessions')).cr();

echo tab($t).$this->element('WorkshopSessions/workshop_session_inputs').cr();

echo tab(--$t).$this->Form->end().cr();
?>
<!-- END Elements/WorkshopSessions/session_form.ctp END -->
