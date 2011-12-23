<?php
class ContentCollection extends AppModel {
	var $name = 'ContentCollection';

	var $belongsTo = array(
		'Content', 'Collection'
		);
}
?>