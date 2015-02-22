<?php
App::uses('StorageObject', 'Model/StorageObjects');

/**
 * ObjectStorageObject provides dot notation read/write of stored object properties
 * 
 * The mirrors the behavior of Hash::extract()/insert() for arrays with 
 * SOME SIGNIFICANT LIMITATIONS .
 * - There are no conditional read/extracts 
 * - Wildcard searches have the limitations noted in the read() docblock
 * - Wildcard inserts are not supported
 * - Setting an element of an array stored in a property is not tested and probably doesn't work 
 *    - but your can set the property to equal a new array
 * 
 * HOWEVER 
 * if a property holds a pure array, full Hash::extract() syntax works in 
 * the dot-path after the search crosses into the array.
 *
 * @author dondrake
 */
class ObjectStorageObject extends StorageObject{
	
	public function __construct($data = NULL, $provided_data_type = NULL) {
		parent::__construct($data, $provided_data_type);
	}
	
	/**
	 * Read property data from the specified path
	 * 
	 * Recursively step down into the data to retrieve the specified data element
	 * At this point it can return 
	 * object->property->object->property... value 
	 * or 
	 * object->property...->array[][][][].... value 
	 * but once the trasition to array is made, we can't navigate back to objects
	 * 
	 * Object retrieval supports {n} and {s} wildcards but with some limitations. 
	 * If the wildcard occurs while in the object->property chain, it must be the 
	 * final search arguement. If the data heirarchy has trasistioned to an array 
	 * the usual rules for Hash::extract() apply.
	 * 
	 * Conditional search arguments are not allowed unless they fall after a 
	 * transition to an array
	 * 
	 * @param string $path
	 * @return mixed
	 */
	public function read($path = NULL) {
		if (is_null($path)) {
			return $this->data;
		}
		$properties = explode('.', $path);
		$property = array_shift($properties);
		return $this->retrieve($this->data, $property, $properties);
//		return $this->data->data->thing;
	}
	
	/**
	 * Return a specified node from the data heirarchy
	 * 
	 * @param mixed $parent_data The value at the current level in the data heirarchy
	 * @param string $child_node The next node to access from parent_data
	 * @param array $remaing_path The path to the final data node
	 * @return mixed The data discovered at the end of the path or NULL
	 */
	protected function retrieve($parent_data, $child_node, $remaing_path) {
		switch (gettype($parent_data)) {
			case 'string':
			case 'integer':
			case 'double':
			case 'NULL':
			case 'resource':
			case 'boolean':
				if (!empty($child_node) || !empty($remaing_path)) {
					return NULL;
				} else {
					return $parent_data;
				}
				break;
			case 'object':
				if (preg_match('/[{]/', $child_node)) {
					return $this->gatherProperitesThatMatchWildcard($parent_data, $child_node, $remaing_path);
				} else {
					return $this->retrieveProperty($parent_data, $child_node, $remaing_path);
				}
				break;
			case 'array':
				$data = new ArrayStorageObject($parent_data);
				$path = is_string($remaing_path) 
						? array($child_node, $remaing_path) 
						: array_merge(array($child_node), $remaing_path);
				return $data->read(implode('.', $path));
				break;
			default:
				return NULL;
		}
	}
	
	/**
	 * Continue the recursion into a deeper object->property level
	 * 
	 * @param object $object The current object in the data heirarchy
	 * @param string $property The property we need to extract from this object
	 * @param array $path The remaining path into the data heirarchy
	 * @return mixed
	 */
	protected function retrieveProperty($object, $property, $path) {
		if (property_exists($object, $property)) {
			if (count($path) === 0) {
				return $object->$property;
			} else {
				$object = $object->$property;
				$next_property = array_shift($path);
				return $this->retrieve($object, $next_property, $path);
			}
		} else {
			return NULL;
		}
	}
	
	/**
	 * Do a wildcard search of the current data heirarchy level
	 * 
	 * Object wildcard searches are allowed as the final search argument
	 * 
	 * This implements {n} number node and {s} string node searchs 
	 * approximating the capabilities of the array utility Hash::extract()
	 * 
	 * @param object $parent_data
	 * @param string $child_node_wildcard
	 * @param array $remaing_path
	 * @return mixed
	 */
	protected function gatherProperitesThatMatchWildcard($parent_data, $child_node_wildcard, $remaing_path) {
		$collecting_object = new stdClass();
		$count_of_matched_properties = 0;
		foreach($parent_data as $property_name => $property_value) {
			if ($this->_matchToken($property_name, $child_node_wildcard)) {
				$collecting_object->$property_name = $parent_data->$property_name;
				++$count_of_matched_properties;
			}
		}
		return (count($remaing_path) === 0 && $count_of_matched_properties > 0) ? $collecting_object : NULL;
//		$next_property = array_shift($remaing_path);
//		return $this->retrieve($collecting_object, $next_property, $remaing_path);
	}
	
	/**
	 * Check a key against a token.
	 *
	 * @param string $key The key in the array being searched.
	 * @param string $token The token being matched.
	 * @return boolean
	 */
	protected function _matchToken($key, $token) {
		if ($token === '{n}') {
			return is_numeric($key);
		}
		if ($token === '{s}') {
			return preg_match('/[a-zA-Z]/', $key[0]);
		}
		if (is_numeric($token)) {
			return ($key == $token);
		}
		return ($key === $token);
	}
	
	/**
	 * Write a value to a single node in the data heirarchy
	 * 
	 * No wildcards allowed. You can only write to one point. 
	 * But you can write any value. Even an object.
	 * 
	 * @param string $path
	 * @param mixed $value
	 */
	public function write($path, $value) {
		$path_node = explode('.', $path);
		
		// create a string that describes the property path:
		// $this->data->{$path_node[0]}->{$path_node[1]}
		$accumulated_property_statement = '$this->data';
		foreach ($path_node as $index => $ignore_value) {
			$accumulated_property_statement .= '->{$path_node['.$index.']}';
		}
		
		$reference_to_target = NULL;
		$assignment_statement = '$reference_to_target =& ' . $accumulated_property_statement . ';';
		eval($assignment_statement);
		
		$reference_to_target = $value;		
	}

}
