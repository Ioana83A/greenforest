<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	
	//$produse->URLCheck();
	require_once 'classes/Chairs.php';
	
	
	class Produse extends PageTemplate
	{
		public function execute()
		{
			
			$this->URLCheck();
			$category_seo_name = $_REQUEST['category_seo_name'];
			
			if(isset($_REQUEST['collection_seo_name']))
			{
				$collection_seo_name = $_REQUEST['collection_seo_name'];
			}
			else
			{
				
				$collection_seo_name = NULL;
			}
			
			if(isset($_REQUEST['subcategory_seo_name']))
			{
				$subcateg_seo_name = $_REQUEST['subcategory_seo_name'];	 
		    }
			else
			{
				$subcateg_seo_name = NULL;
			}
			if(isset($_REQUEST['product_seo_name']))
			{
				$product_seo_name = $_REQUEST['product_seo_name'];	 
		    }
			else
			{
				$product_seo_name = NULL;
			}
			
			$chairs = new Chairs($this->query,$category_seo_name,$subcateg_seo_name, $collection_seo_name,$product_seo_name);
			
			
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Category_name}'=>$chairs->getCategoryName(),
				'{Page_content}' => $chairs->displayPageContent(),			
				'{Meta_description}'=>$chairs->getMetaDescription(),				
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Page_title}'=>$chairs->getPageTitle(),
				'{Category_description}'=>$chairs->getCategoryDescription(),
				'{Canonical_URL}'=>$chairs->getCanonicalURL(),
				'{OG_Image}'=>$chairs->getOGImage()				
		        );
			
			$this->templateEngine->load($data, 'scaune.html');
		}
		
		private function URLCheck(){
		    header_remove("X-Powered-By");
			
			$category_seo_name = $_REQUEST['category_seo_name'];
			$this->query->execute("SELECT * FROM `categories` WHERE `seo_name` = '".$category_seo_name."'");
			if(!$this->query->result->num_rows)
			{ 
				header('HTTP/1.0 404 Not Found', true, 404);
				readfile('page_not_found.php');
				exit();
			}
			
			
			if($category_seo_name!="Scaune")
			{
				if(isset($_REQUEST['collection_seo_name']))
				{
					$collection_seo_name = $_REQUEST['collection_seo_name'];
					$this->query->execute("SELECT * FROM `collections` WHERE `seo_name` = '".$collection_seo_name."'");
					if(!$this->query->result->num_rows){ 
						header('HTTP/1.0 404 Not Found', true, 404);
						readfile('page_not_found.php');
						exit();
					}
				}
				else
				{
					header('HTTP/1.0 404 Not Found', true, 404);
					readfile('page_not_found.php');
					exit();
				}
				if(isset($_REQUEST['subcategory_seo_name']))
				{
					$subcateg_seo_name = $_REQUEST['subcategory_seo_name'];	
					$this->query->execute("SELECT * FROM `categories` WHERE `seo_name` = '".$subcateg_seo_name."'");
					if(!$this->query->result->num_rows) { 
						header('HTTP/1.0 404 Not Found', true, 404);
						readfile('page_not_found.php');
						exit();
					}
				}
			}
			else
			{
				if(isset($_REQUEST['subcategory_seo_name']))
				{
					$subcateg_seo_name = $_REQUEST['subcategory_seo_name'];	
					$this->query->execute("SELECT * FROM `categories` WHERE `seo_name` = '".$subcateg_seo_name."'");
					if(!$this->query->result->num_rows) { 
						header('HTTP/1.0 404 Not Found', true, 404);
						readfile('page_not_found.php');
						exit();
					}
				}
				else
				{
					header('HTTP/1.0 404 Not Found', true, 404);
					readfile('page_not_found.php');
					exit();
				}
			}
			
			
			if(isset($_REQUEST['product_seo_name']))
			{
				$product_seo_name = $_REQUEST['product_seo_name'];	 
				$this->query->execute("SELECT * FROM `products` WHERE `seo_name` = '".$product_seo_name."'");
				if(!$this->query->result->num_rows)  { 
					header('HTTP/1.0 404 Not Found', true, 404);
					readfile('page_not_found.php');
					exit();
				}
		 	}
			
			if(substr($_SERVER['REQUEST_URI'], -1) == '/')	
			{
			
				$without_slash = substr($_SERVER['REQUEST_URI'], 0, -1);
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: http://".$_SERVER['HTTP_HOST'].$without_slash); 
				exit();
			}
		
		}
		
	}
	
	$produse = new Produse();
	$produse->execute();

?>