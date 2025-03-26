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
	if (isset($_POST['quote']) && isset($_POST['authoor_id']) && isset($_POST['category_id'])) {
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
	if (isset($_PUT['quote']) && isset($_PUT['authoor_id']) && isset($_PUT['category_id'])) {
		require 'update.php';
	} else {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
	}
} else if ($method === 'DELETE') {
	if (isset($_DELETE['id'])) {
		require 'delete.php';
	} else {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
	}
} else {
	exit();}