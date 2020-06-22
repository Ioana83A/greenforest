<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	require_once 'classes/ChairsCollection.php';
	//header_remove("X-Powered-By");

	
	class ScauneColectii extends PageTemplate
	{
		public function execute()
		{
			$this->URLCheck();
			$collection_seo_name = $_REQUEST['collection_seo_name'];
			
			$collection = new ChairsCollection($this->query, $collection_seo_name);
			
			if($collection->getNextCollection() != NULL) 
			{
				$href_next_collection = 'Scaune-'.$collection->getNextCollection();
			}
			else
			{
				$href_next_collection = "Scaune-Topstar";
			}

			if($collection->getPrevCollection() != NULL) 
			{
				$href_prev_collection = 'Scaune-'.$collection->getPrevCollection();
			}
			else
			{
				$href_prev_collection = "Scaune-Quinti";
			}
			
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Collection_name}' => 'Scaune '.$collection->getCollectionName(),
				'{Href_prev_collection}' => $href_prev_collection,
				'{Href_next_collection}' => $href_next_collection,
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Breadcrumb}'=>$collection->breadcrumb(),
		        '{Image}'=>$collection->getImage(),
				'{Link}'=>$collection->displayLink(),
				'{Collection_description}'=>$collection->getDescription(),
				'{Meta_description}'=>$collection->getMetaDescription(),
				'{Collection_seo_name_translated}'=>$collection->getTranslatedSeoName(),
				'{Page_title}'=>$collection->getPageTitle(),
				'{Canonical_URL}'=>$collection->getCanonicalURL(),
				'{OG_Image}'=>$collection->getOGImage()
				);
			$this->templateEngine->load($data, 'scaune_colectii.html');
		}
		private function URLCheck(){
		    header_remove("X-Powered-By");
			$collection_seo_name = $_REQUEST['collection_seo_name'];
			$this->query->execute("SELECT * FROM `collections` WHERE `seo_name_en` ='".$collection_seo_name."'");
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
	
	$colectii = new ScauneColectii();
	$colectii->execute();
?>

