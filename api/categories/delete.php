<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/categories.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Categories object
$categories = new Categories($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$categories->id = $data->id;

if (isset($data->id)) {
	// Set ID to delete
	$categories->id = $data->id;
	if ($categories->delete()) {
		echo json_encode(
			["id" => $categories->id]
		);
	} else {
		echo json_encode(
			array('message' => 'No category_id Found')
		);
	}
} else {
	echo json_encode(['message' => 'Missing Required Parameters']);
}
