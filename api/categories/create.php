<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/categories.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate categories object
$categories = new categories($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$categories->id = $data->id;
$categories->category = $data->category;

//Create category
if ($categories->create()) {
	echo json_encode(
		array('message' => 'Author Created')
	);
} else {
	echo json_encode(
		array('message' => 'Author Not Created')
	);
}