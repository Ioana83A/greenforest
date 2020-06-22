<?php
error_reporting(E_ALL);
define("DULAPURI_CAT_ID", "21");
define("ETAJERE_CAT_ID", "23");
define("CASETIERE_CAT_ID", "22");
define("COLECTIA_ERGO_ID", "12");
define("MESE_MEETING_ERGO_ERM_ID", "37");
define("MESE_MEETING_ERGO_ERMV_ID", "36");
define("MESE_MEETING_ERGO_ERMTS_ID", "35");
define("MESE_DISCUTII_ERGO_ERMD_ID", "32");
define("MESE_DISCUTII_ERGO_ERM_ID", "33");
define("MESE_MEETING_ERGO_ERMO_ID", "34");
define("SCAUNE_ERGONOMICE_ID", "41");
define("SCAUNE_EXECUTIVE_ID", "42");
define("SCAUNE_MEETING_ID", "43");
define("CAT_SCAUNE_ID", "4");
define("X_PANDER_ID", "440");
define("COLECTIA_ELITE_ID", "14");
define("COLECTIA_INNO_ID", "13");
define("COLECTIA_TOP_ID", "16");
define("COLECTIA_ACTIVE_ID", "15");
define("COLECTIA_WORK_ID", "17");
define("COLECTIA_SITSTAND_ID", "30");
define("COLECTIA_MOVI_ID", "31");
define("COLECTIA_TOPSTAR_ID", "21");
define("BIROU_MBA_ID", "310");
define("BIROU_MBRA_ID", "311");
define("MASA_MMA_ID", "312");
define("MASA_MMRA_ID", "313");

class Chairs{
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
    
    
    
    public function __construct($query, $categ_seo_name, $active_subcategory_seo_name, $collection_seo_name, $product_seo_name)
    {
        $this->query = $query;
        
        $this->query->execute("SELECT * FROM `categories` WHERE `seo_name` = '" . $categ_seo_name . "'");   
        $row                             = $this->query->result->fetch_object();
        $this->categoryId                = $row->id;
        $this->categoryName              = $row->name;
        $this->categorySeoName           = $row->seo_name;
        $this->categoryOrdMenu           = $row->ord_menu;
        
        
        if ($active_subcategory_seo_name != NULL) {
            $this->query->execute("SELECT * FROM `categories` WHERE `seo_name` = '" . $active_subcategory_seo_name . "'");
            $row                            = $this->query->result->fetch_object();
            $this->activeSubcategoryId      = $row->id;
            $this->activeSubcategoryName    = $row->name;
            $this->activeSubcategorySeoName = $row->seo_name;
        } else {
            $this->activeSubcategoryId      = NULL;
            $this->activeSubcategoryName    = NULL;
            $this->activeSubcategorySeoName = NULL;
        }
        
        
        if ($collection_seo_name != NULL) {
            $this->query->execute("SELECT * FROM `collections` WHERE `seo_name` = '" . $collection_seo_name . "'");
            $row                     = $this->query->result->fetch_object();
            $this->collectionId      = $row->id;
            $this->collectionName    = $row->name;
            $this->collectionSeoName = $row->seo_name;
        } else {
            $this->collectionId      = NULL;
            $this->collectionName    = NULL;
            $this->collectionSeoName = NULL;
        }
        
        
        if ($product_seo_name != NULL) {
            $this->query->execute("SELECT * FROM `products` WHERE `seo_name` = '" . $product_seo_name . "'");
            $row                  = $this->query->result->fetch_object();
            $this->productId      = $row->id;
            $this->productSeoName = $row->seo_name;
            $this->productName    = $row->name;
        } else {
            $this->productId      = NULL;
            $this->productSeoName = NULL;
            $this->productName    = NULL;
        }
    }
    
    public function getCategoryName()
    {
        
        if ($this->categoryName != "Scaune") {
            if ($this->productId == NULL && $this->activeSubcategoryName != NULL) {
                return '<h1>' . $this->activeSubcategoryName . ' ' . $this->collectionName . '</h1>';
            } else {
                $this->query->execute("SELECT `antet` FROM `collection_categories` WHERE `category_id`=" . $this->categoryId . " AND  `collection_id`=" . $this->collectionId);
                $row           = $this->query->result->fetch_object();
                $category_name = $row->antet;
                if ($this->productId != NULL)
                    return '<h2>' . $category_name . '</h2>';
                else
                    return '<h1>' . $category_name . '</h1>';
            }
        } else {
            if ($this->productId != NULL)
                return '<h2>' . $this->categoryName . ' ' . lcfirst($this->activeSubcategoryName) . '</h2>';
            else
                return '<h1>' . $this->categoryName . ' ' . lcfirst($this->activeSubcategoryName) . '</h1>';
        }
    }
    
    public function displayPageContent()
    {
        
        $this->products   = array();
        $products_display = '';
        $href             = $this->categorySeoName;
       
        if ($this->collectionId != NULL) {
            $href .= '/colectia-' . $this->collectionSeoName;
        }
		else
		{
			 header('HTTP/1.0 404 Not Found', true, 404);
			 readfile('page_not_found.php');
			 exit();	
		}

       
            $product_ids = $this->getProductsFromCollection($this->collectionId);
            foreach ($product_ids as $product_id) {
                $this->query->execute("SELECT * FROM `products` WHERE `id` = " . $product_id);
                $row1             = $this->query->result->fetch_object();
                $this->products[] = array(
				    'name' => $row1->name,
					'short_name' => $row1->short_name,
                    'seo_name' => $row1->seo_name,
                    'image' => $row1->image,
                    'alt_image' => $row1->alt_image,
					'variant_id'=>$row1->selected_var_id
                );
            }
   
       
        for ($i = 0; $i < count($this->products); $i++) {
           
            $products_display .= '<div class="col-md-2 col-xs-3" style="display:table;margin-bottom:20px"><div style="display:table-row;"><a href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&variant_id='.$this->products[$i]['variant_id'].'" class="project_image" style="display:table-cell;background-image:url(\'images/products/product-image-bg.jpg\');background-repeat:no-repeat;bacground-size:contain;box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);"><img src="images/products/' . $this->products[$i]['image'] . '" alt="' . $this->products[$i]['alt_image'] . '" style="width:100%;height:auto"/></a></div>
			  <div style="display:table-row;"><div style="display:table-cell;height:5px"></div></div>
			  <div class="image-caption" style="display:table-row;">        
              <div style="display:table-cell;vertical-align:middle;height:40px;box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);"><p><a  href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&variant_id='.$this->products[$i]['variant_id'].'" style="color:white" class="view-details">'.$this->products[$i]['short_name'] .'</a></p></div></div></div>';
			  
			  if(($i+1)%6 == 0)   $products_display .= '<div style="clear:both" class="hidden-sm hidden-xs"></div>';
			  if(($i+1)%4 == 0)   $products_display .= '<div style="clear:both" class="hidden-lg hidden-md"></div>';
			 
			  if(($i+1)%2 == 0)   $products_display .= '<div style="clear:both" class="visibile_under_430"></div>';
			  
			 
       
        }
        $this->nbProducts = count($this->products);
        
      if(!$this->productId)
	  {
          
		  $this->query->execute("SELECT * FROM `collection_categories` WHERE `category_id`=" . $this->categoryId . " AND  `collection_id`=" . $this->collectionId);
		  $row = $this->query->result->fetch_object();
		  $desc_up = $row->description_up;
		  $desc_bottom = $row->description_bottom;
		  
		  return '<div style="overflow:hidden;margin-top:47px;margin-bottom:25px" ><div class="category_outer"><div class="category_inner" ><span id="category_title">'.$this->getCategoryName().'</span></div> <div class="clear_box"></div></div></div><p style="font-size:16px;line-height:22px;margin-bottom:25px;text-align:justify">'.$desc_up.'</p><div class="row">'.$products_display.'</div><p style="font-size:16px;line-height:22px;margin-top:20px">'.$desc_bottom.'</p>';
	  }
	  else
	  {
	     return $this->getProductInfo();
	  }
    }
   
   
    private function getSubcategories()
    {
        $subcategories = array();
        $this->query->execute("SELECT * FROM `categories` WHERE `parrent_id` = " . $this->categoryId . ' ORDER BY `id`');
        
        $num_rows = $this->query->result->num_rows;
        if ($num_rows > 0) {
            while ($row = $this->query->result->fetch_object()) {
                $subcategories[] = array(
                    'seo_name' => $row->seo_name,
                    'name' => $row->name
                );
            }
        }
        return $subcategories;
    }
    private function hasSubcategories()
    {
        $this->query->execute("SELECT * FROM `categories` WHERE `parrent_id` = " . $this->categoryId);
        
        $num_rows = $this->query->result->num_rows;
        if ($num_rows > 0)
            return true;
        else
            return false;
    }
    
    private function getProductsFromCollection($collection_id)
    {
        $product_ids = array();
        
		
		
		if ($this->activeSubcategoryId != NULL) {
            $this->query->execute("SELECT * FROM `products` WHERE `category_id` =" . $this->activeSubcategoryId . " AND `collection_id` =" . $collection_id);
        } else {
            if ($this->hasSubcategories()) {
                $this->query->execute("SELECT `products`.* FROM `products` JOIN `categories` ON `categories`.`id` = `products`.`category_id` WHERE `categories`.`parrent_id` = " . $this->categoryId . " AND `products`.`collection_id`=" . $collection_id);
            } else {
                
				if($this->categoryId == SCAUNE_ERGONOMICE_ID && $this->collectionId== COLECTIA_TOPSTAR_ID)
					$this->query->execute("SELECT * FROM `products` WHERE `category_id` =" . $this->categoryId . " AND `collection_id` =" . $collection_id ." ORDER BY `ord_Topstar_operative`");
				else $this->query->execute("SELECT * FROM `products` WHERE `category_id` =" . $this->categoryId . " AND `collection_id` =" . $collection_id);
            }
        }
        $num_rows = $this->query->result->num_rows;
        if ($num_rows > 0) {
            while ($row = $this->query->result->fetch_object()) {
                $product_ids[] = $row->id;
            }
        }
        if($this->categoryId == SCAUNE_ERGONOMICE_ID && $this->collectionId== COLECTIA_TOPSTAR_ID)
		{
			//do nothing
			
		}
		else
		{
			for ($i = 0; $i < (count($product_ids) - 1); $i++) {
				for ($j = 0; $j < (count($product_ids) - ($i + 1)); $j++) { {
						if ($product_ids[$j] > $product_ids[$j + 1]) {
							$aux                 = $product_ids[$j];
							$product_ids[$j]     = $product_ids[$j + 1];
							$product_ids[$j + 1] = $aux;
						}
					}
				}
			}
		}
        return $product_ids;
    }
    
    public function getProductInfo()
    {
        $product_info   = '';
        $social_buttons = '
		 <div id="social_buttons" style="padding-top:20px;padding-left:20px;">
		  <div style="float:left;margin-right:10px">
			<div class="fb-like" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
		  </div>
		  <div style="float:left;margin-right:10px">
			<div class="fb-share-button" data-type="button_count"></div>
		  </div>
		  <div style="float:left;margin-right:10px">
			  <script src="//platform.linkedin.com/in.js" type="text/javascript">
			  lang: en_US
			</script>
			<script type="IN/Share" data-counter="right"></script>
		   </div>  
			
			<script type="text/javascript">
			  window.___gcfg = {lang: "ro"};
			
			  (function() {
				var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
				po.src = "https://apis.google.com/js/platform.js";
				var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
		  <div style="float:left;">
			<div class="g-plusone" data-annotation="bubble" data-size="medium"></div>
					<script type="text/javascript">
					  (function() {
						var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
						po.src = "https://apis.google.com/js/plusone.js";
						var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>
					</div>
		  </div>
		  ';
      
            $product_id = $this->productId;
            $this->query->execute('SELECT * FROM `products` WHERE `id` = ' . $product_id);
            $row = $this->query->result->fetch_object();
            
                $this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
                if (!$this->query->result->num_rows)
				{
                    header('HTTP/1.0 404 Not Found', true, 404);
					readfile('page_not_found.php');
					exit();
				}
                $row1 = $this->query->result->fetch_object();
                
                
               
                    if ($row1->arms_chairs_img)
                        $img_arms = '<img src="images/products/' . $row1->arms_chairs_img . '"/>';
                    else
                        $img_arms = '';
                    
                   
						
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description ;
									  
									 
						if($row1->optional_chairs)
                               $product_info .= '<div id="colors_title" style="margin-bottom:3px">Opțional:</div>'.$row1->optional_chairs;
						 
					   
									 
						if($row1->variants)
                               $product_info .= '<div id="colors_title" style="margin-bottom:3px">Variante:</div>'.$row1->variants;  
									
									  $product_info .='';
						 if($row1->available_online)			  
									 $product_info .= '<div id="colors_title">Comandă online:</div>
									  <div style="padding:5px 0px 5px 0px">'.$row1->available_online.'</div>';
								 
					
                       
                        $product_info .= '<div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><a href="images/products/' . $row1->image_big . '" class="image-popup" title="'.$row1->alt_image.'"><div style="width:417px;height:200px;margin-bottom:10px;background-image:url(\'images/products/image-bg-1.jpg\');background-repeat:repeat;text-align:center;box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);"><img src="images/products/' . $row1->image_big . '"  style="width:417px;height:200px" alt="' . $row1->alt_image . '" /></div></a>';
						               if ($row1->colors_chairs_img)
                            $product_info .= '<div style="text-align:center"><a href="images/products/' . $row1->colors_chairs_img . '" class="image-popup" title="Culori disponibile"><img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" style="max-width:100%;height:auto;padding-left:5px"/></a></div>';
						$product_info .= '</div><div class="clear_box"></div></div></div>';
                   
           
         
       
        return $product_info;
    }
    public function getCurrentUrl()
    {
        $url = $this->categorySeoName;
        if ($this->activeSubcategoryId != NULL)
            $url .= "/" . $this->activeSubcategorySeoName;
        if ($this->collectionId != NULL)
            $url .= "/colectia-" . $this->collectionSeoName;
        if ($this->productId != NULL) {
            $url .= "/p=" . $this->productSeoName;
            if (isset($_REQUEST['offset']))
                $offset = $_REQUEST['offset'];
            else
                $offset = 0;
            
            $url .= "&id=" . $offset;
        }
        return $url;
    }
    
    public function getMetaDescription()
    {
        $meta_desc = "";
        if ($this->collectionId != NULL) {
            $this->query->execute("SELECT `meta_description` FROM `collections` WHERE `id`=" . $this->collectionId);
            $row = $this->query->result->fetch_object();
            $meta_desc .= $row->meta_description . ' - ';
        }
        $this->query->execute("SELECT `meta_description` FROM `categories` WHERE `id`=" . $this->categoryId);
        $row = $this->query->result->fetch_object();
        $meta_desc .= $row->meta_description;
        if ($this->activeSubcategoryId != NULL) {
            $this->query->execute("SELECT `meta_description` FROM `categories` WHERE `id`=" . $this->activeSubcategoryId);
            $row = $this->query->result->fetch_object();
            $meta_desc .= ' - ' . $row->meta_description;
        }
        
        if ($this->productId != NULL) {
            $this->query->execute("SELECT `meta_description` FROM `products` WHERE `id`=" . $this->productId);
            $row = $this->query->result->fetch_object();
            $meta_desc .= ' - ' . $row->meta_description;
        }
        if (isset($_REQUEST['variant_id'])) {
            $this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
            $row = $this->query->result->fetch_object();
            $meta_desc .= ' - ' . $row->meta_description;
        }
        return $meta_desc;
        
    }
    public function getProductsDescription()
    {
        if ($this->productId != NULL) {
            $product_id = $this->productId;
        } else {
            $seo_name = $this->products[0]['seo_name'];
            $this->query->execute('SELECT * FROM `products` WHERE `seo_name` = "' . $seo_name . '"');
            $row        = $this->query->result->fetch_object();
            $product_id = $row->id;
        }
        $this->query->execute("SELECT `description` FROM `products` WHERE `id`=" . $product_id);
        $row  = $this->query->result->fetch_object();
        $desc = $row->description;
        return $desc;
    }
    public function getCategoryDescription()
    {
        if ($this->categoryName != "Scaune") {
            $this->query->execute("SELECT `description` FROM `collection_categories` WHERE `category_id`=" . $this->categoryId . " AND  `collection_id`=" . $this->collectionId);
            $row  = $this->query->result->fetch_object();
            $desc = $row->description;
        } else
            $desc = "";
        return $desc;
    }
    
    public function getPageTitle()
    {
        
        
        if ($this->productName != NULL) {
            
            if (isset($_REQUEST['variant_id'])) {
                $this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
                $row = $this->query->result->fetch_object();
                return $row->product_name. ', detalii produs';
            } else
                return $this->productName;
        } else {
            if ($this->activeSubcategoryId != NULL) {
                $this->query->execute("SELECT `meta_description` FROM `categories` WHERE `id`=" . $this->activeSubcategoryId);
                $row   = $this->query->result->fetch_object();
                $title = $row->meta_description;
            } else
                $title = $this->categoryName;
            
            if ($this->collectionName != NULL)
                $title .= ' - colectia ' . $this->collectionName;
            return $title;
            
        }
    }
    
    public function getCanonicalURL()
    {
        $url = 'http://www.greenforest.ro';
        $url .= '/' . $this->categorySeoName;
        if ($this->activeSubcategorySeoName != NULL)
            $url .= '/' . $this->activeSubcategorySeoName;
        if ($this->collectionSeoName != NULL)
            $url .= '/colectia-' . $this->collectionSeoName;
        if ($this->productId) {
            $url .= '/p=' . $this->productSeoName;
           
            if (isset($_REQUEST['variant_id']))
                $url .= '&variant_id=' . $_REQUEST['variant_id'];
        }
        return $url;
    }
    
    public function getOGImage()
    {
        
        if ($this->productId != NULL) {
            if (isset($_REQUEST['variant_id'])) {
                $this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
                $row      = $this->query->result->fetch_object();
                $og_image = $row->image;
            } else {
                $this->query->execute('SELECT * FROM `products` WHERE `id` = "' . $this->productId . '"');
                $row      = $this->query->result->fetch_object();
                $og_image = $row->image;
            }
        } else {
            $seo_name = $this->products[0]['seo_name'];
            $this->query->execute('SELECT * FROM `products` WHERE `seo_name` = "' . $seo_name . '"');
            $row      = $this->query->result->fetch_object();
            $og_image = $row->image;
        }
        return $og_image;
    }
}