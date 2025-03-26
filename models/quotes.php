<?php
class Quotes
{
	private $conn;
	private $table = 'quotes';

	//Quotes Properties
	public $id;
	public $quote;
	public $author_id;
	public $category_id;
	public $author;
	public $category;

	public function __construct($db) {
		$this->conn = $db;
	}

	//Get Quotes
	public function read() {
		//Create Query
		$query = 'SELECT
				a.author,
				c.category,
				q.id,
				q.quote
			FROM
				' . $this->table . ' q
			LEFT JOIN
				authors a ON q.author_id = a.id
			LEFT JOIN
				categories c ON q.category_id = c.id';
		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//execute
		$stmt->execute();
		return $stmt;
	}

	public function read_single() {
		//Create Query
		$query = 'SELECT
				a.author,
				c.category,
				q.id,
				q.quote
			FROM
				' . $this->table . ' q
			LEFT JOIN
				authors a ON q.author_id = a.id
			LEFT JOIN
				categories c ON q.category_id = c.id
			WHERE q.id = ?';
		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		// Bind ID
		$stmt->bindParam(1, $this->id);

		//execute
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		//if ID was not found, $row is false - so following will only execute if ID found
		if ($row) {
			$this->quote = $row['quote'];
			$this->author = $row['author'];
			$this->category = $row['category'];
			$this->id = $row['id'];
		} else {
			//no Author
			echo json_encode(['message' => 'No Quotes Found']);
			exit();
		}
	}

	public function create() {
		$query = 'INSERT INTO ' .
			$this->table . ' (quote, author_id, category_id)
		VALUES
			(:quote, :author_id, :category_id)';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//Clean Data
		$this->quote = htmlspecialchars(strip_tags($this->quote));
		$this->author_id = htmlspecialchars(strip_tags($this->author_id));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));

		$stmt->bindParam(':quote', $this->quote);
		$stmt->bindParam(':author_id', $this->author_id);
		$stmt->bindParam(':category_id', $this->category_id);

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
			quote = :quote,
			author_id = :author_id,
			category_id = :category_id
		WHERE
			id = :id';

		//Prepare Statement
		$stmt = $this->conn->prepare($query);

		//Clean Data
		$this->id = (int) htmlspecialchars(strip_tags($this->id));
		$this->quote = htmlspecialchars(strip_tags($this->quote));
		$this->author_id = htmlspecialchars(strip_tags($this->author_id));
		$this->category_id = htmlspecialchars(strip_tags($this->category_id));

		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':quote', $this->quote);
		$stmt->bindParam(':author_id', $this->author_id);
		$stmt->bindParam(':category_id', $this->category_id);

		//Execute Query
		if ($stmt->execute()) {
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
		if ($stmt->execute()) {
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s.\n", $stmt->error);
		return false;
	}
}
?>