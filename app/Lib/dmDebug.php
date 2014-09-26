<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dmDebug
 *
 * @author dondrake
 */
class dmDebug extends Object{

	public static $trace = '';
	public static $caller = '';
	
	/**
 * Log output for debugging
 * 
 */
	public static function logVars($data, $name, $trace = false, $message = false) {
		self::getCallingLine();
		$message = ($message) ? "\r".$message : '' ;
		$location = ($trace) ? self::$trace : self::$caller;
//		if ($this->debugVal > 0) {
			CakeLog::write('varlog', "\r=======================================\r$name$message\r$location\r=======================================\r");
			CakeLog::write('varlog', "\r" . Debugger::exportVar($data));
			CakeLog::write('varlog', "\rEND $name\r***************************************\r\r");
//		}
	}

	private static function getCallingLine(){
		$trace = Debugger::trace();
		$lines = preg_split('/[\r*|\n*]/', $trace);
		array_shift($lines);
		array_shift($lines);
		self::$caller = $lines[0];
		self::$trace = implode("\r", $lines);
	}
	
	/**
	 * Save data and information about critical, but failed save attempts
	 * 
	 * @param type $toBeDetermined
	 */
	public static function logDbFailure($toBeDetermined) {
		// the idea here is to generalize what was done in
		// InvoiceItem->logLinkError()
		debug('logging the db save failure');
	}
	
	public static function ddd($dbg, $title = false, $stack = false) {
		//set variables
		$ggr = Debugger::trace();
		$line = preg_split('/[\r*|\n*]/', $ggr);
		$togKey = sha1($line[1]);

		echo "<div class=\"cake-debug-output\">";
		if ($title) {
			echo "<h3 class=\"cake-debug\">$title</h3><p class=\"toggle\" id=\"$togKey\"><strong>$line[1]</strong></p>";
		}
		if ($stack) {
			echo "<pre class=\"$togKey hide\">$ggr</pre>";
		}
		echo"</div>";
		debug($dbg);
	}
	
	public static function ddx($dbg, $title = false, $stack = false) {
		self::ddd($dbg, $title, $stack);
		die;
	}
}

?>
