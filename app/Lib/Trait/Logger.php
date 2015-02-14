<?php
/**
 * Description of Logger
 *
 * @author dondrake
 */
Trait Logger {
	
	public $creditCardAttemptMessage = "\n** Prepared to acknowledge credit card Order %s, for %s for %s items (%s) in cart %s.\n-----------------------END----------------------------\n";
	public $creditCardSuccessMessage = "\n++ Acknowledgement for credit card Order %s request for %s successfully sent.\n-----------------------END----------------------------\n\n";
	
	public $quoteAttemptMessage = "\n** Prepared to request Quote %s, for %s for %s items (%s) in cart %s.\n-----------------------END----------------------------\n";
	public $quoteSuccessMessage = "\n++ Quote %s request for %s successfully sent.\n-----------------------END----------------------------\n\n";
	
	public $expressAttemptMessage = "\n** Prepared to acknowledge Order %s, for %s for %s items (%s) in cart %s.\n-----------------------END----------------------------\n";
	public $expressSuccessMessage = "\n++ Acknowledgement for Order %s request for %s successfully sent.\n-----------------------END----------------------------\n\n";
	
	public $removeCartItemMessage = "\n-- Item removed from cart\n%s\n-----------------------END----------------------------\n\n";
	public $retractLastMessage = "\n!! There was a problem completing the process (%s).\n-----------------------END----------------------------\n\n";
	
	public $placeArtMessage = "++ %s, numbers %s were stored in %s.";
	
	public $guardMessage = "Guard violation in %s line %s\n\t%s\n%s\n-----------------------END----------------------------\n\n";
	
	public $typeMemoMessage = "\n!! The TypeMemo failed to delete and prevented the user from move their wish list item to their cart\n%s\n-----------------------END----------------------------\n\n";

	/**
	 * Log a Quote Acknowledgement email
	 * 
	 * @param string $mode attempt or success
	 * @param array $cart Standard cart array and tool object
	 */
	public function logCreditCardEmail($mode, $cart) {
		$toolkit = $cart['toolkit'];
		if ($mode == 'Attempt') {
			$this->log(sprintf($this->{"creditCard{$mode}Message"}, 
							$toolkit->orderNumber(), 
							$toolkit->customerName(), 
							$toolkit->itemCount(), 
							$toolkit->itemInList(), 
							$toolkit->cartId()), 
					'order_email');
		} else {
			$this->log(sprintf($this->{"creditCard{$mode}Message"}, $toolkit->orderNumber(), $toolkit->customerName()), 'order_email');
		}
	}
	
	/**
	 * Log a Quote Acknowledgement email
	 * 
	 * @param string $mode attempt or success
	 * @param array $cart Standard cart array and tool object
	 */
	public function logQuoteEmail($mode, $cart) {
		$toolkit = $cart['toolkit'];
		if ($mode == 'Attempt') {
			$this->log(sprintf($this->{"quote{$mode}Message"}, 
							$toolkit->orderNumber(), 
							$toolkit->customerName(), 
							$toolkit->itemCount(), 
							$toolkit->itemInList(), 
							$toolkit->cartId()), 
					'order_email');
		} else {
			$this->log(sprintf($this->{"quote{$mode}Message"}, $toolkit->orderNumber(), $toolkit->customerName()), 'order_email');
		}
	}
	
	/**
	 * Log a Quote Acknowledgement email
	 * 
	 * @param string $mode attempt or success
	 * @param array $cart Standard cart array and tool object
	 */
	public function logExpressEmail($mode, $cart) {
		$toolkit = $cart['toolkit'];
		if ($mode == 'Attempt') {
			$this->log(sprintf($this->{"express{$mode}Message"}, 
							$toolkit->orderNumber(), 
							$toolkit->customerName(), 
							$toolkit->itemCount(), 
							$toolkit->itemInList(), 
							$toolkit->cartId()), 
					'order_email');
		} else {
			$this->log(sprintf($this->{"express{$mode}Message"}, $toolkit->orderNumber(), $toolkit->customerName()), 'order_email');
		}
	}
	
	/**
	 * log a arguement guard violation
	 * 
	 * @param string $method
	 * @param string $line
	 * @param string $message
	 * @param string $trace
	 */
	public function guardError($method, $line, $message, $trace) {
		$this->log(sprintf($this->guardMessage, $method, $line, $message, $trace), 'guard_error');
	}

	/**
	 * Log a location change of location for a number artwork
	 * 
	 * @param string $action remove or place
	 * @param string $edition_numbers
	 * @param string $item_name
	 * @param string $location
	 * @param string $user
	 */
	public function artWarehouse($item_name, $edition_numbers, $location, $method) {
		if ($method == 'remove') {
			$format = $this->removeArtMessage;
		} else {
			$format = $this->placeArtMessage;
		}
		$this->log(sprintf($format, $item_name, $edition_numbers, $location), 'track_artwork');
	}
	
	public function logArtworkWarehouseRetraction() {
		$this->log('!! The database process supporting the previous log line failed.', 'track_artwork');
	}
	
	/**
	 * 
	 * @param array $cart_item 
	 */
	public function logRemoveCartItem($cart_item) {
		$message = var_export($cart_item, TRUE);
		$this->log(sprintf($this->removeCartItemMessage, $message), 'cart_activity');
	}
	
	public function logTypeMemoDeletionFailure($data) {
		$message = var_export($cart_item, TRUE);
		$this->log(sprintf($this->typeMemoMessage, $message), 'cart_activity');
	}
	
	public function logRetractLastMessage($process_name, $log_name) {
		$this->log('There was a problem completing the process');
	}
	
}
