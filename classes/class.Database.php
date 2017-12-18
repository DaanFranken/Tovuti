<?php

class Database
{
	private $host = 'localhost';
	private $database = 'tovuti';
	private $username = 'root';
	private $pass = '';
	public $conn;

	public function __construct()
	{
		try 
		{
		    $this->conn = new PDO("mysql:host=localhost;dbname=tovuti", $this->username, $this->pass);
		    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $this->conn->prepare("USE tovuti")->execute(array());
		}
		catch(PDOException $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
	}

	public function getDB()
	{
		return $this->conn;
	}
}
?>