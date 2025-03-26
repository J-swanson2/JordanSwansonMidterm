<?php
class Authors
{
	private $conn;
	private $table = 'authors';

	//Authors Properties
	public $id;
	public $author;

	public function __construct($db){
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

	public function read_single(){
		//Create Query
		$query = 'SELECT
				id,
				author
			FROM
				' . $this->table . 
				' WHERE id = ?';
		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		// Bind ID
		$stmt->bindParam(1, $this->id);

		//execute
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->author = $row['author'];
		//return $stmt;
	}

	public function create(){
		$query = 'INSERT INTO ' .
			$this->table . ' (author)
		VALUES
			(:author)';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//Clean Data
		$this->author = htmlspecialchars(strip_tags($this->author));
		
		$stmt->bindParam(':author', $this->author);

		//Execute Query
		if ($stmt->execute()) {
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s.\n", $stmt->error);
		return false;
	}

	public function update() {
		$query = 'UPDATE ' .
			$this->table . '
		SET
			author = :author
		WHERE
			id = :id';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//Clean Data
		$this->author = htmlspecialchars(strip_tags($this->author));
		$this->id = (int)htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(':author', $this->author);
		$stmt->bindParam(':id', $this->id);

		//Execute Query
		if ($stmt->execute()) {
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s.\n", $stmt->error);
		return false;
	}

	public function delete(){
		//Create Query
		$query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		$this->id = (int)htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(':id', $this->id);

		//Execute Query
		if ($stmt->execute()) {
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s.\n", $stmt->error);
		return false;
	}
}
?>