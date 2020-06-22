<?php

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
		$this->query->execute("SELECT * FROM `collections` WHERE `seo_name_en` ='".$collection_seo_name."'");
		//if(!$this->query->result->num_rows) header('Location:page_not_found');
		$row = $this->query->result->fetch_object();
		$this->collectionId = $row->id;
		$this->collectionName = $row->name_en;
		$this->collectionSeoName = $row->seo_name_en;
		$this->collectionSeoNameTranslated = $row->seo_name;
		$this->catalog = $row->catalog;
		
		/*if($active_subcollection_seo_name != NULL)
		{
			$this->query->execute("SELECT * FROM `collections` WHERE `seo_name_en` = '".$active_subcollection_seo_name."'");
			if(!$this->query->result->num_rows) header('Location:page_not_found');
			$row = $this->query->result->fetch_object();
			$this->activeSubcollectionId = $row->id;
			$this->activeSubcollectionName = $row->name_en;
			$this->activeSubcollectionSeoName = $row->seo_name_en;
		}
		else*/
		{
			$this->activeSubcollectionId = NULL;
			$this->activeSubcollectionName = NULL;
			$this->activeSubcollectionSeoName = NULL;
		}
	}
	
	public function getCollectionName(){
		if($this->collectionSeoName != "e-communication")
			return $this->collectionName.' furniture collection';
		else return "<img src='images/e_communication.jpg'/>";
	}
	public function getLinkRo(){
	   if($this->collectionSeoName != "e-communication")
			return "Colectia-mobilier-de-birou-".$this->collectionSeoNameTranslated;
		else return "Colectia-".$this->collectionSeoNameTranslated;;
	
	}
	public function getPageTitle(){
		if($this->collectionSeoName != "e-communication")
			return $this->collectionName.' furniture collection';
		else return "e-communication collection";
	}
	
	public function getCollectionSeoName(){
		return $this->collectionSeoName;
	}
	
	public function getTranslatedSeoName(){
		return $this->collectionSeoNameTranslated;
	}
	
	public function getCatalog(){
		if($this->catalog) return '<a href="cataloage/'.$this->catalog.'" target="_blank" class="link_download">&#149; Download catalog</a>';
		else return '';
	}
	
	public function getNextCollection(){
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` > '".$this->collectionId."'  AND  `parrent_id`=1  AND  `name` NOT IN ('Active', 'Work', 'Top', 'SitStand') ORDER BY `id` ASC") ;
		if($this->query->result->num_rows)
		{
			$row = $this->query->result->fetch_object();
			$seo_name = $row->seo_name_en;
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
			$seo_name = $row->seo_name_en;
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
				$subcollections[]= array('id'=>$row->id, 'name' =>$row->name_en);
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
	
			$this->query->execute("SELECT `seo_name_en` FROM `collections` WHERE `id`= ".$subcollection['id']);
			$row= $this->query->result->fetch_object();
			
			$style= ($this->activeSubcollectionId == $subcollection['id'])? 'style="color:#6d9083 "' : '';
			if($index< (count($subcollections) -1))
			{
					
				$display .= '<a class="subcollection" '.$style.' href="en/Collection-'.$this->collectionSeoName.'/'.$row->seo_name_en.'#up">'.$subcollection['name'].'</a> <span class="v_line"><img src="images/vertical_line_1.gif" /></span>';
			}
			else
			{
				$display .= '<a class="subcollection" '.$style.' href="en/Collection-'.$this->collectionSeoName.'/'.$row->seo_name_en.'#up">'.$subcollection['name'].'</a>';
			}
		}
		$display .='</div></div>';
		
		return $display;
	}


		
	public function breadcrumb(){
		
		if($this->collectionSeoName !="e-communication")
		{
			if($this->activeSubcollectionId == NULL)
			{
				
					$breadcrumb= '<a href="en/">Home</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><span style="float:left">'.$this->collectionName.'</span>';
			}
			else
			{
				
					$breadcrumb= '<a href="en/">Home</a><span style="float:left">&nbsp; &raquo; &nbsp;</span ><a href="en/Collection-'.$this->collectionSeoName.'">'.$this->collectionName.'</a><span style="float:left">&nbsp &raquo &nbsp</span><span style="float:left">'.$this->activeSubcollectionName.'</span>';
				
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
		 $images = '<img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1_en.'"/>
		  <img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2_en.'"/>';
		  if($row->image_3 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3_en.'"/>';
		  if($row->image_4 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4_en.'"/>';
		  if($row->image_5 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5_en.'"/>';
		  if($row->image_6 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6_en.'"/>';
		  
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
		$this->query->execute("SELECT `description_en` FROM `collections` WHERE `id`=".$this->collectionId);
		}
		else
		{
		$this->query->execute("SELECT `description_en` FROM `collections` WHERE `id`=".$this->activeSubcollectionId);
		}
		$row = $this->query->result->fetch_object();
		return $row->description_en;
	}
	
	public function getMetaDescription()
	{
		$this->query->execute("SELECT `meta_description_en` FROM `collections` WHERE `id`=".$this->collectionId);
		$row= $this->query->result->fetch_object();
		$meta_desc = $row->meta_description_en;
		return $meta_desc;
	}	
	public function getCanonicalURL(){
		if($this->collectionSeoName != "e-communication")
			$url= 'http://www.greenforest.ro/en/' .$this->collectionName.'-furniture-collection';
		else $url= 'http://www.greenforest.ro/en/' ."e-communication-collection";		
		
		return $url;
	}	
	public function getOGImage(){
			$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->collectionId);
			$row= $this->query->result->fetch_object();
			return $row->image_1;
	}	
}