<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu_en.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	require_once 'classes/ChairsWagnerCollectionEn.php';
	//header_remove("X-Powered-By");

	
	class ScauneColectiaWagner extends PageTemplate
	{
		public function execute()
		{
			$this->URLCheck();

			
			$collection = new ChairsWagnerCollectionEn($this->query);
			
			if($collection->getNextCollection() != NULL) 
			{
				$href_next_collection = 'en/Chairs-'.$collection->getNextCollection();
			}
			else
			{
				$href_next_collection = "en/Chairs-Topstar";
			}

			if($collection->getPrevCollection() != NULL) 
			{
				$href_prev_collection = 'en/Chairs-'.$collection->getPrevCollection();
			}
			else
			{
				$href_prev_collection = "en/Chairs-Quinti";
			}
			
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Href_prev_collection}' => $href_prev_collection,
				'{Href_next_collection}' => $href_next_collection,
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Meta_description}'=>$collection->getMetaDescription(),
				'{Page_content}' => $collection->getPageContent(),
				'{Page_title}'=>$collection->getPageTitle(),
				'{Canonical_URL}'=>$collection->getCanonicalURL(),
				'{OG_Image}'=>$collection->getOGImage()
				);
			$this->templateEngine->load($data, 'scaune_colectia_wagner_en.html');
		}
		private function URLCheck(){
		    header_remove("X-Powered-By");
			if(substr($_SERVER['REQUEST_URI'], -1) == '/')	
			{
			
				$without_slash = substr($_SERVER['REQUEST_URI'], 0, -1);
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: http://".$_SERVER['HTTP_HOST'].$without_slash); 
				exit();
			}
		}
	}
	
	$colectia_wagner = new ScauneColectiaWagner();
	$colectia_wagner->execute();
?>

