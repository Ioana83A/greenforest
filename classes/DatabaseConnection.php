<?php

    class DatabaseConnection
    {
        private $mysqli;
        private $hostname, $username, $password, $database;

        public function __construct()
        {			
                $this->mysqli = mysqli_init();			
        }

        public function connect()
        {	
                $this->loadConfig();

                $this->mysqli->real_connect($this->hostname, $this->username, $this->password, $this->database);
				
                if($this->mysqli->connect_errno)
                {
                        throw new Exception(mysqli_connect_error());
                }
				$this->mysqli->set_charset("utf8");
        }

        private function loadConfig()
        { 
                $config = Config::db_connection_parameters();

                $this->hostname = $config['hostname'];
                $this->username = $config['username'];
                $this->password = $config['password'];
                $this->database = $config['database'];
        }		

        public function disconnect()
        {
                $this->mysqli->close();
        }

        public function getMysqli()
        {
            return $this->mysqli;
        }
    }
?>