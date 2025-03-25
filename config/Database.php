<?php
class Database
{
	private $host;
	private $port;
	private $db_name;
	private $username;
	private $password;
	private $conn;

	public function __construct() { //load enviornment variables
		$this->host = getenv('HOST');
		$this->port = getenv('PORT');
		$this->db_name = getenv('DBNAME');
		$this->username = getenv('USERNAME');
		$this->password = getenv('PASSWORD');
	}

	public function connect() {
		//if ($this->conn) {
		//	return $this->conn;
		//} else {
		$this->conn = null;

			$dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name};";

			try { //set conn to a PDO that connects to database and returns it.
				$this->conn = new PDO($dsn, $this->username, $this->password);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //not sure what this does
				return $this->conn;
			} catch (PDOException $e) {
				echo 'Connection Error: ' . $e->getMessage();
			//}
		}
	}
}
?>