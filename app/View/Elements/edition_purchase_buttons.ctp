<?php
// vars to tell if the editions is completely sold out
$productCount = 0;
// init the button fetch block
$this->start('art_purchase_tools');
$this->end();

	if (isset($record['ContentCollection'])) {
		foreach ($record['ContentCollection'] as $collection) {
			if (isset($collection['Collection']['Edition']) && !empty($collection['Collection']['Edition'])) {
				$edition = $collection['Collection']['Edition'];
				
				foreach ($collection['Collection']['Edition'] as $key => $edition) {


					$this->append('art_purchase_tools');
					$productCount++;
					if ($edition['available'] > '0') {

						echo $this->Form->create("Edition-$productCount");
						$qb = QBModel::InvItem('name', $edition['item']);
						$qb = (empty($qb)) ? array('invitem' => array('price' => 'inquire')) : $qb;
						echo $this->Form->input("Edition.$productCount.content", array('value' => serialize($edition), 'type' => 'hidden'));
						echo '<div class="submit">';
						$price = CakeNumber::currency($qb['invitem']['price'], 'USD', array('places' => 0));
						echo $this->Html->para('', "{$edition['name']} - $price", array('title' => $edition['blurb']));
						echo $this->element('Cart/product_purchase_button');
						echo '</div>';
						//					debug($edition);
						//					debug($qb['invitem']['price']);
						//					echo $this->EditionProduct->editionButton($edition);
						echo $this->Form->end();

					} else {
						echo '<div class="submit">';
							echo $this->Html->para('', "{$edition['name']} - Sold out", array('title' => $edition['blurb']));
//							echo $this->Html->para('soldout', 'Sold out');
						echo '</div>';
					}
				$this->end();
				}				
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
