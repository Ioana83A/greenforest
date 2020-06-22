<?php

	class PageTemplate
	{
		protected $dbConnection;
		protected $query;
		protected $menu;
		protected $templateEngine;
	
		function __construct()
		{
			//session_start();
		
			$this->dbConnection = new DatabaseConnection();
			$this->dbConnection->connect();
			
			$this->query = new Query();
			$this->query->setMysqli($this->dbConnection->getMysqli());
			
			$this->menu = new Menu($this->query);
						
			$this->templateEngine = new TemplateEngine();
		}
		
		function __destruct()
		{
			$this->dbConnection->disconnect();
		}
		
}
?>