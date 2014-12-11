<?php
/**
 * Log Model
 *
 * @copyright     Copyright (c) Dreaming Mind (http://dreamingmind.com)
 * @package       app.Model
 */
App::uses('AppModel', 'Model');

/**
 * Log Model
 *
 * @package	app.Controller
 */
class Log extends AppModel{
	
// <editor-fold defaultstate="collapsed" desc="Properties">
	public $useTable = false;
	
	public $pattern = array(
		'pair' => ':%s:%s:',
		'meta' => array(
			'date' => '', // YYYY-MM-DD from the log line
			'originTime' => '', // the HH:MM:SS from the log line
			'datetime' => '', // Unix timestamp of date, not the origin time
			'timestamp' => '', // Unix timestamp of date + time
			'type' => '', // type of log
			'origin' => '' // the original meta string from the log
		),
		// ::customer:9::number:1404-AACC::event:Inventory adjustment::id:56::name:Billy Tongs::from:99.0::to:100"::change:1::by:Don Drake::
		// ::customer:9::number:1404-AACC::event:ON HAND INVENTORY OVERRIDE::id:56::name:Billy Tongs::from:99.0::to:100"::change:1::by:Don Drake::
		'Inventory' => array(
			'customer' => '',
			'number' => '',
			'event' => '',
			'id' => '',
			'name' => '',
			'from' => '',
			'to' => '',
			'change' => '',
			'by' => ''
		),
		// ::customer:9::event:Inventory snapshot::id:92::Clients_code:ID92::Staff_code:14203_0005::name: Tassel - Emerald::state:active::inventory:99.0::
		'Snapshot' => array(
			'customer' => '',
			'event' => 'Inventory snapshot',
			'id' => '',
			'Clients_code' => '',
			'Staff_code' => '',
			'name' => '',
			'state' => '',
			'inventory' => ''
		),
		// ::event:Status::alias:Order::id:52a2ca8f-77a4-4889-9121-010c47139427::start_status:Backorder::end_status:Backordered::by:Don Drake::
		'Status' => array(
			'alias' => '',
			'id' => '',
			'start_status' => '',
			'end_status' => '',
			'by' => '',
		)
	); 
// </editor-fold>
	
	public $logLine = array(); //array of decomposed log line values
	public $logLineOut = ''; //string log line ready to save
	public $logLineIn = ''; //string log line read in
	public $meta = array(); //array of decomposed meta values for the log line
	public $logLines = array(); //accumulator of log lines for save
	public $file = ''; //filename of the log file operating on
	public $path =''; //full path to the log file operating on
	public $target =''; //name of the final directory file will go into

	
	// ***************************************************************
	// BUILD/BREAK MODERN LOG LINES
	// ***************************************************************
	
	/**
	 * Break the provided log line into its data bits
	 * 
	 * @param string $logLine
	 */
	public function parseLogLine($logLine) {
		
		// init properties
		$this->meta = $this->pattern['meta'];
		$this->logLineIn = $logLine;
		$this->logLine = array();
		
		if (empty($logLine) || !is_string($logLine)) {
			return;
		}
		
		// divide cake auto-gen stuff from our line
		$parts = explode(': ::', $logLine);
		if (count($parts) != 2) {
			return '';
		}

		$this->buildMeta($parts[0]);
		// process our log line info
		$this->logLine = $this->pattern[$this->meta['type']];
		$fields = explode('::', $parts[1]);
		array_pop($fields);
		foreach ($fields as $field) {
			$p = explode(':', $field);
			$this->logLine[$p[0]] = isset($p[1]) ? $p[1] : 'missing';
		}
	}
	
	/**
	 * Create meta data element for a log line
	 * 
	 * @param array $parts
	 */
	private function buildMeta($parts) {
		// process the cake auto-gen stuff
		preg_match('/([\d\-]+) ([\d:]+) (.+)/', $parts, $meta); //2014-02-07 22:20:55 Snapshot
		$this->meta['date'] = $meta[1];
		$this->meta['originTime'] = $meta[2];
		$this->meta['datetime'] = strtotime($meta[1]);
		$this->meta['timestamp'] = strtotime("$meta[1] $meta[2]");
		$this->meta['type'] = $meta[3];
		$this->meta['origin'] = $meta[0];
		
	}
	
	/**
	 * Construct a log line from an array
	 * 
	 * @param type $logLine
	 */
	public function toString($logLine = FALSE) {
		if ($logLine) {
			$this->logLine = $logLine;
		}
		$o = array();
		foreach ($this->logLine as $f => $v) {
			$o[] = sprintf($this->pattern['pair'], $f, $v);
		}
		$this->logLineOut = ':' . implode('', $o) . ':';
	}
	
	/**
	 * Set one value in the current logLine
	 * 
	 * @param string $field
	 * @param string $value
	 */
	public function set($field, $value = NULL) {
		$this->logLine[$field] = $value;
		return $this;
	}
	
	/**
	 * Start the specified Log record type with default values
	 * 
	 * @param string|array $type Name of pattern or data for new logLine
	 * @param boolean $filter unused
	 */
	public function create($type = array(), $filter = FALSE) {
//		if (is_array($type)) {
//			
//		}
		switch ($type) {
			case 'snapshot':
			case 'Snapshot':
				$this->logLine = $this->pattern['Snapshot'];
				$this->meta = $this->pattern['meta'];
				$this->meta['type'] = 'Snapshot';
				break;
			case 'adjustment':
				$this->logLine = $this->pattern['Inventory'];
				$this->set('event', 'Inventory adjustment');
				$this->meta = $this->pattern['meta'];
				$this->meta['type'] = 'Inventory';
				break;
			case 'override':
				$this->logLine = $this->pattern['Inventory'];
				$this->set('event', 'ON HAND INVENTORY OVERRIDE');
				$this->meta = $this->pattern['meta'];
				$this->meta['type'] = 'Inventory';
				break;
			case 'inventory':
			case 'Inventory':
				$this->logLine = $this->pattern['Inventory'];
				$this->meta = $this->pattern['meta'];
				$this->meta['type'] = 'Inventory';
				break;
			case 'status':
			case 'Status':
				$this->logLine = $this->pattern['Status'];
				$this->meta = $this->pattern['meta'];
				$this->meta['type'] = 'Status';
				break;
			default:
				$this->logLine = (is_array($type)) ? $type : array();
				$this->meta = $this->pattern['meta'];
				break;
		}
//		if (isset($this->pattern[$type])) 
	}
	
	// ***************************************************************
	// TRANSFORM OLD LOGS
	// ***************************************************************
	
	public function transformAllLogs() {
		$logs = array(
			LOGS.'Inventory/inventory',
			LOGS.'Inventory/snapshot',
			LOGS.'Status'
		);
		foreach ($logs as $dir) {
			//reset the logLines property to prepare for the next log
			$this->logLines = array();
			$this->walkDirectory($dir);
		}
	}
	
	private function walkDirectory($dir) {
		$p = explode('/', $dir);
		$this->target = $p[ count($p) -1 ];
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (false !== ($this->file = readdir($dh))) {
					if (preg_match("/$this->target\./", $this->file)) {
						$this->path = "$dir/$this->file";
						$this->walkFile();
						$this->writeNewVersionLogs();
						$this->ddd($this->logLines, 'Wrote a new file');
						$this->logLines = array();
//						die;
					}
				}
				closedir($dh);
			}
		}
	}
	
	private function walkFile() {
		$handle = @fopen($this->path, "r");
		if ($handle) {
			while (($buffer = fgets($handle, 4096)) !== false) {
				echo "<p style='color: black'>$buffer<br />";
				switch ($this->target) {
					case 'inventory':
						if (stristr($buffer, 'OVERRIDE')) {
							$this->parseInventoryOverride($buffer);
						} else {
							$this->parseInventoryEvent($buffer);
						}
						break;
					case 'snapshot':
						$this->parseSnapshot($buffer);
						break;

					default:
						break;
				}
				$this->toString();
				$this->logLineOut = $this->meta['origin'] . ': ' . $this->logLineOut;
				$this->logLines[] = $this->logLineOut;
				
				echo "{$this->logLineOut}</p>";
			}
			if (!feof($handle)) {
				echo "Error: unexpected fgets() fail\n<br />";
			} 
			fclose($handle);
		}
	}
	
	private function writeNewVersionLogs() {
		$logRoot = LOGS . 'Inventory/New/';
		if(!is_dir($logRoot)){
			mkdir($logRoot);
		} 
		$this->ddd(file_put_contents($logRoot.$this->file, implode("\r\n", $this->logLines)));
	}

	
	/**
	 * Break down an old-style inventory event line
	 * 
	 * @param type $logLine
	 */
	private function parseInventoryEvent($logLine = FALSE) {
		if ($logLine) {
			$this->logLineIn = $logLine;
		}
		$this->logLine = $this->pattern['Inventory'];
		// 'customer', 'number', 'event', 'id', 'name', 'from', 'to', 'change', 'by'
		// 2014-03-07 20:17:37 Inventory: Inventory adjustment of id:112::Ring Mechanism from 5.0 to 4 (-1) by Don Drake
		
		$parts = explode(': Inventory', $this->logLineIn);
		$this->buildMeta($parts[0]);
		
		$this->logLine['id'] = $this->extractOldId();
		$this->logLine['customer'] = $this->findUsrCustId();
		$this->logLine['event'] = 'Inventory adjustment';
		$this->logLine['number'] = $this->discoverOrderNumber();
		$this->logLine['name'] = $this->getName('event');
		$this->setInvChange();
		$this->logLine['by'] = $this->getActor();
	}
	
	/**
	 * Break down an old-style inventory override line
	 * 
	 * @param type $logLine
	 */
	private function parseInventoryOverride($logLine = FALSE) {
		if ($logLine) {
			$this->logLineIn = $logLine;
		}
		$this->logLine = $this->pattern['Inventory'];
		// 'customer', 'number', 'event', 'id', 'name', 'from', 'to', 'change', 'by'
		// 2014-01-22 21:59:15 Inventory: ON HAND INVENTORY OVERRIDE FOR 89::Doorhangar from 50.0 to 55.0 by Don Drake
		$parts = explode(': ON HAND', $this->logLineIn);
		$this->buildMeta($parts[0]);
		
		$this->logLine['id'] = $this->extractOldId();
		$this->logLine['customer'] = $this->findUsrCustId();
		$this->logLine['event'] = 'ON HAND INVENTORY OVERRIDE';
		$this->logLine['number'] = $this->discoverOrderNumber();
		$this->logLine['name'] = $this->getName('override');
		$this->setInvChange();
		$this->logLine['by'] = $this->getActor();
	}
	
	/**
	 * Breakdown an old-style snapshot line
	 * 
	 * @param type $logLine
	 */
	private function parseSnapshot($logLine = FALSE) {
		if ($logLine) {
			$this->logLineIn = $logLine;
		}
		// ::customer:9::event:Inventory snapshot::id:92::Clients_code:ID92::Staff_code:14203_0005::name: Tassel - Emerald::state:active::inventory:99.0::
		// 2014-02-07 22:20:55 Snapshot: [46] Inventory snapshot of id:158:: |Clients_code: ID158|Staff_code: ID158|name: KIBCO - comp1|state: active|inventory: 2.0|

		if (preg_match('/\: \[\d+\] /', $this->logLineIn, $match)) {
			$d = $match[0];
		} else {
			$d = ': Inventory';
		}
		$parts = explode($d, $this->logLineIn);
		$this->buildMeta($parts[0]);
		
		$this->logLine = $this->pattern['Snapshot'];
//		'customer' , 'event' , 'id' , 'Clients_code' , 'Staff_code' , 'name' , 'state' , 'inventory'
		$this->logLine['id'] = $this->extractOldId();
		$this->logLine['customer'] = $this->findUsrCustId();
		$this->logLine['event'] = 'Inventory snapshot';
		$this->logLine['name'] = $this->getName('snapshot');
		$fs = explode('|', $this->logLineIn);
		array_shift($fs);
		array_pop($fs);
		foreach ($fs as $f) {
			$p = explode(': ', $f);
			$this->logLine[$p[0]] = $p[1];
		}
	}
	
	/**
	 * Return the product name from an old-style Inventory or Snapshot log line
	 * 
	 * @param string $mode
	 * @return string
	 */
	private function getName($mode) {
		switch ($mode) {
			case 'event':
			case 'override':
				$pattern = '/::(.+) from/';
				break;
			case 'snapshot':
				$pattern = '/name: (.+)\|/';
				break;
			default:
				break;
		}
		preg_match($pattern, $this->logLineIn, $match);
		if (isset($match[1])) {
			return $match[1];
		} else {
			return 'name not found';
		}	
	}
	
	/**
	 * Breakdown an old-style status line
	 * @param type $logLine
	 */
	private function parseStatus($logLine = FALSE) {
		if ($logLIne) {
			$this->logLineIn = $logLIne;
		}
	}
	
	/**
	 * Return the item Id from an old-style Inventory or Snapshot log line
	 * 
	 * @return string
	 */
	private function extractOldId() {
		preg_match('/id:(\d+)::| FOR (\d+)::/', $this->logLineIn, $i);
		if (isset($i[1])) {
			return array_pop($i);
		} else {
			return 'unkown';
		}
	}
	
	/**
	 * Discover the customer user id, the owner of the working itemId
	 * 
	 * @return int
	 */
	private function findUsrCustId() {
		$this->Item = ClassRegistry::init('Item');
		return $this->Item->discoverCustomerUserId($this->logLine['id']);
	}
	
	/**
	 * Set the working-line inventory-change values from an old-style Inventory log line
	 */
	private function setInvChange() {
		//  from 5.0 to 4 (-1) by 
		preg_match('/ from ([\d.]+) to ([\-\d.]+) \(?([\d.]+)?\)?/', $this->logLineIn, $match);
		$this->logLine['from'] = isset($match[1]) ? $match[1] : 'xx';		
		$this->logLine['to'] = isset($match[2]) ? $match[2] : 'xx';		
		if (isset($match[1]) && isset($match[2])) {
			$this->logLine['change'] = $match[2] - $match[1];
		} else {
			$this->logLine['change'] = 'xx';
		}
	}
	
	/**
	 * Get the user name from the end of an old-style Inventory log line
	 * @return string
	 */
	private function getActor() {
		preg_match('/ by (.+)/', $this->logLineIn, $match);
		if (isset($match[1])) {
			return $match[1];
		} else {
			return 'name not found';
		}
	}
	
	private function discoverOrderNumber() {
		// status.2013.12.51.log
		$f = date('Y.m.W', $this->meta['daytime']);
		return $f;
	}
}
?>