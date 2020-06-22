<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu_en.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	require_once 'classes/Category_en.php';
	
	//header('Content-Type: text/html; charset=utf-8');
	//header_remove("X-Powered-By");
	
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
			
			$category = new Category($this->query,$category_seo_name,$subcateg_seo_name, $collection_seo_name,$product_seo_name);
			if($category->getNextCategory() != NULL) 
			{
				$href_next_category = 'en/'.$category->getNextCategory().'#scroll';
			}
			else
			{
				$href_next_category = "#scroll";
			}

			if($category->getPrevCategory() != NULL) 
			{
				$href_prev_category = 'en/'.$category->getPrevCategory().'#scroll';
			}
			else
			{
				$href_prev_category = "#scroll";
			}
			
			$link = '<a style="display:none" href="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'">link</a>';
			
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Category_name}'=>$category->getCategoryName(),
				'{Produse}' => $category->displayCategoryProducts(),
				'{Produse_Small_Screen}' => $category->displayCategoryProductsSmallScreen(),
				'{Product_titles}' => $category->displayProductTitles(),
				'{Href_prev_category}' => $href_prev_category,
				'{Href_next_category}' => $href_next_category,
				'{Subcategories}' => $category->displaySubcategories(),
				'{Breadcrumb}'=>$category->breadcrumb(),
				'{Offset}' => isset($_REQUEST['offset'])?$_REQUEST['offset']:0,
				'{Page}' =>$category->displayPage(),
				'{Product_info}'=>$category->getProductInfo(),
				'{Meta_description}'=>$category->getMetaDescription(),
				'{Category_seo_name_translated}'=>$category->getCategorySeoNameTranslated(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Page_title}' => $category->getPageTitle()	,
				'{Canonical_URL}'=>$category->getCanonicalURL(),
				'{OG_Image}'=>$category->getOGImage()	    	
		        );
			
			$this->templateEngine->load($data, 'produse_en.html');
		}
		
		private function URLCheck(){
		    header_remove("X-Powered-By");
			
			$category_seo_name = $_REQUEST['category_seo_name'];
			$this->query->execute("SELECT * FROM `categories` WHERE `seo_name_en` = '".$category_seo_name."'");
			if(!$this->query->result->num_rows)
			{ 
				header('HTTP/1.0 404 Not Found', true, 404);
				readfile('page_not_found.php');
				exit();
			}
			
			
			if($category_seo_name!="Chairs")
			{
				if(isset($_REQUEST['collection_seo_name']))
				{
					$collection_seo_name = $_REQUEST['collection_seo_name'];
					$this->query->execute("SELECT * FROM `collections` WHERE `seo_name_en` = '".$collection_seo_name."'");
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
					$this->query->execute("SELECT * FROM `categories` WHERE `seo_name_en` = '".$subcateg_seo_name."'");
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
					$this->query->execute("SELECT * FROM `categories` WHERE `seo_name_en` = '".$subcateg_seo_name."'");
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
				$this->query->execute("SELECT * FROM `products` WHERE `seo_name_en` = '".$product_seo_name."'");
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

