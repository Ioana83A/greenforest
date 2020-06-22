<?php

	class Query
	{
		private $mysqli;
		private $query;
		public $result;
		public $insertId;
		
		public function setMysqli($mysqli)
		{
			$this->mysqli = $mysqli;
		}
		
		public function execute($sql)
		{
			$result = $this->mysqli->query($sql);
			
			if($result)
			{
				$this->result = $result;
				$this->insertId = $this->mysqli->insert_id;
			}
			else
			{
				throw new Exception($this->mysqli->error);
			}
		}
		
		public function freeResult()
		{
			$this->result->free();
		}
	}

?>
