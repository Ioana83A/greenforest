<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	require_once 'classes/Project.php';
	//header('Content-Type: text/html; charset=utf-8');
	//header_remove("X-Powered-By");
	
	class Proiecte extends PageTemplate
	{
		public function execute()
		{
			$this->URLCheck();
			$project_seo_name = $_REQUEST['project_seo_name'];
			
			$project = new Project($this->query, $project_seo_name);
			
			if($project->getNextProject() != NULL) 
			{
				$href_next_project = 'Proiect-'.$project->getNextproject();
			}
			else
			{
				$href_next_project = "#";
			}

			if($project->getPrevProject() != NULL) 
			{
				$href_prev_project = 'Proiect-'.$project->getPrevProject();
			}
			else
			{
				$href_prev_project = "#";
			}
			
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Project_name}' => $project->getProjectName(),
				'{Href_prev_project}' => $href_prev_project,
				'{Href_next_project}' => $href_next_project,
		        '{Slider_images}'=>$project->getSliderImages(),
				'{Project_description}'=>$project->getDescription(),
				'{Project_seo_name_translated}'=>$project->getTranslatedSeoName(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Preload_slider_images}'=>$project->getPreloadImages(),
				'{Meta_description}' => $project->getMetaDescription(),
				'{Canonical_URL}'=>$project->getCanonicalURL(),
				'{OG_Image}'=>$project->getOGImage()    	
			    );
			
			$this->templateEngine->load($data, 'proiecte.html');
		}
		private function URLCheck(){
		    header_remove("X-Powered-By");
			$project_seo_name = $_REQUEST['project_seo_name'];
			$this->query->execute("SELECT * FROM `projects` WHERE `seo_name` ='".$project_seo_name."'");
			if(!$this->query->result->num_rows) 
			{
				
				header('HTTP/1.0 404 Not Found', true, 404);
				readfile('page_not_found.php');
				exit();
				
			}
			else if(substr($_SERVER['REQUEST_URI'], -1) == '/')	
			{
			
				$without_slash = substr($_SERVER['REQUEST_URI'], 0, -1);
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: http://".$_SERVER['HTTP_HOST'].$without_slash); 
				exit();
			}
		}
	}
	
	$proiecte = new Proiecte();
	$proiecte->execute();
?>

