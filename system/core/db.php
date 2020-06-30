<?php
/**
 * Common Functions
 *
 * Loads the base classes and executes the request.
 *
 * @package		Followin
 * @subpackage	Followin Super Class
 * @category	Core Functions
 * @author		Analitica Innovare Dev Team
 */

class Db {
	
	private $kdm;
	
	public function __construct() {
		
		$this->hostname = DB_HOST;
		$this->username = DB_USER;
		$this->password = DB_PASS;
		$this->database = DB_NAME;
		
		if($this->kdm == null) {
			$this->kdm = $this->db_connect($this->hostname, $this->username, $this->password, $this->database);
		}
	}
	public function get_database(){
		return $this->kdm;
	}

	private function db_connect($hostname, $username, $password, $database) {
		
		try {
			$this->conn = "mysql:host=$hostname; dbname=$database; charset=utf8mb4";
			
			$kdm = new PDO($this->conn, $username, $password);
			$kdm->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$kdm->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_BOTH);
			$kdm->setAttribute(PDO::MYSQL_ATTR_FOUND_ROWS, TRUE);
			
			return $kdm;
			
		} catch(PDOException $e) {
			die("It seems there was an error.  Please refresh your browser and try again. ".$e->getMessage());
		}
		
	}

	public function query($sql) {
		
		try {
					
			$stmt = $this->kdm->prepare("$sql");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results;
		
		} catch(PDOException $e) {return 0;}
	}

	public function execute($sql) {
		
		try {
			$stmt = $this->kdm->prepare("$sql");
			$stmt->execute();
		} catch(PDOException $e) {return 0;}
	}
	
}