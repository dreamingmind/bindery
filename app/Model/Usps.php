<?php

/**
 * CakePHP Usps
 * @author dondrake
 */
class Usps {
	
	public function estimate($cart) {
		if (empty($cart['CartItem'])) {
			return;
		}
		$ounces = 0;
		$default = Configure::read('usps');
		dmDebug::ddd($default, 'config defaults');
		$package = array(
			'Length' => 0,
			'Width' => 0,
			'Height' => 0,
			'Size' => $default['Size'],
			'Service' => $default['Service'],
			'Container' => $default['Container'],
			'Pounds' => 0,
			'Ounces' => 0
		);
		foreach ($cart['CartItem'] as $item) {
			$package['Length'] = $package['Length'] < $item['length'] ? $item['length'] : $package['Length'];
			$package['Width'] = $package['Width'] < $item['width'] ? $item['width'] : $package['Width'];
			$package['Height'] += $item['height'];
			$ounces += $item['width'];
		}
		if ($package['Length'] > 12 || $package['Width'] > 12 || $package['Height'] > 12) {
			$package['Size'] = 'Large';
		} else {
			unset($package['Width'], $package['Height'], $package['Length']);
		}
		$package['Ounces'] = $ounces % 16;
		$package['Pounds'] = intval($ounces/16);
		dmDebug::ddd($package, 'package');
	}
	/*
	 * <Package ID="2ND">

        <Service>PRIORITY</Service>

        <ZipOrigination>44106</ZipOrigination>

        <ZipDestination>20770</ZipDestination>

        <Pounds>1</Pounds>

        <Ounces>8</Ounces>

        <Container>NONRECTANGULAR</Container>

        <Size>LARGE</Size>

        <Width>15</Width>

        <Length>30</Length>

        <Height>15</Height>

        <Girth>55</Girth>

    </Package>
	 */
}
