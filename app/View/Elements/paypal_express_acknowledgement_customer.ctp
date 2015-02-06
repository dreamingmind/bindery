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
<p>
	You paid with Paypal, so you should receive an email from them confirming your payment.
</p>
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
<h1>Ordered paid through Paypal</h1>
