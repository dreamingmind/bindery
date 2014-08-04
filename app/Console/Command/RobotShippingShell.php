<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RobotShipping
 *
 * @author jasont
 */
class RobotShippingShell extends AppShell {
    public function main() {
		$this->requestAction('orders/updateShippingOrders/Shipping/robot:TRUE');
//        $this->requestAction(array(
//			'controller' => 'orders', 
//			'action' => 'updateShippingOrders', 
//			array(
//				'pass' => array(
//					'Shipping'
//				)
//			),
//			'robot' => TRUE
//			));
    }
}