<?php
$toolkit = $cart['toolkit'];
$interest = $because = FALSE;

if ($toolkit->itemCount() > 1) {
	$interest = "these {$toolkit->itemCount()} items";
} else {
	$interest = 'this item';
	$because = 'it';
}

if (!$because) {
	if ($toolkit->itemCount() == $toolkit->zeroCount()) {
		$because = 'these items';
	} else {
		$because = "{$toolkit->zeroCount()} of them";
	}
}

?>

<p><?php echo $toolkit->customerName(); ?>,</p>
<br />
<p>
	Thanks for your interest in <?php echo $interest; ?>.
</p>
<p>
	Because <?php echo $because; ?> can't be priced on the site, I'll look over your specifications and provide a quote.
</p>
<p>
	<?php echo $this->PolicyStatement->statement('Quote'); ?>
</p>
<p>
	Please contact me if you have other questions or additional thoughts on your project.<br />
	<?php echo $this->PolicyStatement->vacation($company['vacation']); ?>
</p>
<address class='signature'>
<p>
	Best regards,
</p>
<pre>
<?php echo $company['fullSignature']; ?>
</pre>
<br />
</address>
<h1>Submitted for quotation</h1>
