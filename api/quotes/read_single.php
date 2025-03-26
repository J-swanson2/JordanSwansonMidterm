<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/quotes.php';

//Instantiate DB & connect
$database = new Database();
$db = $database->connect();

//Instantiate Quotes object
$quotes = new Quotes($db);

//Get ID
$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get post
$quotes->read_single();

$quote_arr = array(
	"id" => $quotes->id,
	"quote" => $quotes->quote,
	"author" => $quotes->author,
	"category" => $quotes->category
);

//make json
print_r(json_encode($quote_arr));