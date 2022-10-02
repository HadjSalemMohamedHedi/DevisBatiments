<?php

	// Loader - class and connection
	include('loader.php');
	
	// Catch start, end and id from javascript
	$start = $_POST['start'];
	$end = $_POST['end'];
	$id = $_POST['id'];
	
	echo $calendar->update('false', $start, $end, $id);

?>