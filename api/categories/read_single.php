<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/categories.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate categories object
$categories = new Categories($db);

//Get ID
$categories->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$categories->read_single();


