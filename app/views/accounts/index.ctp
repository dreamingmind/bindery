<div>
<?php
//debug($this->data);

$record = "";

foreach ($fields as $field) {
    $record .= $this->Html->tableCells(array($field[0], $this->data['User'][$field[1]]));
}
AppHelper::output("<table>\n$record</table>\n");

?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit', true), array('action' => 'edit'));?></li>
	</ul>
<h4>You have chosen the following email and notification options</h4>
    <ul>
        <?php
        foreach($this->data['OptinUser'] as $val) {
            echo '<li>'. $val['Optin']['label']. '</li>';
        }
        ?>
    </ul>
    <p><?php echo $html->link(__('Change these options', true), array('action'=>'opt_in')); ?></p>
</div>


