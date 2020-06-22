<?php

	class TemplateEngine
	{
		private $viewPath = "views/";
		private $viewContent;
	
		public function load($replaceTags, $viewFileName)
		{		
			$this->viewContent = file_get_contents($this->viewPath . $viewFileName);
			
			$this->viewContent = str_replace(array_keys($replaceTags), array_values($replaceTags), $this->viewContent);
			
			echo $this->viewContent;
		}
	}