<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
	header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
	header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
	exit();
}

if ($method === 'POST') {
	$data = json_decode(file_get_contents("php://input"), true);
	if (isset($data['category'])) {
		require 'create.php';
	} else {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
	}
} else if ($method === 'GET') {
	if (isset($_GET['id'])) {
		require 'read_single.php';
	} else {
		require 'read.php';
	}
} else if ($method === 'PUT') {
	$data = json_decode(file_get_contents("php://input"), true);
	if (isset($data['category']) && isset($data['id'])) {
		require 'update.php';
	} else {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
	}
} else if ($method === 'DELETE') {
	$data = json_decode(file_get_contents("php://input"), true);
	if (isset($data['id'])) {
		require 'delete.php';
	} else {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
	}
} else {
	exit();}