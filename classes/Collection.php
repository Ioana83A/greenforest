<?php
define('ID_ERGOPLUS', "11");
define('ID_ERGO', "12");
define('ID_INNO', "13");
define('ID_ELITE', "14");
define('ID_COMUNICARE_E', "3");
class Collection{
	private $query;
	private $collectionId;
	private $activeSubcollectionId;
	private $collectionSeoName;
	private $activeSubcollectionName;
	private $activeSubcollectionSeoName;
	private $collectionSeoNameTranslated;
	private $catalog;

	public function __construct($query, $collection_seo_name, $active_subcollection_seo_name)
	{
		$this->query = $query;
		$this->query->execute("SELECT * FROM `collections` WHERE `seo_name` ='".$collection_seo_name."'");
		//if(!$this->query->result->num_rows) header('Location:page_not_found');
		
		$row = $this->query->result->fetch_object();
		$this->collectionId = $row->id;
		$this->collectionName = $row->name;
		$this->collectionSeoName = $row->seo_name;
		$this->collectionSeoNameTranslated = $row->seo_name_en;
		$this->catalog = $row->catalog;
		
		
		
		if($active_subcollection_seo_name != NULL)
		{
			$this->query->execute("SELECT * FROM `collections` WHERE `seo_name` = '".$active_subcollection_seo_name."'");
			if(!$this->query->result->num_rows) header('Location:page_not_found');
			$row = $this->query->result->fetch_object();
			$this->activeSubcollectionId = $row->id;
			$this->activeSubcollectionName = $row->name;
			$this->activeSubcollectionSeoName = $row->seo_name;
		}
		else
		{
			$this->activeSubcollectionId = NULL;
			$this->activeSubcollectionName = NULL;
			$this->activeSubcollectionSeoName = NULL;
		}
	}
	
	public function getCollectionName(){
	   if($this->collectionSeoName != "Comunicare-e")
			return "Mobilier de birou ".$this->collectionName;
		else return "<img src='images/comunicare_e1.jpg'/>";
	
	}
	public function getLinkEn(){
	   if($this->collectionSeoName != "Comunicare-e")
			return 'en/'.$this->collectionSeoNameTranslated."-furniture-collection";
		else return 'en/'.$this->collectionSeoNameTranslated."-collection";
	
	}
	public function getPageTitle(){
		if($this->collectionSeoName != "Comunicare-e")
			return 'Colectia mobilier de birou '.$this->collectionName;
		else return "Colectia Comunicare e";
	
	}
	public function getCollectionSeoName(){
		return $this->collectionSeoName;
	
	}
	
	public function getTranslatedSeoName(){
		return $this->collectionSeoNameTranslated;
	}
	
	public function getCatalog(){
		if($this->catalog) return '<a href="cataloage/'.$this->catalog.'" target="_blank" class="link_download">&#149; Descarcă catalog</a>';
		else return '';
	}
	
	public function getNextCollection(){
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` > '".$this->collectionId."' AND  `parrent_id`=1 AND  `name` NOT IN ('Active', 'Work', 'Top', 'SitStand')  ORDER BY `id` ASC") ;
		if($this->query->result->num_rows)
		{
			$row = $this->query->result->fetch_object();
			$seo_name = $row->seo_name;
		}
		else
		{
			$seo_name= NULL;
		}
	
		return $seo_name;
	}
	public function getPrevCollection(){
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` < '".$this->collectionId ."'  AND  `parrent_id`=1 AND  `name` NOT IN ('Active', 'Work', 'Top', 'SitStand') ORDER BY `id` DESC") ;
		if($this->query->result->num_rows)
		{
			$row = $this->query->result->fetch_object();
			$seo_name = $row->seo_name;
		}
		else
		{
			$seo_name= NULL;
		}
	
		return $seo_name;
	}
	
	private function getSubcollections()
	{
		$subcollections = array();
		$this->query->execute("SELECT * FROM `collections` WHERE `parrent_id` = ".$this->collectionId);
					
		$num_rows = $this->query->result->num_rows;
		if($num_rows > 0)
		{
			while($row= $this->query->result->fetch_object())
			{	
				$subcollections[]= array('id'=>$row->id, 'name' =>$row->name);
			}
		}
		return $subcollections;	
	}
	private function hasSubcollections(){
		$this->query->execute("SELECT * FROM `collections` WHERE `parrent_id` = ".$this->collectionId);
					
		$num_rows = $this->query->result->num_rows;
		if($num_rows > 0) return  true;
		else return false;
	}
	
	
	public function displaySubcollections(){
		$display = '<div id="subcollections_outer"><div id="subcollections_inner" >';
		$subcollections = $this->getSubcollections();
	
		foreach($subcollections as $index => $subcollection)
		{
	
			$this->query->execute("SELECT `seo_name` FROM `collections` WHERE `id`= ".$subcollection['id']);
			$row= $this->query->result->fetch_object();
			
			$style= ($this->activeSubcollectionId == $subcollection['id'])? 'style="color:#6d9083 "' : '';
			if($index< (count($subcollections) -1))
			{
					
				$display .= '<a class="subcollection" '.$style.' href="Colectia-'.$this->collectionSeoName.'/'.$row->seo_name.'#up">'.$subcollection['name'].'</a> <span class="v_line"><img src="images/vertical_line_1.gif" /></span>';
			}
			else
			{
				$display .= '<a class="subcollection" '.$style.' href="Colectia-'.$this->collectionSeoName.'/'.$row->seo_name.'#up">'.$subcollection['name'].'</a>';
			}
		}
		$display .='</div></div>';
		
		return $display;
	}
		
	public function breadcrumb(){
		
		$breadcrumb = "";
		if($this->collectionSeoName !="Comunicare-e")
		{
			if($this->activeSubcollectionId == NULL)
			{
				
					$breadcrumb= '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><span style="float:left">'.$this->collectionName.'</span>';
			}
			else
			{
				
					$breadcrumb= '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span ><a href="Colectia-'.$this->collectionSeoName.'">'.$this->collectionName.'</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><span style="float:left">'.$this->activeSubcollectionName.'</span>';
				
			}
		}
		else $breadcrumb='<div style="width:100px;height:12px;"></div>';
	
		return $breadcrumb;
	}
	
	public function getSliderImages(){
		if($this->activeSubcollectionId == NULL)
		{
			$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->collectionId);
			$row= $this->query->result->fetch_object();
		 }
		 else
		 {
			$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->activeSubcollectionId);
			$row= $this->query->result->fetch_object();
		 }
		 $images = '<img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1.'"/>
		  <img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2.'"/>';
		  if($row->image_3 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3.'"/>';
		  if($row->image_4 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4.'"/>';
		  if($row->image_5 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5.'"/>';
		  if($row->image_6 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6.'"/>';
		  
		  return $images;
	}
		
	public function getPreloadImages(){
		if($this->activeSubcollectionId == NULL)
		{
			$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->collectionId);
			$row= $this->query->result->fetch_object();
		 }
		 else
		 {
			$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->activeSubcollectionId);
			$row= $this->query->result->fetch_object();
		 }
		$preload = ' $.preload("images/slider_1/'.$row->image_1.'");
		$.preload("images/slider_1/'.$row->image_2.'");';
		if($row->image_3 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_3.'");';
		if($row->image_4 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_4.'");';
		if($row->image_5 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_5.'");';
		if($row->image_6 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_6.'");';
		
		return $preload;
	}
	
	public function getDescription()
	{
		if($this->activeSubcollectionId == NULL)
		{
		$this->query->execute("SELECT `description` FROM `collections` WHERE `id`=".$this->collectionId);
		}
		else
		{
		$this->query->execute("SELECT `description` FROM `collections` WHERE `id`=".$this->activeSubcollectionId);
		}
		$row = $this->query->result->fetch_object();
		return $row->description;
	}
	
	public function getMetaDescription()
	{
		if($this->collectionId == ID_ERGOPLUS) 
		{
			return "ErgoPlus este un program de mobilier de birou dezvoltat de GreenForest cu precădere pentru spațiile largi de tip 'open space'.";
		}
		else if($this->collectionId == ID_ERGO) 
		{
			return "Programul Ergo asigură maximum de funcționalitate unui post de lucru și, în același timp, respectă legile naturale ale corpului omenesc.";
		}
		else if($this->collectionId == ID_INNO) 
		{
			return "Inno este un program de mobilier directorial cu un design contemporan minimalist, caracterizat prin linii drepte și forme simple.";
		}
		else if($this->collectionId == ID_ELITE) 
		{
			return "Programul Elite, componentă a gamei de mobilier directorial GreenForest, este o excelentă alegere pentru cei care apreciază designul modern, calitatea materialelor şi tehnologia de vârf.";
		}
		else if($this->collectionId == ID_COMUNICARE_E) 
		{
			return "Soluțiile profesionale de comunicare electronică e-Visual dezvoltate de GreenForest sunt destinate pieței de publicitate și mediului organizațional, atât ca și instrument de comunicare externă, cât și pentru comunicarea internă de tip corporate.";
		}
		else
		{
			$this->query->execute("SELECT `meta_description` FROM `collections` WHERE `id`=".$this->collectionId);
			$row= $this->query->result->fetch_object();
			$meta_desc = $row->meta_description;
			return $meta_desc;
		}
	}
	
	public function getCanonicalURL(){
		    if($this->collectionSeoName != "Comunicare-e")
				$url =  'http://www.greenforest.ro/Colectia-mobilier-de-birou-'.$this->collectionName;
			else $url = "http://www.greenforest.ro/Colectia-Comunicare-e";
			
			return $url;
	}	

	public function getOGImage(){
			$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->collectionId);
			$row= $this->query->result->fetch_object();
			return $row->image_1;
	}	
}