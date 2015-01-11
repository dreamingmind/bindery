<div>
	<p>Where can I show the user's past orders? They are on the Design/Order page...</p>
<?php
//debug($this->request->data);

$record = "";

foreach ($fields as $field) {
//	dmDebug::ddd($field, 'fields');
	if (isset($this->request->data['User'][$field[1]])) {
		$record .= $this->Html->tableCells(array($field[0], $this->request->data['User'][$field[1]]));
	}	
}
$this->Html->output("<table>\n$record</table>\n");

?>
</div>
<!--<div class="actions">-->
<div>
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
<?php
	foreach($this->request->data['WishList'] as $wish) {
		echo $this->element('Cart/wishlist', array('item' => array('CartItem' => $wish)));
	}
?>
</div>

