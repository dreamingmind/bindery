<?php
// vars to tell if the editions is completely sold out
$productCount = 0;
$availableCount = 0;
// init the button fetch block
$this->start('art_purchase_tools');
$this->end();

	if (isset($record['ContentCollection'])) {
		foreach ($record['ContentCollection'] as $collection) {
			if (isset($collection['Collection']['Edition']) && !empty($collection['Collection']['Edition'])) {
				
				$edition = $collection['Collection']['Edition'];
				$this->append('art_purchase_tools');
					$productCount++;
					if ($edition['available'] > '0') {
						$availableCount++;						
					}
					echo $this->Form->create("Edition-$productCount");
					$qb = QBModel::InvItem('name', $edition['item']);
					$qb = (empty($qb)) ? array('invitem' => array('price' => 'inquire')) : $qb;
					echo $this->Form->input("Edition.$productCount.content", array('value' => serialize($edition), 'type' => 'hidden'));
					echo '<div class="submit">';
					$price = CakeNumber::currency($qb['invitem']['price'], 'USD', array('places' => 0));
					echo $this->Html->para('', "{$edition['name']} - $price", array('title' => $edition['blurb']));
					echo $this->Form->button(($purchaseCount > 0) ? 'Add to cart' : 'Order now', array('type' => 'submit', 'class' => 'submit'));
					echo '</div>';
//					debug($edition);
//					debug($qb['invitem']['price']);
//					echo $this->EditionProduct->editionButton($edition);
					echo $this->Form->end();						
				$this->end();
			}
		}
	}
?>
	<div id="purchase">
		<p>Purchase</p>
		<?php
		echo $this->fetch('art_purchase_tools');
		?>
	</div>
