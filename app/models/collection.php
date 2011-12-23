<?php
class Collection extends AppModel {
	var $name = 'Collection';

	var $hasMany = array(
		'ContentCollection'
            );

}
?>