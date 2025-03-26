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

//Get Author
$authors->read_single();

