<?php

	error_reporting(0);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	//header_remove("X-Powered-By");
	
	class Index extends PageTemplate
	{
		public function execute()
		{
			//$this->URLCheck();
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Slider_images}'=>$this->getSliderImages(),
				'{Text}'=>$this->getDescription(),
				'{Preload_slider_images}'=>$this->getPreloadImages(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Canonical_URL}'=>$this->getCanonicalURL(),
				'{OG_Image}'=>$this->getOGImage()
			    );
			
			$this->templateEngine->load($data, 'home.html');
		}
			
		private function getSliderImages(){
		    $this->query->execute("SELECT * FROM `home_page` WHERE `id`=1");
		    $row= $this->query->result->fetch_object();
			 
			$images = '';
			if($row->link_href_1)
				$images .= '<li><a href="'.$row->link_href_1.'" title="'.$row->link_title_1.'"><img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1.'"/>';
			
			if($row->link_href_2)
				$images .= '<li><a href="'.$row->link_href_2.'" title="'.$row->link_title_2.'"><img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2.'"/>';
				
			if($row->link_href_3)
				$images .= '<li><a href="'.$row->link_href_3.'" title="'.$row->link_title_3.'"><img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3.'"/>';
				
			if($row->link_href_4)
				$images .= '<li><a href="'.$row->link_href_4.'" title="'.$row->link_title_4.'"><img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4.'"/>';
				
			if($row->link_href_5)
				$images .= '<li><a href="'.$row->link_href_5.'" title="'.$row->link_title_5.'"><img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5.'"/>';
			if($row->link_href_6)
				$images .= '<li><a href="'.$row->link_href_6.'" title="'.$row->link_title_6.'"><img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6.'"/></a></li>';
			else
			    $images .= '<li><img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6.'"/>';
			  
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
			$desc = "<div class='col-sm-9' style='padding-bottom:30px;padding-left:0'>
					   
					   <h1 style='font-size:28px;line-height:30px;margin-bottom:5px;font-weight:400;font-family:\"Helvetica\";padding-right:20px;color:#777;' >soluţii profesionale de amenajare cu mobilier de birou</h1>
					   <h2 style='font-size:20px;line-height:28px;margin-bottom:5px;font-weight:400;font-family:\"Helvetica\";padding-right:20px;color:#6d9083;' >24 de ani experienţă în producţie şi amenajări cu mobilier</h2>
					  </div>".'
				    <div class="col-sm-3" style="padding-right:0px">
					   <div style="width:142px;height:50px;padding-top:3px;float:right"><a href="https://www.facebook.com/greenforest.ro" target="_blank"><img src="images/Like_us.jpg" alt=""></a></div>
					</div>
					<div style="clear:both"></div>
					<p>Prin investiţii permanente în cele mai moderne tehnologii, mizând pe competenţa angajaţilor săi şi adaptându-se permanent la cerinţele pieţei, GreenForest şi-a diversificat continuu portofoliul produselor de mobilier pentru birou şi a dezvoltat proiecte speciale în domeniul industrial, hotelier, comercial, educaţional şi naval.</p>
					<p>Misiunea GreenForest este de a crea valoare pentru clienţi, prin furnizarea de soluţii profesionale de amenajare cu mobilier, în scopul creşterii calităţii vieţii şi în acord cu principiile dezvoltării durabile.</p>';
			return $desc;
		}
		private function getCanonicalURL(){
			return 'http://www.greenforest.ro';
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
