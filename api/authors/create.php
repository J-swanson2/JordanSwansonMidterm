<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/authors.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate authors object
$authors = new authors($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$authors->author = $data->author;

//Create author
$authors->create();