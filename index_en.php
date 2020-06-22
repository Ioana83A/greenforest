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
	
	class Index extends PageTemplate
	{
		public function execute()
		{
			$this->URLCheck();
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Slider_images}'=>$this->getSliderImages(),
				'{Text}'=>$this->getDescription(),
				'{Preload_slider_images}'=>$this->getPreloadImages(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Canonical_URL}'=>$this->getCanonicalURL(),
				'{OG_Image}'=>$this->getOGImage()
			    );
			
			$this->templateEngine->load($data, 'home_en.html');
		}
		
		
		private function getSliderImages(){
		
		    $this->query->execute("SELECT * FROM `home_page` WHERE `id`=1");
		    $row= $this->query->result->fetch_object();
		 
			$images = '';
			if($row->link_href_1_en)
				$images .= '<li><a href="'.$row->link_href_1_en.'" title="'.$row->link_title_1_en.'"><img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1_en.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1_en.'"/>';
			
			if($row->link_href_2_en)
				$images .= '<li><a href="'.$row->link_href_2_en.'" title="'.$row->link_title_2_en.'"><img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2_en.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2_en.'"/>';
				
			if($row->link_href_3_en)
				$images .= '<li><a href="'.$row->link_href_3_en.'" title="'.$row->link_title_3_en.'"><img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3_en.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3_en.'"/>';
				
			if($row->link_href_4_en)
				$images .= '<li><a href="'.$row->link_href_4_en.'" title="'.$row->link_title_4_en.'"><img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4_en.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4_en.'"/>';
				
			if($row->link_href_5_en)
				$images .= '<li><a href="'.$row->link_href_5_en.'" title="'.$row->link_title_5_en.'"><img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5_en.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5_en.'"/>';
			
			if($row->link_href_6_en)
				$images .= '<li><a href="'.$row->link_href_6_en.'" title="'.$row->link_title_6_en.'"><img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6_en.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6_en.'"/>';
		  
		    return $images;	
		}
		public function getPreloadImages(){
			$this->query->execute("SELECT * FROM `home_page` WHERE `id`=1");
			$row= $this->query->result->fetch_object();
			$preload = ' $.preload("images/slider_1/'.$row->image_1.'");
			$.preload("images/slider_1/'.$row->image_2.'");';
			if($row->image_3 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_3.'");';
			if($row->image_4 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_4.'");';
			if($row->image_5 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_5.'");';
			
			return $preload;
		}	
		
		private function getDescription()
		{
			$this->query->execute("SELECT `description_en` FROM `home_page` WHERE `id`=1");
			$row = $this->query->result->fetch_object();
			return $row->description_en;
		}
		private function getCanonicalURL(){
			return 'http://www.greenforest.ro/en';
		}
		private function getOGImage(){
			 $this->query->execute("SELECT * FROM `home_page` WHERE `id`=1");
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
	
	$index = new Index();
	$index->execute();
?>
