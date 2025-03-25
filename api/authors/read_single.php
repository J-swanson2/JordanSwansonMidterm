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

//Get ID
$authors->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$authors->read_single();

$authors_arr = array(
	'id' => $authors->id,
	'author' => $authors->author
);

//make json
print_r(json_encode($authors_arr));