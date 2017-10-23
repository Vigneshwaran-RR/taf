<?php

class DBH
{
	protected $connection;

	// Connects to Database
	public function getConnection()
	{
		$this->connection = mysqli_connect(CONFIG::DBHOSTNAME, CONFIG::DBUSERNAME, CONFIG::DBPASSWORD, CONFIG::DBNAME);
		if(mysqli_error($this->connection) == "")
			return true;
		return false;
	}

	// Executes given Query
	public function execQuery($query)
	{
		$result = $this->connection->query($query);
		$ret = Array();
		if($result)
		{
			while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
				$ret[] = $row;
			}		
			mysqli_free_result($result);
		}

		return $ret;
	}

	// Executes given Update Query - no return data
	public function execUpdateQuery($query)
	{
		$result = $this->connection->query($query);
		if(mysqli_error($this->connection) != "")
			throw New Exception(mysqli_error($this->connection));

		return true;
	}

}
