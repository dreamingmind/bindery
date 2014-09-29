<?php //debug($params);
$products = array(
	'journals', 'albums', 'notebooks', 'portfolios', 'guest-books', 'boxes', 'personal-publishing', 'business-diaries', 'other-products' 
);
?>
<div id="detail">
	<ul>
	  <?php
	  foreach ($products as $product) {
		  echo $this->Html->tag('li', $this->Html->link($product, array('controller' => 'catalogs', 'action' => 'catalog', 'pname' => $product)));
	  }
	  ?>
	</ul>
</div>
