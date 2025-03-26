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

			$quote_arr = array(
				"id" => $this->id,
				"quote" => $this->quote,
				"author" => $this->author,
				"category" => $this->category
			);
			//make json
			print_r(json_encode($quote_arr));
		} else {
			//no Quote
			echo json_encode(['message' => 'No Quotes Found']);
			exit();
		}
	}

	public function create() {
		$this->checkID(); //Check the categoy and author ID's to make sure they exist

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
			$lastInsertId = $this->conn->lastInsertId();
			echo json_encode([
				"id" => $lastInsertId,
				"quote" => $this->quote,
				"author_id" => $this->author_id,
				"category_id" => $this->category_id
			]);
			return true;
		}
		//Print error if something goes wrong
		printf("Error: %s.\n", $stmt->error);
		return false;
	}

	public function update() {
		$this->checkID(); //Check the categoy and author ID's to make sure they exist

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
		$stmt->execute();

		if ($stmt->rowCount() > 0){
			echo json_encode([
				"id" => $this->id,
				"quote" => $this->quote,
				"author_id" => $this->author_id,
				"category_id" => $this->category_id
			]);
			} else {
				//no Quote
				echo json_encode(['message' => 'No Quotes Found']);
				exit();
			}	
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
		if ($stmt->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function checkID(){
		//Check if Author ID exists
		$query = 'SELECT id FROM authors
					WHERE id = :author_id';
		//prepare Statement
		$stmt = $this->conn->prepare($query);
		//Clean Data
		$this->author_id = htmlspecialchars(strip_tags($this->author_id));
		//bind parameter
		$stmt->bindParam(':author_id', $this->author_id);
		//execute statement
		$stmt->execute();

		//Check if author exists, if not then return message and exit
		if ($stmt->rowCount() == 0){
			echo json_encode(['message' => 'author_id Not Found']);
			exit();
		}

		//Check if Category ID exists
		$query = 'SELECT id FROM categories
					WHERE id = :category_id';
		//prepare Statement
		$stmt = $this->conn->prepare($query);
		//Clean Data
		$this->author_id = htmlspecialchars(strip_tags($this->author_id));
		//bind parameter
		$stmt->bindParam(':category_id', $this->category_id);
		//execute statement
		$stmt->execute();

		//Check if category exists, if not then return message and exit
		if ($stmt->rowCount() == 0) {
			echo json_encode(['message' => 'category_id Not Found']);
			exit();
		}
	}
}
?>