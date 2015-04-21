<?php

$jsonResult = array(
	'flash' => $this->Session->flash(),
	'error' => isset($exceptionMessage) ? $exceptionMessage : false
		);
echo json_encode($jsonResult);