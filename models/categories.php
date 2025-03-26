<?php
class Categories
{
	private $conn;
	private $table = 'categories';

	//Categories Properties
	public $id;
	public $category;

	public function __construct($db) {
		$this->conn = $db;
	}

	//Get Categories
	public function read() {
		//Create Query
		$query = 'SELECT
				id,
				category
			FROM
				' . $this->table;
		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//execute
		$stmt->execute();
		return $stmt;
	}

	public function read_single() {
		//Create Query
		$query = 'SELECT
				id,
				category
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
			$this->category = $row['category'];
		} else {
			echo json_encode(['message' => 'category_id Not Found']);
			exit();
		}
		$categories_arr = array(
			"id" => $this->id,
			"category" => $this->category
		);

		//make json
		print_r(json_encode($categories_arr));
	}

	public function create() {
		$query = 'INSERT INTO ' .
			$this->table . ' (category)
		VALUES
			(:category)';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//Clean Data
		$this->category = htmlspecialchars(strip_tags($this->category));

		$stmt->bindParam(':category', $this->category);

		//Execute Query
		if ($stmt->execute()) {
			$lastInsertId = $this->conn->lastInsertId();
			echo json_encode([
				"id" => $lastInsertId,
				"category" => $this->category
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
			category = :category
		WHERE
			id = :id';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//Clean Data
		$this->category = htmlspecialchars(strip_tags($this->category));
		$this->id = (int) htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(':category', $this->category);
		$stmt->bindParam(':id', $this->id);

		//Execute Query
		if ($stmt->execute()) {
			echo json_encode([
				"id" => $this->id,
				"category" => $this->category
			]);
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s.\n", $stmt->error);
		return false;
	}

	public function delete() {
		//Create Query
		$query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		$this->id = (int) htmlspecialchars(strip_tags($this->id));

		$stmt->bindParam(':id', $this->id);

		//Execute Query
		$stmt->execute();
		
	}
}
?>