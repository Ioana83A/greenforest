<?php
error_reporting(E_ALL);
define("SCAUNE_OPERATIVE_ID", "41");

define("COLECTIA_PATRA_ID", "23");


class ChairsPatraCollection{
    private $query;
    private $categoryId;
    private $activeSubcategoryId;
    private $categoryName;
    private $categorySeoName;
    private $collectionId;
    private $collectionName;
    private $activeSubcategoryName;
    private $nbProducts;
    private $products;
    private $productId;
    private $productName;
    
    
    
    public function __construct($query)
    {
        $this->query = $query;
    }
    
    public function getPageContent()
    {
		$page_content = '<p style="font-size:16px;line-height:22px;margin-top:25px;margin-bottom:20px;text-align:justify">Patra este o marcă de scaune sud-coreene cu o prezență globală importantă, având cote de piață semnificative pe toate continentele, iar scaunele sunt certificate internațional atât după standardele europene cât și cele americane. Produsele încorporează, pe lângă funcții ergonomice performante, și tehnologii prietenoase cu mediul, având astfel și certificări Internaționale "green". Colecția Patra completează astfel oferta GreenForest cu produse care corepund dimensional și cerintelor pieței Statelor Unite, caracterizată de utilizatori mai corpolenți. <b>GreenForest este unicul distribuitor autorizat din România al mărcii Patra.</b></p>';
         
        $page_content .= '<div class="row">';
		$href="Scaune-operative/colectia-Patra";
		$this->query->execute("SELECT * FROM `products` WHERE `category_id` =" .SCAUNE_OPERATIVE_ID  . " AND `collection_id` =".COLECTIA_PATRA_ID ." ORDER BY `id`");
        $i=1;
		while ($row = $this->query->result->fetch_object()) { 
            $page_content .= '<div class="col-md-2 col-xs-3" style="display:table;margin-bottom:20px"><div style="display:table-row;"><a href="' . $href . '/p=' . $row->seo_name . '&variant_id='.$row->selected_var_id.'" class="project_image" style="display:table-cell;background-image:url(\'images/products/product-image-bg.jpg\');background-repeat:no-repeat;bacground-size:contain;box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);"><img src="images/products/' . $row->image . '" alt="' . $row->alt_image . '" style="width:100%;height:auto"/></a></div>
			  <div style="display:table-row;"><div style="display:table-cell;height:5px"></div></div>
			  <div class="image-caption" style="display:table-row;">                 
              <div style="display:table-cell;vertical-align:middle;height:44px;box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);"><p><a  href="' . $href . '/p=' . $row->seo_name . '&variant_id='.$row->selected_var_id.'" style="color:white" class="view-details">'.$row->short_name .'</a></p></div></div></div>';         
              if($i%6 == 0)   $page_content .= '<div style="clear:both" class="hidden-sm hidden-xs"></div>';
			  if($i%4 == 0)   $page_content .= '<div style="clear:both" class="hidden-lg hidden-md"></div>';
			 
			  if($i%2 == 0)   $page_content .= '<div style="clear:both" class="visibile_under_430"></div>';
			  $i++;
		}
		
		

		
		$page_content .= '</div><p style="font-size:16px;line-height:22px;margin-top:20px">Colecția completă și mai multe detalii privind marca Patra găsiți pe site-ul:  <a href="http://www.patrainc.com/" class="green-link">www.patrainc.com</a>. </p>';
        
        return $page_content;
    }
    
	
	public function getNextCollection(){
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` > '".COLECTIA_PATRA_ID."' AND `parrent_id` IS NOT NULL AND  `parrent_id`= 2  ORDER BY `id` ASC") ;
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
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` < '".COLECTIA_PATRA_ID ."' AND `parrent_id` IS NOT NULL AND  `parrent_id`= 2 ORDER BY `id` DESC") ;
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

    public function getMetaDescription()
    {
        $meta_desc = "Mobilier de birou, Scaune Colectia 'Patra'";
        
        return $meta_desc;
        
    }
   
    
    public function getPageTitle()
    {
        return 'Scaune colectia Patra';
    }
    
    public function getCanonicalURL()
    {
        $url = 'http://www.greenforest.ro/Scaune-Patra';
        return $url;
    }
    
    public function getOGImage()
    {      
        $og_image = 'http://www.greenforest.ro/images/slider_1/banner-patra.jpg';
        return $og_image;
    }
}