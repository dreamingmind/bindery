<?php
	$result = array(
		'flash' => $this->Session->flash(),
		'contact_block' => $this->element('Cart/contact_review_dynamic')
	);
	
	echo json_encode($result);