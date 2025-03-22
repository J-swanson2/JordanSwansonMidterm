<?php
class Post
{
	private $conn;
	private $table = 'authors';

	//Authors Properties
	public $id;
	public $author;

	PUBLIC FUNCTION __CONSTRUCT($db){
		$this->conn = $db;
	}

	//Get Authors
	public function read(){
		//Create Query
		$query = 'SELECT
				id,
				author
			FROM
				' . $this->table;
		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//execute
		$stmt->execute();
		return $stmt;
	}
}
?>