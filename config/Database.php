<?php
Class Database{
	private $dsn = 'mysql:dbname=lbb_db;host:127.0.0.1';
	private $user = 'root';
	private $pass = '';
	public $conn;
	public function Connect($value='')
	{
		try{
			$this->conn = new PDO($this->dsn, $this->user, $this->pass);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(PDOException $ex){
			echo 'connection failed' . $ex->getMessage();
		}

		return $this->conn;
	}
}

