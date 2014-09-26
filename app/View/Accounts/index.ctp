<div>
<?php
//debug($this->request->data);

$record = "";

foreach ($fields as $field) {
    $record .= $this->Html->tableCells(array($field[0], $this->request->data['User'][$field[1]]));
}
$this->Html->output("<table>\n$record</table>\n");

?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit'), array('action' => 'edit'));?></li>
	</ul>
<h4>You have chosen the following email and notification options</h4>
    <ul>
        <?php
        foreach($this->request->data['OptinUser'] as $val) {
            echo '<li>'. $val['Optin']['label']. '</li>';
        }
        ?>
    </ul>
    <p><?php echo $this->Html->link(__('Change these options'), array('action'=>'opt_in')); ?></p>
</div>


