<?php

class ChairsCollection{
	private $query;
	private $collectionId;
	private $collectionSeoName;
	private $collectionSeoNameTranslated;
	private $description;
	private $metaDescription;
	
	public function __construct($query, $collection_seo_name)
	{
		$this->query = $query;
		$this->query->execute("SELECT * FROM `collections` WHERE `seo_name_en` ='".$collection_seo_name."'");
		//if(!$this->query->result->num_rows) header('Location:page_not_found');
		$row = $this->query->result->fetch_object();
		$this->collectionId = $row->id;
		$this->collectionName = $row->name_en;
		$this->collectionSeoName = $row->seo_name_en;
		$this->collectionSeoNameTranslated = $row->seo_name;
		$this->description = $row->description_en;
		$this->metaDescription = $row->meta_description_en;
	}
	
	public function getCollectionName(){
		return $this->collectionName;
	}
	public function getPageTitle(){
		return 'Chairs - '.$this->collectionName.' collection';
	}
	
	public function getCollectionSeoName(){
		return $this->collectionSeoName;
	}
	
	public function getTranslatedSeoName(){
		return $this->collectionSeoNameTranslated;
	}
	
	public function getDescription(){
		return $this->description;
	}
	
	public function getMetaDescription(){
		return $this->metaDescription;
	}
	
	public function getNextCollection(){
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` > '".$this->collectionId."' AND `parrent_id` IS NOT NULL AND  `parrent_id`=2  ORDER BY `id` ASC") ;
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
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` < '".$this->collectionId ."' AND `parrent_id` IS NOT NULL AND  `parrent_id`=2 ORDER BY `id` DESC") ;
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

	public function breadcrumb(){
		$breadcrumb= '<a href="en/">Home</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><span style="float:left">'.'Chairs - '.$this->collectionName.' collection</span>';
		return $breadcrumb;
	}
	
	public function getImage(){
		$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->collectionId);
		$row= $this->query->result->fetch_object();
	  
		return '<a href="'.$this->getLink().'" target="_blank"><img class="slider1_image" src="images/chairs/'.$row->image_1.'" alt="'.$row->alt_image_1_en.'"/></a>';
	}
	
	public function getLink()
	{
		$this->query->execute("SELECT `link` FROM `collections` WHERE `id`=".$this->collectionId);
		$row = $this->query->result->fetch_object();
		return $row->link;
	}
	
	public function displayLink(){
		$link = explode('http://', $this->getLink());
		$link = $link[1];
		return '<div id="subcollections_outer"><div id="subcollections_inner" style="font-size:14px"><a href="'.$this->getLink().'" target="_blank">'.$link.'</a></div></div>';
	}
	public function getCanonicalURL(){
			return 'http://www.greenforest.ro/en/'. 'Chairs-'.$this->collectionSeoName;
	}
	public function getOGImage(){
			$this->query->execute("SELECT * FROM `collections` WHERE `id`=".$this->collectionId);
			$row= $this->query->result->fetch_object();
			return $row->image_1;
	}	
}