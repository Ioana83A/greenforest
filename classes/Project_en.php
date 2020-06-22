<?php
class Project{
	private $query;
	private $name;
	private $seoName;
	private $seoNameTranslated;
	private $description;
	private $metaDescription;

public function __construct($query, $project_seo_name)
{
	$this->query = $query;
	$this->query->execute("SELECT * FROM `projects` WHERE `seo_name_en` ='".$project_seo_name."'");
	//if(!$this->query->result->num_rows) header('Location:page_not_found');
	
	$row = $this->query->result->fetch_object();
	$this->name = $row->name_en;
	$this->seoName = $row->seo_name_en;
	$this->seoNameTranslated = $row->seo_name;
	$this->description = $row->description_en;
	$this->metaDescription = $row->meta_description_en;
}

public function getProjectName(){
	if ($this->name != 'Alcatel' && $this->name != 'Emerson' && $this->name != 'Promenada Mall')
		return $this->name;
	else return $this->name.' Project';
}
public function getProjectSeoName(){
	return $this->seoName;
}

public function getTranslatedSeoName(){
	return $this->seoNameTranslated;
}

public function getDescription(){
	return $this->description;
}

public function getMetaDescription(){
	return $this->metaDescription;
}

public function getNextProject(){

	$this->query->execute("SELECT * FROM `projects` WHERE `name_en` > '".$this->name."' ORDER BY `name_en` ASC") ;
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
public function getPrevProject(){

	$this->query->execute("SELECT * FROM `projects` WHERE `name_en` < '".$this->name ."' ORDER BY `name_en` DESC") ;
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

				
public function getSliderImages(){

	$this->query->execute("SELECT * FROM `projects` WHERE `seo_name_en`='".$this->seoName."'");
	$row= $this->query->result->fetch_object();
	$images = '<img class="slider1_image" src="images/slider_1/'.$row->image_1.'" alt="'.$row->alt_image_1_en.'"/>
	<img class="slider1_image" src="images/slider_1/'.$row->image_2.'" alt="'.$row->alt_image_2_en.'"/>';
	if($row->image_3 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_3.'" alt="'.$row->alt_image_3_en.'"/>';
	if($row->image_4 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_4.'" alt="'.$row->alt_image_4_en.'"/>';
	if($row->image_5 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_5.'" alt="'.$row->alt_image_5_en.'"/>';
	if($row->image_6 != NULL)  $images .='<img class="slider1_image" src="images/slider_1/'.$row->image_6.'" alt="'.$row->alt_image_6_en.'"/>';
  
    return $images;
}
public function getPreloadImages(){
$this->query->execute("SELECT * FROM `projects` WHERE `seo_name_en`='".$this->seoName."'");
	$row= $this->query->result->fetch_object();
	$preload = ' $.preload("images/slider_1/'.$row->image_1.'");
	$.preload("images/slider_1/'.$row->image_2.'");';
	if($row->image_3 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_3.'");';
	if($row->image_4 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_4.'");';
	if($row->image_5 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_5.'");';
	if($row->image_6 != NULL)  $preload .='$.preload("images/slider_1/'.$row->image_6.'");';
	return $preload;
}
public function getCanonicalURL(){
		return 'http://www.greenforest.ro/en/Project-' . $this->seoName;
}
public function getOGImage(){
	$this->query->execute("SELECT * FROM `projects` WHERE `seo_name_en`='".$this->seoName."'");
	$row= $this->query->result->fetch_object();
	return $row->image_1;
}			
}