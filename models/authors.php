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

	//GET Authors
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

	//GET needing a single ID parameter
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
		
		//if ID was not found, $row is false - so following will only execute if ID found
		if ($row) {
			$this->author = $row['author'];
			$authors_arr = array(
				"id" => $this->id,
				"author" => $this->author
			);

			//make json
			print_r(json_encode($authors_arr));
		} else {
			//no Author
			echo json_encode(['message' => 'author_id Not Found']);
		}
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
			$lastInsertId = $this->conn->lastInsertId();
			echo json_encode([
				"id" => $lastInsertId,
				"author" => $this->author
			]);
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
			echo json_encode([
				"id" => $this->id,
				"author" => $this->author
			]);
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
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return true;  
		} else {
			return false;  
		}
		
	}
	
	
}
?>