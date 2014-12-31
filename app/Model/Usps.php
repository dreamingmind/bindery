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
		// intialize the parts for calc and assembly
		$ounces = 0;
		$default = Configure::read('usps');
		$package = array(
			'@ID' => '1ST',
			'Service' => $default['Service'],
			'ZipOrigination' => $default['ZipOrigination'],
			'ZipDestination' => $default['ZipNear'],
			'Pounds' => 0,
			'Ounces' => 0,
			'Container' => $default['Container'],
			'Size' => $default['Size'],
			'Width' => 0,
			'Length' => 0,
			'Height' => 0
		);
		
		// Look for the largest dimensions and accum hieght and weight
		foreach ($cart['CartItem'] as $item) {
			$package['Length'] = $package['Length'] < $item['length'] ? $item['length'] : $package['Length'];
			$package['Width'] = $package['Width'] < $item['width'] ? $item['width'] : $package['Width'];
			$package['Height'] += $item['height'];
			$ounces += $item['weight'];
		}
		
		// Set nodes based on the discovered size, LARGE or REGULAR
		$package['Height'] = strval($package['Height'] + 2);
		if ($package['Length'] > 12 || $package['Width'] > 12 || $package['Height'] > 12) {
			$package['Size'] = 'LARGE';
			$package['Container'] = 'RECTANGULAR';
		} else {
			unset($package['Width'], $package['Height'], $package['Length']);
		}
		
		// Calculate the weight
		$package['Ounces'] = strval($ounces % 16);
		$package['Pounds'] = strval(intval($ounces/16));
		
		// This will get a single package shipped to Zone 1
		// $default['RateV4Request']['Package'] = $package;
		
		// This makes a second package shipped to Zone 8
		$package2 = $package;
		$package2['@ID'] = '2ND';
		$package2['ZipDestination'] = $default['ZipFar'];
		$default['RateV4Request']['Package'] = array($package, $package2);
		
		// Now make the xml and assmeble the final GET call
		$x = array('RateV4Request' => array($default['RateV4Request']));
		$xml = Xml::fromArray($x);
		$call = $default['call'].$xml->asXML();
		
		return $call;
		
//		dmDebug::ddd($call, 'xml');
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
