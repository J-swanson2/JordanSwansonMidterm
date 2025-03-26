<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/categories.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate categories object
$categories = new Categories($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$categories->id = $data->id;

$categories->category = $data->category;

//Update categories
if ($categories->update()) {

	$categories->read_single();
	//echo json_encode(
		//array('message' => 'Category Update')
	//);
} //else {
	//echo json_encode(
		//array('message' => 'Category Not Updated')
	//);
//}
