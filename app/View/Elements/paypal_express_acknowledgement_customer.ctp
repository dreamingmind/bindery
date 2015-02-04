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
<br/>
<p>
	Please contact me if you have other questions or additional thoughts on your project.
</p>
<br />	
<p>
	Best regards,
</p>
<pre>
<?php echo $company['fullSignature']; ?>
</pre>
<br />

<h1>Ordered paid through Paypal</h1>
