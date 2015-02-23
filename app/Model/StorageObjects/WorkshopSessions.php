<?php
/**
 * WorkshopSession is the storage and access object for a single Workshops sessions and the dates for those sessions
 * 
 * This object provides iterators for the sessions and iterators on 
 * each session for their dates. 
 *
 * @author dondrake
 */
class WorkshopSessions{
	
	/**
	 * The stored WorkshopSession and Date data
	 *
	 * @var obj ArrayStorageObject or JsonStorageObject
	 */
	protected $session_data;
	
	/**
	 * The iterator for WorkshopSessionData
	 * 
	 * Each session has a date iterator:
	 *	foreach ($this->sessions as $session) {
	 *		foreach ($this->sessions->dates as $date){
	 *
	 * @var iterator
	 */
	public $sessions;
	
	public function __construct($storage_object) {
		$this->session_data = $storage_object;
		$this->sessions = new SessionIterator($this->session_data);
		
//		dmDebug::ddd($this->sessions->dates()->one(), 'duration');
//		dmDebug::ddd($this->sessions->dates()->two(), 'duration');
//		dmDebug::ddd($this->sessions->dates()->three(), 'duration');
//		dmDebug::ddd($this->sessions->dates()->four(), 'duration');

		// calling non-iterating methods of the iterator
//		dmDebug::ddd($this->sessions->dates()->duration(), 'duration');
//		
//		// accessing the current iterator element data directly
//		dmDebug::ddd($this->sessions->dates()->current()->read('id'), 'id');
//		dmDebug::ddd($this->sessions->current()->read('title'), 'title');
		
		// getting the dates iterator on the property
//		$this->sessions->current();
//		dmDebug::ddd($this->sessions->dates, 'sessions iterator');
		
		// using the two iterators in loops
//		foreach ($this->sessions as $session) {
//			dmDebug::ddd($session->read(), 'session');
//			foreach ($this->sessions->dates as $date){
//				dmDebug::ddd($date->read(), 'date');
//			}
//		}
	}
		
}

/**
 * Iterator for the Sessions
 * 
 * Constructs a Dates iterator for each session as it is encountered
 */
class SessionIterator extends ArrayIterator {
	
	/**
	 * Iterator for the dates on a single session
	 * 
	 * The $this->dates iterator won't exist until the current() 
	 * session is accessed and then it will be available on the 
	 * sessions iterator or you can return it by calling dates()
	 *
	 * @var iterator
	 */
	public $dates;
	
	public $sessions;
		
	public function __construct($sessions) {
		$this->sessions = $sessions;
		parent::__construct($sessions);
	}
	
	/**
	 * Return the field keys and values (but not the date records)
	 * 
	 * Date data is available at $this->dates as an iterator
	 * 
	 * @return mixed StorageObject->data
	 */
	public function current() {
		$this->dates = $this->dates();
		return new ObjectStorageObject(parent::current()->read('{s}'));
	}
	
	/**
	 * Get the dates iterator for the current() session
	 * 
	 * @return iterator
	 */
	public function dates() {
		$this->dates = new DateIterator(parent::current()->read('{n}'));
		return $this->dates;
	}
}

/**
 * Iterator for the Dates
 */
class DateIterator extends ArrayIterator {
	
	public function __construct($dates) {
		parent::__construct($dates);
	}
	
	/**
	 * Get the duration of all days for the current session
	 * 
	 * Won't disrupt the current dates iterator if it happens to be in mid stream
	 * 
	 * @param int $time_unit HOUR, MINUTE, SECOND
	 * @return int
	 */
	public function duration($time_unit = HOUR) {
		$dates = parent::getArrayCopy();
		$duration = 0;
		foreach ($dates as $date) {
			$duration += $this->timeSpan($date);
		}
		return $duration / $time_unit;
	}
	
	/**
	 * Calculate the seconds between the start/end times for a single date
	 * 
	 * @param StorageObject $date_data NULL to use current()
	 * @return int
	 */
	public function timeSpan($date_data = NULL) {
		if (is_null($date_data)) {
			$date_data = $this->current();
		}
		return $this->seconds('end', $date_data) - $this->seconds('start', $date_data);
	}
	
	/**
	 * Turn one of the times in the record into a timestamp (unix seconds)
	 * 
	 * @param string 'start' or 'end'
	 * @param StorageObject $date_data NULL to use current()
	 * @return int
	 */
	public function seconds($time_point, $date_data = NULL) {
		if (is_null($date_data)) {
			$date_data = $this->current();
		}
		return strtotime($date_data->read('date') . ' ' . $date_data->read("{$time_point}_time"));
	}
	
	/**
	 * Return the date in the form 'Nov 27 2011'
	 * 
	 * @param string $time_point 'start' or 'end'
	 * @return string MAR 13 2015
	 */
	public function date($time_point = 'start') {
		return date('M d Y', $this->seconds($time_point));
	}
	
	/**
	 * Return am or pm in caps or lower case
	 * 
	 * @param string $time_point 'start' or 'end'
	 * @param boolean $upper
	 * @return string am/pm or AM/PM
	 */
	public function amPm($time_point = 'start', $upper = FALSE) {
		$am_pm = ($upper) ? 'A' : 'a';
		return date($am_pm, $this->seconds($time_point));
	}

	/**
	 * Return the time (12 hour clock, no leading zeros)
	 * 
	 * @param type $time_point
	 * @return string 3:30
	 */
	public function oClock($time_point = 'start') {
		return date('g:i', $this->seconds($time_point));
	}
//	, , 
//				date('A', $starttimestamp), date('g:i', $endtimestamp), 
//				date('a', $endtimestamp), date('A', $endtimestamp));
}
