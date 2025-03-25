<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate categories object
$quotes = new Quotes($db);

//Quotes Query
$result = $quotes->read();
//Get row count
$num = $result->rowCount();

// Check if any quotes
if ($num > 0) {
	//Quotes array
	$quotes_arr = array();
	$quotes_arr['data'] = array();

	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		extract($row);

		$quote_item = array( //fill array with data from the Categories object we read and stored in result
			'id' => $id,
			'quote' => $quote,
			'author' => $author,
			'category' => $category
		);

		//Push to "data"
		array_push($quotes_arr['data'], $quote_item); //push the quote_item 2d array we made to the quotes_arr array at the data index array
	}

	//Turn to JSON & output
	echo json_encode($quotes_arr);

} else {
	//no posts
	echo json_encode(
		array('message' => 'No Quotes Found')
	);
}

?>