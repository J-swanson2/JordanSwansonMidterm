<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Quotes object
$quotes = new Quotes($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$quotes->id = $data->id;

//Delete Category
if ($quotes->delete()) {
	echo json_encode(
		array(["id" => $quotes->id])
	);
} else {
	echo json_encode(
		array('message' => 'No Quotes Found')
	);
}
