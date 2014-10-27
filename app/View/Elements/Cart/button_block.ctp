<div class="button_block">
	<button id="continue" bind="click.continue_shopping">Continue Shopping</button>
	<div class="proceed">
		<?php
		if ($cartClass === 'cart_pallet') {
			?>
			<button>Checkout</button>
			<?php
		} else {
			?>
			<button>Pay by check</button>
			<button>PayPal</button>
			<?php
		}
		?>
	</div>
</div>