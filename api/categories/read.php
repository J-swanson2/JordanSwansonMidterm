<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/categories.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate categories object
$categories = new Categories($db);

//Categories Query
$result = $categories->read();
//Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0) {
	//Categories array
	$categories_arr = array();
	//$categories_arr['data'] = array();

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$category_item = array( //fill array with data from the Categories object we read and stored in result
			"id" => $id,
			"category" => $category,
		);

		//Push to "data"
		array_push($categories_arr, $category_item); //push the category_item array we made to the categories_arr array
	}

	//Turn to JSON & output
	echo json_encode($categories_arr);

} else {
	//no categories
	echo json_encode(
		array('message' => 'category_id Not Found')
	);
}

?>