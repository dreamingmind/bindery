<?php
$interest = $because = FALSE;

if ($cart['toolkit']->itemCount() > 1) {
	$interest = "these {$cart['toolkit']->itemCount()} items";
} else {
	$interest = 'this item';
	$because = 'it';
}

if (!$because) {
	if ($cart['toolkit']->itemCount() == $cart['toolkit']->zeroCount()) {
		$because = 'these items';
	} else {
		$because = "{$cart['toolkit']->zeroCount()} of them";
	}
}

?>

<p><?php echo $cart['toolkit']->customerName(); ?>,</p>
<br />
<p>Thanks for your interest in <?php echo $interest; ?>. Because <?php echo $because; ?> can't be priced on the site, 
I'll look over your specifications and provide a quote.</p>
<br />		
<p>Best regards,</p>
<pre><?php echo $company['fullSignature']; ?></pre>
<br />
<h1>Submitted for quotation</h1>
