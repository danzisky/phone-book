<?php

class Dbh {
	private $host = "remotemysql.com";
	private $user = "vwzVHW3qDo";
	private $pwd = "3dcG4pv6Lp";
	private $dbName = "vwzVHW3qDo";
	
	protected function connect() {
		$dsn = 'mysql:host='.$this->host.';dbname='.$this->dbName; 
		try {
			//$dbh = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $user, $password));
			$pdo = new PDO($dsn, $this->user, $this->pwd);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
			exit();
		}
		//$pdo = new PDO($dsn, $this->user, $this->pwd);
		//$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		//return $pdo;

		if(!isset($e)) {
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $pdo;
		} elseif (isset($e)) {
			echo 'Could not return the object: ' . $e->getMessage();
		}
	}
}