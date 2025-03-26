<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/authors.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$authors = new Authors($db);

//Authors Query
$result = $authors->read();
//Get row count
$num = $result->rowCount();

// Check if any authors
if ($num > 0) {
	//Authors array
	$authors_arr = array();
	//$authors_arr['data'] = array();

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$author_item = array( //fill array with data from the Authors object we read and stored in result
			"id" => $id,
			"author" => $author,
		);

		//Push to "data"
		array_push($authors_arr, $author_item); //push the author_item 2d array we made to the authors_arr array at the data index array
	}

	//Turn to JSON & output
	echo json_encode($authors_arr);

} else {
	//no Authors
	echo json_encode(
		array('message' => 'author_id Not Found')
	);
}

?>