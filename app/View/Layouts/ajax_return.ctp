<?php
//Build a json array of all the elements we want to return to javascript ajax function
$jsonArray = array(
	'result' => $result,
	'flash' => $this->Session->flash()
);

//Echo the information from the view, which will add to the json array
echo $content_for_layout;

//Send the json array back to the javascript ajax function
echo json_encode($jsonArray);