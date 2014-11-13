<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP Cart
 * @author dondrake
 */
class CartsController extends AppController {
	
	public $helpers = array('PurchasedProduct');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

	public function index($id) {
		
	}

	/**
	 * Transfer to the first 'checkout' process page
	 */
	public function checkout() {
		$this->layout = 'noThumbnailPage';
		$this->set('contentDivIdAttr', 'checkout');
		if ($this->Cart->cartExists()) {
			$cart = $this->Cart->retrieve();
		} else {
			$cart = array();
		}
		$this->set('cart', $cart);
		$this->set('referer', $this->referer());
	}
	
	public function pay($method) {
		$Payment = ClassRegistry::init('Payment');
		
		$subtotal = $this->Cart->cartSubtotal();
		$tax = $this->Cart->tax();
		$shipping = $this->Cart->shipping();
		$summary = $this->Cart->summary();
		
		switch ($method) {
			case 'paypal':
				$data = array(
					'transaction' => array(
						'amount' => array(
							'total'    => $shipping + $tax + $subtotal,
							'currency' => 'USD',
							'details'  => array(
								'subtotal' => $subtotal,
								'tax'      => $tax,
								'shipping' => $shipping
							)
						),
						'description' => $summary
					),
					'return_urls' => array( // We must set these for Paypal payments, they are required fields
						'cancel_url' => 'http://localhost/bindery2.0/carts/cancel',
						'return_url' => 'http://localhost/bindery2.0/carts/complete'
					)
				);
				$response = $this->Paypal->createPaypalPayment($data, 'sale');
				
				$Payment->save(array( 'Payment' => array(
					'order_id' => $this->Cart->cartId(),
					'type' => $response->status,
					'data' => json_encode($response)
				)));
				
				$this->Cart->state($response->status);
//				debug($response);die;
//object(stdClass) {
//	id => 'PAY-6L8318935M590390UKRK375I'
//	status => 'created'
//	created => '2014-11-01 22:24:05'
//	modified => '2014-11-01 22:24:05'
//	payment_method => 'paypal'
//	type => 'sale'
//	payer => object(stdClass) {
//		billing_address => object(stdClass) {
//			line1 => ''
//			line2 => ''
//			city => ''
//			country_code => ''
//			postal_code => ''
//			state => ''
//		}
//		credit_card => object(stdClass) {
//			number => ''
//			type => ''
//			expire_month => ''
//			expire_year => ''
//			first_name => ''
//			last_name => ''
//		}
//		id => null
//		email => null
//	}
//	approval_url => 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=EC-5CX17020FE758673D'
//	transaction => object(stdClass) {
//		amount => object(stdClass) {
//			total => '400.00'
//			currency => 'USD'
//			details => object(stdClass) {
//				subtotal => '400.00'
//			}
//		}
//		description => 'This is the total for your cart'
//		sale => object(stdClass) {
//			id => ''
//			parent_id => ''
//		}
//		authorization => object(stdClass) {
//			id => ''
//			created => ''
//		}
//	}
//	error => object(stdClass) {
//		code => false
//	}
//}				
				if ($response->status === 'created') {
					//$response->approval_url
//					$HTTP = new HttpSocket();
					$this->redirect($response->approval_url);
					exit();
				} else {
					exit();
				}
		}
	}
	
	public function complete() {
		
		$this->scripts[] = 'order_addresses';

		$this->request->data = $this->Cart->find('first', array('conditions' => array('Cart.id' => 42)));
		$Payment = ClassRegistry::init('Payment');
//		dmDebug::ddd($this->request->data, 'response');
//		dmDebug::ddd($this->request, 'request');
		$data = array(
			'payment_id' => $this->request->query['paymentId'],
			'id' => $this->request->query['PayerID'],
			'token' => $this->request->query['token']
		);
		$response = $this->Paypal->executePaypalPayment($data);

		$Payment->save(array( 'Payment' => array(
			'order_id' => $this->Cart->cartId(),
			'type' => $response->status,
			'data' => json_encode($response)
		)));

		$id = $response->transaction->sale->id;
//		dmDebug::ddd('https://api.sandbox.paypal.com/v1/payments/orders/'. $id, 'url');
		
		
//		query => array(
//		'paymentId' => 'PAY-3VD75761JB929982RKRK3IVQ',
//		'token' => 'EC-3KV968207T8081018',
//		'PayerID' => 'E53U4PCQSMGWS'
//		)
		
//		object(stdClass) {
		//	id => 'PAY-4JT180622J636930CKRK3W5Q'
		//	status => 'approved'
		//	created => '2014-11-01 22:04:54'
		//	modified => '2014-11-01 22:05:33'
		//	payment_method => 'paypal'
		//	type => 'sale'
		//	payer => object(stdClass) {
		//		billing_address => object(stdClass) {
		//			line1 => ''
		//			line2 => ''
		//			city => ''
		//			country_code => ''
		//			postal_code => ''
		//			state => ''
		//		}
		//		credit_card => object(stdClass) {
		//			number => ''
		//			type => ''
		//			expire_month => ''
		//			expire_year => ''
		//			first_name => ''
		//			last_name => ''
		//		}
		//		id => null
		//		email => 'janespratt@dreamingmind.com'
		//	}
		//	approval_url => ''
		//	transaction => object(stdClass) {
		//		amount => object(stdClass) {
		//			total => '400.00'
		//			currency => 'USD'
		//			details => object(stdClass) {
		//				subtotal => '400.00'
		//			}
		//		}
		//		description => 'This is the total for your cart'
		//		sale => object(stdClass) {
		//			id => '5FJ53383391210626'
		//			parent_id => 'PAY-4JT180622J636930CKRK3W5Q'
		//		}
		//		authorization => object(stdClass) {
		//			id => ''
		//			created => ''
		//		}
		//	}
		//	error => object(stdClass) {
		//		code => false
		//	}
		//}
//		die;
	}
}
