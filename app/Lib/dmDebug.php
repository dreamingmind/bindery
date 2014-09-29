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
		self::debug($dbg);
	}
	
	public static function ddx($dbg, $title = false, $stack = false) {
		self::ddd($dbg, $title, $stack);
		die;
	}
	
	/**
 * Prints out debug information about given variable.
 *
 * Only runs if debug level is greater than zero.
 *
 * @param boolean $var Variable to show debug information for.
 * @param boolean $showHtml If set to true, the method prints the debug data in a browser-friendly way.
 * @param boolean $showFrom If set to true, the method prints from where the function was called.
 * @return void
 * @link http://book.cakephp.org/2.0/en/development/debugging.html#basic-debugging
 * @link http://book.cakephp.org/2.0/en/core-libraries/global-constants-and-functions.html#debug
 */
public static function debug($var, $showHtml = null, $showFrom = true) {
		if (Configure::read('debug') > 0) {
			App::uses('Debugger', 'Utility');
			$file = '';
			$line = '';
			$lineInfo = '';
			if ($showFrom) {
				$trace = Debugger::trace(array('start' => 1, 'depth' => 2, 'format' => 'array'));
				$file = str_replace(array(CAKE_CORE_INCLUDE_PATH, ROOT), '', $trace[0]['file']);
				$line = $trace[0]['line'];
			}
			$html = <<<HTML
<div class="cake-debug-output">

<pre class="cake-debug">
%s
</pre>
</div>
HTML;
			$text = <<<TEXT
%s
########## DEBUG ##########
%s
###########################
TEXT;
			$template = $html;
			if (php_sapi_name() === 'cli' || $showHtml === false) {
				$template = $text;
				if ($showFrom) {
					$lineInfo = sprintf('%s (line %s)', $file, $line);
				}
			}
			if ($showHtml === null && $template !== $text) {
				$showHtml = true;
			}
			$var = Debugger::exportVar($var, 25);
			if ($showHtml) {
				$template = $html;
				$var = h($var);
				if ($showFrom) {
					$lineInfo = sprintf('<span><strong>%s</strong> (line <strong>%s</strong>)</span>', $file, $line);
				}
			}
			printf($template, $var);
		}
	}

}

?>
