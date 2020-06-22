<?php
error_reporting(E_ALL);
define("SCAUNE_OPERATIVE_ID", "41");
define("SCAUNE_EXECUTIVE_ID", "42");
define("SCAUNE_MEETING_ID", "43");
define("SOLUTII_LOUNGE_ID", "44");
define("COLECTIA_TOPSTAR_ID", "21");


class ChairsTopstarCollection{
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
		$page_content = '<p style="font-size:16px;line-height:22px;margin-top:25px;text-align:justify">Topstar este unul dintre cei mai mari producători de scaune pentru birou din Europa, urmărind dezvoltarea unor produse cu bune performanțe ergonomice, la standardele calității Germane și în condiții de preț accesibile. Parteneriatul dintre GreenForest și Topstar are o bună tradiție, datând din anul 2003.</p>';
         
        $page_content .= '<h2 style="clear:both;font-size:18px;margin-top:20px;margin-bottom:10px;color:#444""><a href="Scaune-operative/colectia-Topstar">Scaune operative Topstar</a></h2><div class="row">';
		
		$href="Scaune-operative/colectia-Topstar";
		$this->query->execute("SELECT * FROM `products` WHERE `category_id` =" .SCAUNE_OPERATIVE_ID  . " AND `collection_id` =".COLECTIA_TOPSTAR_ID.' ORDER BY `ord_Topstar_operative`');
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
		
		
		$page_content .= '</div><h2 style="clear:both;font-size:18px;margin-top:40px;margin-bottom:10px;color:#444""><a href="Scaune-executive/colectia-Topstar"> Scaune executive Topstar</a></h2><div class="row">';
		$href="Scaune-executive/colectia-Topstar";
		$this->query->execute("SELECT * FROM `products` WHERE `category_id` =" .SCAUNE_EXECUTIVE_ID  . " AND `collection_id` =".COLECTIA_TOPSTAR_ID.' ORDER BY `id`');
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
		
		$page_content .= '</div><h2 style="clear:both;font-size:18px;margin-top:40px;margin-bottom:10px;color:#444""><a href="Scaune-meeting/colectia-Topstar">Scaune meeting Topstar</a></h2><div class="row">';
		$href="Scaune-meeting/colectia-Topstar";
		$this->query->execute("SELECT * FROM `products` WHERE `category_id` =" .SCAUNE_MEETING_ID  . " AND `collection_id` =".COLECTIA_TOPSTAR_ID.' ORDER BY `id`');
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
        
		$page_content .= '</div><p style="font-size:16px;line-height:22px;margin-top:20px">Colecția completă și mai multe detalii privind marca Topstar găsiți pe site-ul: <a href="http://www.topstar.de/en/home.html" class="green-link">www.topstar.de</a>. </p>';
        
        return $page_content;
    }
    
	
	public function getNextCollection(){
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` > '".COLECTIA_TOPSTAR_ID."' AND `parrent_id` IS NOT NULL AND  `parrent_id`= 2  ORDER BY `id` ASC") ;
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
	
		$this->query->execute("SELECT * FROM `collections` WHERE `id` < '".COLECTIA_TOPSTAR_ID ."' AND `parrent_id` IS NOT NULL AND  `parrent_id`= 2 ORDER BY `id` DESC") ;
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
        $meta_desc = "Mobilier de birou, Scaune Colectia 'Topstar'";
        
        return $meta_desc;
        
    }
   
    
    public function getPageTitle()
    {
        return 'Scaune colectia Topstar';
    }
    
    public function getCanonicalURL()
    {
        $url = 'http://www.greenforest.ro/Scaune-Topstar';
        return $url;
    }
    
    public function getOGImage()
    {      
        $og_image = 'http://www.greenforest.ro/images/chairs/topstar.png';
        return $og_image;
    }
}