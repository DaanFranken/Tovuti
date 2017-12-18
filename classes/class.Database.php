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

	// Select from database
	public function selectDatabase($db, $tableName, $whereValue, $whereKey, $addon)
	{
		$query = 'SELECT * FROM '.$tableName;
		if(!empty($whereValue))
		{
			$query .= ' WHERE '.$whereValue.' = "'.$whereKey.'" ';
		}
		$sth = $db->prepare($query.$addon);
		$sth->execute();
		return $sth;
	}

	class selectDatabase
	{
		private string $query;
	}

	// Insert into database
	public function insertDatabase($db, $tableName, $arrayValues)
	{
		$query = 'INSERT INTO '.$tableName.' SET ';
		$i = 0;
		foreach($arrayValues as $key => $value)
		{
			if($i != 0)
			{
				$query .= ', ';
			}
			$query .= $key.' = "'.$value.'"';
			$i++;
		}
		$sth = $db->prepare($query);
		$sth->execute();
	}

	// Update the database
	public function updateDatabase($db, $tableName, $whereValue, $whereKey, $arrayValues)
	{
		$query = 'UPDATE '.$tableName.' SET ';
		$i = 0;
		foreach($arrayValues as $key => $value)
		{
			if($i != 0)
			{
				$query .= ', ';
			}
			$query .= $key.' = "'.$value.'"';
			$i++;
		}
		$query .= 'WHERE '.$whereValue.' = "'.$whereKey.'"';
		$sth = $db->prepare($query);
		$sth->execute();
	}

	// Delete from database
	public function deleteDatabase($db, $tableName, $whereValue, $whereKey)
	{
		$prepareParameters = array($parameters);
		$query = 'DELETE FROM '.$tableName;
		if(!empty($whereValue))
		{
			$query .= ' WHERE '.$whereValue.' = "'.$whereKey.'"';
		}
		$sth = $db->prepare($query);
		$sth->execute($prepareParameters);
	}
}
?>