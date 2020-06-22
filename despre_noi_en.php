<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu_en.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	//header('Content-Type: text/html; charset=utf-8');
	//header_remove("X-Powered-By");
	
	class AboutUs extends PageTemplate
	{
		public function execute()
		{
			$this->URLCheck();
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Slider_images}'=>$this->getSliderImages(),
				'{Text}'=>$this->getText(),
				'{Subcategorii}'=>$this->getSubcategories(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Preload_slider_images}'=>$this->getPreloadImages(),
				'{Page_title}'=>$this->getPageTitle(),
				'{Canonical_URL}'=>$this->getCanonicalURL(),
				'{OG_Image}'=>$this->getOGImage(),
				'{Meta_description}'=>$this->getMetaDesc()			    	
			    );
			
			$this->templateEngine->load($data, 'despre_noi_en.html');
		}
		
		private function getImage(){
		
		    $this->query->execute("SELECT `image` FROM `about_us` WHERE `id`=1");
		    $row= $this->query->result->fetch_object();
		  
		    return $row->image;
		}
		
		private function getText()
		{
			$this->query->execute("SELECT * FROM `about_us` WHERE `id`=1");
			$row= $this->query->result->fetch_object();
			if(!isset($_REQUEST['category']))
			{
				return $row->about_us;
			}
			else
			{
				switch($_REQUEST['category']) 
				{
					case 'despre_noi': return $row->about_us_en;
					                 break;
					case 'referinte': return $row->refferences_en;
					                 break;
					case 'politica': $text= $row->politics_en;
					                 $text .='<div id="certificate"><a href="certificate/iso9001_june_2015.zip" target="_blank" >&#149; Quality certificate </a><br/>
									           <a href="certificate/iso14001_en.zip" target="_blank" >&#149; Environmental certificate </a><br/></div><div class="clear_box"></div>
											  '; 
									return $text;
					                 break;	
					case 'finantari':return $this->getProjects();
					                 break;			
				}
			}
		}
		
		private function getSubcategories(){
			if(!isset($_REQUEST['category']))
				{
					return '<div id="subcategories_outer"><div id="subcategories_inner"><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory" href="en/About-us" style="color:#66987b">About us</a></h1> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a 	 class="subcategory" href="en/About-us/references">References</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="en/About-us/politics">Politics</a></div>';
				}
				else
				{
					switch($_REQUEST['category']) 
					{
						case 'despre_noi': return '<div id="subcategories_outer"><div id="subcategories_inner"><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory" href="en/About-us" style="color:#66987b">About us</a></h1> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="en/About-us/references">References</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="en/About-us/politics">Politics</a></div>';
						break;
						
						case 'referinte': return '<div id="subcategories_outer"><div id="subcategories_inner"><a class="subcategory" href="en/About-us" >About us</a></span> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory" href="en/About-us/references" style="color:#66987b">References</a> </h1><span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="en/About-us/politics">Politics</a></div>';
						                break;
						
						case 'politica':  return '<div id="subcategories_outer"><div id="subcategories_inner"><a class="subcategory" href="en/About-us" >About us</a></span> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="en/About-us/references" >References</a><span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory" href="en/About-us/politics" style="color:#66987b">Politics</a></h1></div>';
						                break;
					  			
					}
				}
		}

		private function getPageTitle(){
			if(!isset($_REQUEST['category']))
			{
				return "About us";
			}
			else
			{
				switch($_REQUEST['category']) 
				{
					case 'despre_noi': return "About us";
									   break;
					case 'referinte':  return "References";
									   break;
					case 'politica':   return "Politics";
									   break;				
				}
			}
		}
		private function getMetaDesc(){
			if(!isset($_REQUEST['category']))
			{
				return "GreenForest has been designing and manufacturing office furniture since 1992 and has become one of the most important companies in the field from Romania.";
			}
			else
			{
				switch($_REQUEST['category']) 
				{
					case 'despre_noi': return "GreenForest has been designing and manufacturing office furniture since 1992 and has become one of the most important companies in the field from Romania.";
									   break;
					case 'referinte':  return "About-us - References";
									   break;
					case 'politica':   return "GreenForest mission is to provide professional furnishing solutions that are created according to the wellness and sustainability principles.";
									   break;				
				}
			}
		}
		
		
		private function getSliderImages(){
            $this->query->execute("SELECT * FROM `about_us` ");
			$row= $this->query->result->fetch_object();
			if($_REQUEST['category'] == 'referinte')
			{
				$images = '<ul class="bxslider"><img class="slider1_image" src="images/slider_1/'.$row->references_image_1.'" alt="References, img1"/>
				<img class="slider1_image" src="images/slider_1/'.$row->references_image_2.'" alt="References, img2"/></ul>';
			}
			else
			{
			
				$images = '<ul class="bxslider"><img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1_en.'"/>
				<img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2_en.'"/>';
				if($row->image_3 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3_en.'"/>';
				if($row->image_4 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4_en.'"/>';
				if($row->image_5 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5_en.'"/>';
				if($row->image_6 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6_en.'"/>';
				$images .= '</ul>';
			}
			
			return $images;
		}
		public function getPreloadImages(){
			
            $this->query->execute("SELECT * FROM `about_us` ");
			$row= $this->query->result->fetch_object();
			if($_REQUEST['category'] == 'referinte')
			{
				$preload = '$.preload("images/slider_1/'.$row->references_image_1.'");
							$.preload("images/slider_1/'.$row->references_image_2.'")';
			}
			else
			{
				$preload = ' $.preload("images/slider_1/'.$row->image_1.'");
							 $.preload("images/slider_1/'.$row->image_2.'");';
				if($row->image_3 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_3.'");';
				if($row->image_4 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_4.'");';
				if($row->image_5 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_5.'");';
				if($row->image_6 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_6.'");';
			}
			return $preload;
		}
		private function getCanonicalURL(){
			if(!isset($_REQUEST['category']))
			{
				$category = "";
			}
			else
			{
				switch($_REQUEST['category']) 
				{
					case 'despre_noi': $category ="";
									   break;
					case 'referinte':  $category ="/references";
									   break;
					case 'politica':   $category ="/politics";
									   break;				
				}
			}
			return 'http://www.greenforest.ro/en/About-us'.$category;
		}
		private function getOGImage(){
			 $this->query->execute("SELECT * FROM `about_us` ");
			 $row= $this->query->result->fetch_object();
			 return $row->image_1;
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
	
	$about_us = new AboutUs();
	$about_us->execute();

?>
