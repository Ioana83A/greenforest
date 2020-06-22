<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu.php';
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
			
			$this->templateEngine->load($data, 'despre_noi.html');
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
					case 'despre_noi': $text = $row->about_us;
					                 break;
					case 'referinte': $text= $row->refferences;
					                  break;
		
					case 'politica':  $text= $row->politics;
					                  $query = "SELECT * FROM `certificate` WHERE id=1";
					                  $this->query->execute($query);							   									  
									  $row1 = $this->query->result->fetch_object();
									  $certificat_calitate = $row1->name;
									  
									  $query = "SELECT * FROM `certificate` WHERE id=2";
					                  $this->query->execute($query);							   									  
									  $row1 = $this->query->result->fetch_object();
									  $certificat_mediu = $row1->name;
									  
									  $query = "SELECT * FROM `certificate` WHERE id=3";
					                  $this->query->execute($query);							   									  
									  $row1 = $this->query->result->fetch_object();
									  $politica_mediu_calitate = $row1->name;
					
					                  
					                  $text .='<div id="certificate"><a href="certificate/iso9001_iunie_2015.zip" target="_blank" >&#149; Certificatul de calitate </a><br/>
									           <a href="certificate/iso14001.zip" target="_blank" >&#149; Certificatul de mediu </a><br/>
											   <a href="certificate/'.$politica_mediu_calitate.'" target="_blank" >&#149; Politica de calitate si mediu </a><br/></div><div class="clear_box"></div>'; 
					                 break;
				   case 'finantari':return $this->getProjects();
					                 break;	
					               			
				}
				return $text;
			}
		}
		private function getMetaDesc()
		{
			
			if(!isset($_REQUEST['category']))
			{
				return 'De la lansarea pe piaţă în anul 1992, compania GreenForest s-a impus ca unul dintre cei mai importanţi producători şi dezvoltatori de amenajări cu mobilier pentru birou din România.';
			}
			else
			{
				switch($_REQUEST['category']) 
				{
					case 'despre_noi': $desc = "De la lansarea pe piaţă în anul 1992, compania GreenForest s-a impus ca unul dintre cei mai importanţi producători şi dezvoltatori de amenajări cu mobilier pentru birou din România.";
					                 break;
					case 'referinte': $desc= "Atât marile branduri internaționale din toate sectoarele importante, cât și exporturile realizate pe piețele Europei occidentale și regionale  ne recomandă ca furnizori de soluții profesionale integrate de amenajare cu mobilier și management proiecte de design interior. ";
					                  break;
		
					case 'politica': $desc ="Misiunea GreenForest este de a crea valoare pentru clienţi, prin furnizarea de soluţii profesionale de amenajare cu mobilier, în scopul creşterii calităţii vieţii şi în acord cu principiile dezvoltării durabile."; 
					                 break;
				   case 'finantari': $desc = "Despre noi- Finantari";
					                 break;	
					               			
				}
				return $desc;
			}
		}
		private function getSubcategories(){
			if(!isset($_REQUEST['category']))
				{
					return '<div id="subcategories_outer"><div id="subcategories_inner"><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory" href="Despre-noi" style="color:#66987b">Despre noi</a></h1> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a 	 class="subcategory" href="Despre-noi/referinte">Referinte</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="Despre-noi/politica">Politica</a><span class="v_line last"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory last" href="Despre-noi/finantari">Finantari</a></div>';
				}
				else
				{
					switch($_REQUEST['category']) 
					{
						case 'despre_noi': return '<div id="subcategories_outer"><div id="subcategories_inner"><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory" href="Despre-noi" style="color:#66987b">Despre noi</a></h1> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a 	 class="subcategory" href="Despre-noi/referinte">Referinte</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="Despre-noi/politica">Politica</a><span class="v_line last"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory last" href="Despre-noi/finantari">Finantari</a></div>';
						break;
						
						case 'referinte': return '<div id="subcategories_outer"><div id="subcategories_inner"><a class="subcategory" href="Despre-noi" >Despre noi</a></span> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a 	 class="subcategory" href="Despre-noi/referinte" style="color:#66987b">Referinte</a> </h1><span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="Despre-noi/politica">Politica</a><span class="v_line last"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory last" href="Despre-noi/finantari">Finantari</a></div>';
						                break;
						
						case 'politica':  return '<div id="subcategories_outer"><div id="subcategories_inner"><a class="subcategory" href="Despre-noi" >Despre noi</a></span> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a 	 class="subcategory" href="Despre-noi/referinte" >Referinte</a><span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory" href="Despre-noi/politica" style="color:#66987b">Politica</a></h1><span class="v_line last"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory last" href="Despre-noi/finantari">Finantari</a></div>';
						                break;
					   case 'finantari':	return '<div id="subcategories_outer"><div id="subcategories_inner"><a class="subcategory" href="Despre-noi" >Despre noi</a></span> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a 	 class="subcategory" href="Despre-noi/referinte" >Referinte</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span><a class="subcategory" href="Despre-noi/politica" >Politica</a><span class="v_line last"><img src="images/vertical_line_1.gif" alt=""/></span><h1 style="float: left;margin:0;padding-bottom: 3px;font-size: 14px;line-height:1.42857143"><a class="subcategory last" href="Despre-noi/finantari" style="color:#66987b">Finantari</a></h1></div>';
						                break;				
					}
				}
			
		}
		
		private function getProjects()
		{
			
			$projects ='<ol style="list-style-type:none;margin-bottom:60px;border-bottom:2px dotted #666">
			             <li style="font-weight:bold;font-size:18px">II. Implementare MAGAZIN ONLINE</li>';
			$projects .='<div>
							 <div class="col-xs-4 sigla" style="margin-right:0px;padding-top:15px"><img style="width:45%"src="images/sigle/image_1.jpg" alt=""/></div>
							 <div class="col-xs-4 sigla" style="margin-right:0px;text-align:center;padding-top:15px"><img style="width:25%" src="images/sigle/image_2.jpg" alt=""/></div>
							 <div class="col-xs-4 " style="text-align:right"><img style="width:45%" src="images/sigle/image_3.jpg" alt=""/></div>
							 <div class="clear_box"></div>
						 </div>'; 
			$this->query->execute("SELECT * FROM `about_us` WHERE `id`=2");
			$row= $this->query->result->fetch_object();
			$projects .= '<div style="width:100%;text-align:center;padding-top:10px;">
			              <h2 style="line-height:22px;font-size:18px">'. $row->proiect_titlu.'</h2></div>';
			$projects .= $row->proiect_descriere;
			$projects .='</ol>';
		
			$projects .='<ol style="list-style-type:none">
			             <li style="font-weight:bold;font-size:18px">I. Implementare ERP</li>';
			$projects .='<div>
							 <div class="col-xs-4 sigla" style="margin-right:0px;padding-top:15px"><img style="width:45%"src="images/sigle/image_1.jpg" alt=""/></div>
							 <div class="col-xs-4 sigla" style="margin-right:0px;text-align:center;padding-top:15px"><img style="width:25%" src="images/sigle/image_2.jpg" alt=""/></div>
							 <div class="col-xs-4 " style="text-align:right"><img style="width:45%" src="images/sigle/image_3.jpg" alt=""/></div>
							 <div class="clear_box"></div>
						 </div>'; 
			$this->query->execute("SELECT * FROM `about_us` WHERE `id`=1");
			$row= $this->query->result->fetch_object();
			$projects .= '<div style="width:100%;text-align:center;padding-top:10px;">
			              <h2 style="line-height:22px;font-size:18px">'. $row->proiect_titlu.'</h2></div>';
			$projects .= $row->proiect_descriere;
			$projects .='</ol>';
			return $projects;
		}
		
		private function getPageTitle(){
		
			if(!isset($_REQUEST['category']))
			{
				return "Despre noi";
			}
			else
			{
				switch($_REQUEST['category']) 
				{
					case 'despre_noi': return "Despre noi";
									   break;
					case 'referinte':  return "Referinte";
									   break;
					case 'politica':   return "Politica";
									   break;	
					case 'finantari':   return "Finantari";
									   break;				
				}
			}
		}
		
		private function getSliderImages(){
		   
            $this->query->execute("SELECT * FROM `about_us` ");
			$row= $this->query->result->fetch_object();
			if($_REQUEST['category'] == 'referinte')
			{
				$images = '<ul class="bxslider"><img class="slider1_image" src="images/slider_1/'.$row->references_image_1.'" alt="Logo-uri referinte 1"/>
				<img class="slider1_image" src="images/slider_1/'.$row->references_image_2.'" alt="Logo-uri referinte 2"/></ul>';
			}
			else
			{
			
				$images = '<ul class="bxslider"><img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1.'"/>
				<img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2.'"/>';
				if($row->image_3 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3.'"/>';
				if($row->image_4 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4.'"/>';
				if($row->image_5 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5.'"/>';
				if($row->image_6 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6.'"/>';
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
					case 'referinte':  $category ="/referinte";
									   break;
					case 'politica':   $category ="/politica";
									   break;
					case 'finantari':   $category ="/finantari";
									   break;									   
				}
			}
			return 'http://www.greenforest.ro/Despre-noi'.$category ;
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
