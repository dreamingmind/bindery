<?php

App::uses('AppModel', 'Model');
App::uses('Hash', 'Utilities');
App::uses('LineTypeFactory', 'Lib/QBUtilities');

/**
 * Description of QbItems
 *
 * @author dondrake
 */
class QbItems extends AppModel {
	
	public $useTable = FALSE;


	public $filter = array (
		'INVITEM' => NULL,
		'NAME' => NULL,
		'REFNUM' => NULL,
		'TIMESTAMP' => NULL,
		'INVITEMTYPE' => NULL,
		'DESC' => NULL,
		'PURCHASEDESC' => NULL,
		'ACCNT' => NULL,
		'ASSETACCNT' => NULL,
		'COGSACCNT' => NULL,
		'PRICE' => NULL,
		'COST' => NULL,
		'TAXABLE' => NULL
		);
	
	public $headers = array();
	
//	public $filter = array ('INVITEM' => NULL,
//		'NAME' => NULL,
//		'REFNUM' => NULL,
//		'TIMESTAMP' => NULL,
//		'INVITEMTYPE' => NULL,
//		'DESC' => NULL,
//		'PURCHASEDESC' => NULL,
//		'ACCNT' => NULL,
//		'ASSETACCNT' => NULL,
//		'COGSACCNT' => NULL,
//		'PRICE' => NULL,
//		'COST' => NULL,
//		'TAXABLE' => NULL,
//		'PAYMETH' => NULL,
//		'TAXVEND' => NULL,
//		'TAXDIST' => NULL,
//		'PREFVEND' => NULL,
//		'REORDERPOINT' => NULL,
//		'EXTRA' => NULL,
//		'CUSTFLD1' => NULL,
//		'CUSTFLD2' => NULL,
//		'CUSTFLD3' => NULL,
//		'CUSTFLD4' => NULL,
//		'CUSTFLD5' => NULL,
//		'DEP_TYPE' => NULL,
//		'ISPASSEDTHRU' => NULL);
	
	/**
	 * Read Quickbooks items-list.isf file
	 * 
	 * This reads the exported file and processes it into data that 
	 * can be used to match products and options with thier prices
	 * 
	 * @param resource $handle The handle to the item.isf file
	 * @return array
	 */
	public function oldImport($handle) {
		$i = 0;
		$dest = array();
		$collect = array();
		$cont = TRUE;
			while (($cont && $buffer = fgets($handle)) !== false) {
				
				// A first char = ! means a header row
				$p = strpos($buffer, '!');
				if ($p === 0) {
					
					// Parsing Group definitions won't do us much good here. 
					// Hoping their always at the end like this.
					if (stristr($buffer, 'ENDGRP')) {
						$cont = FALSE;
					}
					$keys = explode("\t", str_replace('!', '', $buffer));
					$i++;
					
				// The rows following the hearder row are data rows
				} else {
					$vals = explode("\t", $buffer);
					
					// one last check to insure the headers and data match 
					// and we can assemble the the assoc array
					if (count($keys) == count($vals)) {
						$a = array_combine($keys, $vals);
						$dest[$i][] = $a;
					} else {
						
						// garbage collection. probably not used now
						$collect[$i][] = array($keys, $vals);
					}
				}
		}
		if (!feof($handle)) {
			echo "Error: unexpected fgets() fail\n";
		}
		fclose($handle);
		
		// The first header/record is meta data about the qb app
		array_shift($dest);
		
		// and the node we want has an extra index on top
		$items = $dest[0];
		
		// now knock down to what is probably the useful data elements
		foreach ($items as $key => $record) {
			$items[$key] = array_intersect_key($record, $this->filter);
			// while waling the array and filtering the array elementx 
			// we need to massage the NAME node (which contains the item code)
			$name = explode(':', $items[$key]['NAME']);
			
			// turn the name nodes around to code-first, parent-categories later
			// and get rid of the dm/jp cost splits 
			$code = array();
			foreach ($name as $entry) {
				if ($name == 'DM' || $name == 'JP' || $name == 'TN') {
					// these are the wierd shared income items I made. Bad idea
					continue;
				} else {
					array_unshift($code, $entry);
				}
			}
			$items[$key]['NAME'] = $code;
			
			// final is indexed on the code for easy lookup
			$final[$entry] = $items[$key];
		}
		
		return $final;
	}
	
	public function import($handle) {
		$i=0;
		while(($line = fgets($handle)) != FALSE && $i<25){
			$lineType = LineTypeFactory::create($line);
			if($lineType->skip()){
				continue;
			}
			$this->headers = $lineType->execute($this->headers);
			$i++;
		}
	}
}
?>
