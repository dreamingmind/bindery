<?php
/* SVN FILE: $Id$ */
App::uses('Logger', 'Lib/Trait');

/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @version       $Revision$
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppModel extends Model {
	
	use Logger;

	var $actsAs = Array('Containable');
	
	/**
	 * Base name for cart data cache
	 * 
	 * Will have a key value appended to make it specific to a cache
	 * 
	 * typically this will be a model alias and will be coordinated with 
	 * many other bits of data that make up the cache. Path and group in 
	 * the config, as well as the config name will make most sense if 
	 * organized around a common string like the model alias
	 * 
	 * example config for a dataCache set to 'cart':
	 * Cache::config('cart', array(
	 *	'engine' => 'File',
	 *	'mask' => 0666,
	 *	'group' => array('cart'),
	 *	'path' => CACHE . 'cart' . DS,
	 *	'prefix' => 'bindery_',
	 *	'duration' => '+1 hour',
	 *	'serialize' => TRUE
	 * ));
	 *
	 * @var string 
	 */
	protected $dataCache;
	
	/**
	 * Name of the Cache config responsible for caches using $this->dataCache in thier name
	 *
	 * @var string 
	 */
	protected $dataCacheConfig;
	
	/**
	 * The result of reading a cache
	 *
	 * @var False|array The result of reading a cache
	 */
	protected $cachedData;

	/** 
	 * Debugging aid to show the last query
	 * 
	 * @return string
	 */
	function getLastQuery()
    {
        $dbo = $this->getDatasource();
        $logs = $dbo->getLog();
        $lastLog = end($logs['log']);
        return $lastLog['query'];
    }
	
	/**
	 * Retrieve a cache that's named for a query conditions array
	 * 
	 * @param array $conditions
	 * @return false|array
	 */
	public function readConditionsCache($conditions) {
		$hash = implode('/', $conditions);
		$cacheKey = "{$this->dataCache}_$hash";
		$this->cachedData = Cache::read($cacheKey, $this->dataCacheConfig);
		return $this->cachedData;
	}
	
	/**
	 * Write a cache named for the query conditions array
	 * 
	 * @param type $conditions
	 * @param type $data
	 */
	public function writeConditionsCache($conditions, $data) {
		$hash = implode('/', $conditions);
		$cacheKey = "{$this->dataCache}_$hash";
		Cache::write($cacheKey, $data, $this->dataCacheConfig);
	}
	
	
	/**
	 * Retrieve a cache that's named for the record id
	 * 
	 * eg: if dataCache = 'cart' we'll get a name like 
	 * bindery_cart.354 (bindery_ comes from cache config)
	 * 
	 * @param array $conditions
	 * @return false|array
	 */
	public function readIdCache($id) {
		$cacheKey = "{$this->dataCache}_$id";
		$this->cachedData = Cache::read($cacheKey, $this->dataCacheConfig);
		return $this->cachedData;
	}
	
	/**
	 * Write a cache named for the record id
	 * 
	 * eg: if dataCache = 'cart' we'll get a name like 
	 * bindery_cart.354 (bindery_ comes from cache config)
	 * 
	 * @param type $conditions
	 * @param type $data
	 */
	public function writeIdCache($id, $data) {
		$cacheKey = "{$this->dataCache}_$id";
		Cache::write($cacheKey, $data, $this->dataCacheConfig);
	}
	
	/**
	 * Delete a cache named for the record id
	 * 
	 * eg: if dataCache = 'cart' we'll get a name like 
	 * bindery_cart.354 (bindery_ comes from cache config)
	 * 
	 * @param string $id
	 * @param mixed $data
	 */
	public function deleteIdCache($id, $data) {
		$cacheKey = "{$this->dataCache}_$id";
		Cache::delete($cacheKey, $this->dataCacheConfig);
	}
}
?>