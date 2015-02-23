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
	protected $sessions;
	
	public function __construct($storage_object) {
		$this->session_data = $storage_object;
		$this->sessions = new SessionIterator($this->session_data);
		
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
		$this->dates = new DateIterator(parent::current()->read('{n}'));
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
	
//	public function current() {
//		return parent::current();
//	}
	
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
	 * @param StorageObject $date_data
	 * @return int
	 */
	protected function timeSpan($date_data) {
		$starttimestamp = strtotime($date_data->read('date') . ' ' . $date_data->read('start_time'));
        $endtimestamp = strtotime($date_data->read('date') . ' ' . $date_data->read('end_time'));
		return $endtimestamp - $starttimestamp;
	}
	
}
