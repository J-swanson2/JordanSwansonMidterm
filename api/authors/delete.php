<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/authors.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Authors object
$authors = new Authors($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if(isset($data->id)){
	// Set ID to delete
	$authors->id = $data->id;
	if($authors->delete()){
		echo json_encode(
				["id" => $authors->id]
			);
	} else {
		echo json_encode(
				array('message' => 'No author_id Found')
			);
	} 
} else {
		echo json_encode(['message' => 'Missing Required Parameters']);
	}


