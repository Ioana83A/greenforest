<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu_en.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	require_once 'classes/Collection_en.php';
	//header('Content-Type: text/html; charset=utf-8');
	//header_remove("X-Powered-By");
	
	class Colectii extends PageTemplate
	{
		public function execute()
		{
			$this->URLCheck();
			
			$collection_seo_name = $_REQUEST['collection_seo_name'];
			
			if(isset($_REQUEST['subcollection_seo_name']))
			{
				$subcollection_seo_name = $_REQUEST['subcollection_seo_name'];	 
		    }
			else
			{
				$subcollection_seo_name = NULL;
			}
			$collection = new Collection($this->query, $collection_seo_name, $subcollection_seo_name);
			
			if($collection->getNextCollection() != NULL) 
			{
				$href_next_collection = 'en/'.$collection->getNextCollection()."-furniture-collection";
			}
			else
			{
				$href_next_collection = 'en/ErgoPlus-furniture-collection';
			}

			if($collection->getPrevCollection() != NULL) 
			{
				$href_prev_collection = 'en/'.$collection->getPrevCollection()."-furniture-collection";
			}
			else
			{
				$href_prev_collection = 'en/Movi-furniture-collection';
			}
			
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Collection_name}' => $collection->getCollectionName(),
				'{Href_prev_collection}' => $href_prev_collection,
				'{Href_next_collection}' => $href_next_collection,
				'{Subcollections}' => $collection->displaySubcollections(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Breadcrumb}'=>$collection->breadcrumb(),
		        '{Slider_images}'=>$collection->getSliderImages(),
				'{Collection_description}'=>$collection->getDescription(),
				'{Collection_seo_name_translated}'=>$collection->getTranslatedSeoName(),
				'{Catalog}'=>$collection->getCatalog(),
				'{Page_title}'=>$collection->getPageTitle(),
				'{Preload_slider_images}'=>$collection->getPreloadImages(),
				'{Meta_description}'=>$collection->getMetaDescription(),
				'{Link_ro}'=>$collection->getLinkRo(),
				'{Canonical_URL}'=>$collection->getCanonicalURL(),
				'{OG_Image}'=>$collection->getOGImage(),
			    );
			
			$this->templateEngine->load($data, 'colectii_en.html');
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
	
	$colectii = new Colectii();
	$colectii->execute();
?>

