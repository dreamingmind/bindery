<?php
$toolkit = $cart['toolkit'];
$interest = $because = FALSE;

//if ($toolkit->itemCount() > 1) {
//	$interest = "these {$toolkit->itemCount()} items";
//} else {
//	$interest = 'this item';
//	$because = 'it';
//}
//
//if (!$because) {
//	if ($toolkit->itemCount() == $toolkit->zeroCount()) {
//		$because = 'these items';
//	} else {
//		$because = "{$toolkit->zeroCount()} of them";
//	}
//}

?>

<p><?php echo $toolkit->customerName(); ?>,</p>
<br />
<p>
	Thank you for your order. 
</p>
<?php echo $this->PolicyStatement->statement('Paying by check')?>
<!--<p>
	<span style="color: firebrick;">Action required: </span>I will begin work after I receive your payment by check or a 50% deposit.
</p>-->
<p>
	Please contact me if you have other questions or additional thoughts on your project.
</p>
<address class="signature">	
<p>
	Best regards,
</p>
<pre>
<?php echo $company['fullSignature']; ?>
</pre>
<br />
</address>
<h1>Ordered with payment pending by check</h1>
