<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate quotes object
$quotes = new Quotes($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$quotes->id = $data->id;

$quotes->quote = $data->quote;
$quotes->author_id = $data->author_id;
$quotes->category_id = $data->category_id;

//Update quotes
if ($quotes->update()) {
	echo json_encode(
		array('message' => 'Category Update')
	);
} else {
	echo json_encode(
		array('message' => 'Category Not Updated')
	);
}
