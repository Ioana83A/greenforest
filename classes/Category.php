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
define("BIROU_MBA_ID", "310");
define("BIROU_MBRA_ID", "311");
define("MASA_MMA_ID", "312");
define("MASA_MMRA_ID", "313");

class Category{
    private $query;
    private $categoryId;
    private $activeSubcategoryId;
    private $categoryName;
    private $categorySeoName;
    private $categorySeoNameTranslated;
    private $categoryParrentId;
    private $categoryParrentSeoName;
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
        $this->categoryParrentId         = $row->parrent_id;
        $this->categorySeoNameTranslated = $row->seo_name_en;
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
    
    public function getCategorySeoNameTranslated()
    {
        return $this->categorySeoNameTranslated;
    }
    
    public function displayCategoryProducts()
    {
        
        $this->products   = array();
        $products_display = '      
			 
			 <div class= "slider_2_wrapper_ext">
				<div class="slider_2_wrapper">
					<div id="slider_1">';
        $href             = $this->categorySeoName;
        if ($this->activeSubcategoryId != NULL) {
            $href .= '/' . $this->activeSubcategorySeoName;
        }
        if ($this->collectionId != NULL) {
            $href .= '/colectia-' . $this->collectionSeoName;
        }
        if ($this->collectionId == NULL) {
            
            if ($this->activeSubcategoryId != NULL) {
                $this->query->execute("SELECT * FROM `products` WHERE `category_id` = " . $this->activeSubcategoryId . " ORDER BY `id`");
            } else {
                if ($this->hasSubcategories()) {
                    $this->query->execute("SELECT `products`.* FROM `products` JOIN `categories` ON `products`.`category_id` = `categories`.`id` WHERE `categories`.`parrent_id` = " . $this->categoryId . " ORDER BY `id`");
                } else {
                    $this->query->execute("SELECT * FROM `products` WHERE `category_id` = " . $this->categoryId . " ORDER BY `id`");
                }
            }
            $num_rows = $this->query->result->num_rows;
            if ($num_rows > 0) {
                while ($row = $this->query->result->fetch_object()) {
                    $this->products[] = array(
                        'seo_name' => $row->seo_name,
                        'image' => $row->image,
                        'alt_image' => $row->alt_image
                    );
                }
            }
        } else {
            $product_ids = $this->getProductsFromCollection($this->collectionId);
            foreach ($product_ids as $product_id) {
                $this->query->execute("SELECT * FROM `products` WHERE `id` = " . $product_id);
                $row1             = $this->query->result->fetch_object();
                $this->products[] = array(
                    'seo_name' => $row1->seo_name,
                    'image' => $row1->image,
                    'alt_image' => $row1->alt_image
                );
            }
        }
        if (isset($_REQUEST['offset']))
            $offset = $_REQUEST['offset'];
        else
            $offset = 0;
        if($offset > ((int)(count($this->products)/3))*3 || $offset%3 !=0)
		{
			header('HTTP/1.0 404 Not Found', true, 404);
			readfile('page_not_found.php');
			exit();
		}
        for ($i = $offset; $i < count($this->products); $i++) {
            $new_offset = floor($i / 3) * 3;
            $products_display .= '<div><li><a href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&id=' . $new_offset . '" class="project_image"><img src="images/products/' . $this->products[$i]['image'] . '" alt="' . $this->products[$i]['alt_image'] . '"/></a>
			  <div class="carousel-caption" style="padding-top:10px;padding-bottom:0">         
              <p><a  href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&id=' . $new_offset . '" style="color:white" class="view-details"><i class="fa fa-angle-double-right" aria-hidden="true"></i>
 vezi detalii</a></p></div></li></div>';
        }
        if (count($this->products) % 3)
            for ($i = 0; $i < (3 - count($this->products) % 3); $i++)
                $products_display .= '<div><li><a href="#" class="project_image"><img src="images/blank_img_new.jpg" style="border:none;" alt=""/></a></li></div>';
        
        for ($i = 0; $i < $offset; $i++) {
            $new_offset = floor($i / 3) * 3;
            $products_display .= '<div><li><a href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&id=' . $new_offset . '" class="project_image"><img src="images/products/' . $this->products[$i]['image'] . '" alt="' . $this->products[$i]['alt_image'] . '"/></a>
			   <div class="carousel-caption" style="padding-top:10px;padding-bottom:0">         
              <p><a  href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&id=' . $new_offset . '" style="color:white" class="view-details"><i class="fa fa-angle-double-right" aria-hidden="true"></i>
 vezi detalii</a></p></div></li></div>';
        }
        $this->nbProducts = count($this->products);
        
        $products_display .= ' </div>
			</div>
		   </div>';
        $products_display .= '<input type="hidden" name="nb_products" id="nb_products" value="' . $this->nbProducts . '" />';
        return $products_display;
    }
    public function displayCategoryProductsSmallScreen()
    {
        
        $this->products   = array();
        $products_display = '      
			 
					<div id="products_slider_small_screen"><ul id="slider_2">';
        $href             = $this->categorySeoName;
        if ($this->activeSubcategoryId != NULL) {
            $href .= '/' . $this->activeSubcategorySeoName;
        }
        if ($this->collectionId != NULL) {
            $href .= '/colectia-' . $this->collectionSeoName;
        }
        if ($this->collectionId == NULL) {
            
            if ($this->activeSubcategoryId != NULL) {
                $this->query->execute("SELECT * FROM `products` WHERE `category_id` = " . $this->activeSubcategoryId . " ORDER BY `id`");
            } else {
                if ($this->hasSubcategories()) {
                    $this->query->execute("SELECT `products`.* FROM `products` JOIN `categories` ON `products`.`category_id` = `categories`.`id` WHERE `categories`.`parrent_id` = " . $this->categoryId . " ORDER BY `id`");
                } else {
                    $this->query->execute("SELECT * FROM `products` WHERE `category_id` = " . $this->categoryId . " ORDER BY `id`");
                }
            }
            $num_rows = $this->query->result->num_rows;
            if ($num_rows > 0) {
                while ($row = $this->query->result->fetch_object()) {
                    $this->products[] = array(
                        'seo_name' => $row->seo_name,
                        'image' => $row->image,
                        'alt_image' => $row->alt_image,
                        'title' => $row->name
                    );
                }
            }
        } else {
            $product_ids = $this->getProductsFromCollection($this->collectionId);
            foreach ($product_ids as $product_id) {
                $this->query->execute("SELECT * FROM `products` WHERE `id` = " . $product_id);
                $row1             = $this->query->result->fetch_object();
                $this->products[] = array(
                    'seo_name' => $row1->seo_name,
                    'image' => $row1->image,
                    'alt_image' => $row1->alt_image,
                    'title' => $row1->name
                );
            }
        }
        
        for ($i = 0; $i < count($this->products); $i++) {
            $offset = floor($i / 3) * 3;
            $products_display .= '<li><a href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&id=' . $offset . '" class="product_image"><img src="images/products/' . $this->products[$i]['image'] . '" alt="' . $this->products[$i]['alt_image'] . '"/></a>
			<div class="carousel-caption" style="padding-top:10px;padding-bottom:0">         
              <p><a  href="' . $href . '/p=' . $this->products[$i]['seo_name'] . '&id=' . $offset . '" style="color:white" class="view-details">'.$this->products[$i]['title'].'  <span class="hidden-xs hidden-sm"><i class="fa fa-angle-double-right" aria-hidden="true"></i> vezi detalii</span></a></p></div>
			</li>';
        }
        $products_display .= ' </ul></div>
			';
        return $products_display;
    }
    
    public function displayProductTitles()
    {
        
        if ($this->productId != NULL) {
            $titles_display = '<div id="products_titles" style="height:30px">
     		<div class="product_title">
            	<div class="product_title_outer"><div class="product_title_inner"><h3 class="title"></h3></div></div>
            </div>
            
            <div class="product_title">
            	<div class="product_title_outer"><div class="product_title_inner"><h3 class="title"></h3></div></div>
            </div>
            
            <div class="product_title" style="margin-right:0">
            	<div class="product_title_outer"><div class="product_title_inner"><h3 class="title"></h3></div></div>  
            </div>';
            
           
        } else {
            $titles_display = '<div id="products_titles" style="height:30px">
     		<div class="product_title">
            	<div class="product_title_outer"><div class="product_title_inner"><h2 class="title"></h2></div></div>
            </div>
            
            <div class="product_title">
            	<div class="product_title_outer"><div class="product_title_inner"><h2 class="title"></h2></div></div>
            </div>
            
            <div class="product_title" style="margin-right:0">
            	<div class="product_title_outer"><div class="product_title_inner"><h2 class="title"></h2></div></div>  
            </div>';
        }
        
        
        $titles = array();
        
        $titles_display .= '<ul style="display:none" id="hidden_products_titles">';
        
        if ($this->collectionId == NULL) {
            
            if ($this->activeSubcategoryId != NULL) {
                $this->query->execute("SELECT * FROM `products` WHERE `category_id` = " . $this->activeSubcategoryId . " ORDER BY `id`");
            } else {
                if ($this->hasSubcategories()) {
                    $this->query->execute("SELECT `products`.* FROM `products` JOIN `categories` ON `products`.`category_id` = `categories`.`id` WHERE `categories`.`parrent_id` = " . $this->categoryId . " ORDER BY `id`");
                } else {
                    $this->query->execute("SELECT * FROM `products` WHERE `category_id` = " . $this->categoryId . " ORDER BY `id`");
                }
            }
            
            
            $num_rows = $this->query->result->num_rows;
            if ($num_rows > 0) {
                while ($row = $this->query->result->fetch_object()) {
                    
                    $titles[] = $row->name;
                    
                }
                
            }
        } else {
            
            $product_ids = $this->getProductsFromCollection($this->collectionId);
            foreach ($product_ids as $product_id) {
                $this->query->execute("SELECT * FROM `products` WHERE `id` = " . $product_id);
                
                $row1     = $this->query->result->fetch_object();
                $titles[] = $row1->name;
            }
            
        }
        
        if (isset($_REQUEST['offset']))
            $offset = $_REQUEST['offset'];
        else
            $offset = 0;
        for ($i = $offset; $i < count($titles); $i++) {
            
            $titles_display .= '<li>' . $titles[$i] . '</li>';
        }
        
        
        if (count($titles) % 3)
            for ($i = 0; $i < (3 - count($titles) % 3); $i++)
                $titles_display .= '<li></li>';
        
        for ($i = 0; $i < $offset; $i++) {
            $titles_display .= '<li>' . $titles[$i] . '</li>';
        }
        
        
        
        $titles_display .= '</ul></div>';
        return $titles_display;
    }
    
    
    public function getNextCategory()
    {
        
        $this->query->execute("SELECT * FROM `categories` WHERE `ord_menu` > " . $this->categoryOrdMenu . " AND `parrent_id` IS NULL ORDER BY `ord_menu` ASC");
        if ($this->query->result->num_rows) {
            $row      = $this->query->result->fetch_object();
            $seo_name = $row->seo_name;
        } else {
            $seo_name = NULL;
        }
        
        return $seo_name;
        
    }
    public function getPrevCategory()
    {
        
        $this->query->execute("SELECT * FROM `categories` WHERE `ord_menu` < " . $this->categoryOrdMenu . " AND `parrent_id` IS NULL ORDER BY `ord_menu` DESC");
        if ($this->query->result->num_rows) {
            $row      = $this->query->result->fetch_object();
            $seo_name = $row->seo_name;
        } else {
            $seo_name = NULL;
        }
        
        return $seo_name;
        
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
    
    private function hasSubcollections($collection_id)
    {
        $this->query->execute("SELECT * FROM `collections` WHERE `parrent_id` = " . $collection_id);
        
        $num_rows = $this->query->result->num_rows;
        if ($num_rows > 0)
            return true;
        else
            return false;
    }
    
    public function displaySubcategories()
    {
        
        if ($this->productId == NULL && $this->activeSubcategoryName != NUll) {
            return '';
        } else {
            if ($this->categoryId != CAT_SCAUNE_ID && $this->categoryId != SCAUNE_ERGONOMICE_ID) {
                $display       = '<div id="subcategories_outer"><div id="subcategories_inner" >';
                $subcategories = $this->getSubcategories();
                
                foreach ($subcategories as $index => $subcategory) {
                    
                    $style = ($this->activeSubcategorySeoName == $subcategory['seo_name']) ? 'style="color:#66987b "' : '';
                    if ($index < (count($subcategories) - 1)) {
                        if ($this->collectionId == NULL)
                            $display .= '<a class="subcategory"' . $style . ' href="' . $this->categorySeoName . '/' . $subcategory['seo_name'] . '#scroll">' . $subcategory['name'] . '</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span>';
                        else {
                            if (($this->collectionSeoName == "Elite" || $this->collectionSeoName == "Inno" || $this->collectionSeoName == "Top") && $subcategory['seo_name'] == 'Etajere') {
                                $display .= '<a class="subcategory" style="color:#dddddd"' . $style . ' href="#">' . $subcategory['name'] . '</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span>';
                            } else if ($this->collectionSeoName == "Top" && $subcategory['seo_name'] == 'Casetiere') {
                                $display .= '<a class="subcategory" style="color:#dddddd"' . $style . ' href="#">' . $subcategory['name'] . '</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span>';
                            } else {
                                $display .= '<a class="subcategory" ' . $style . ' href="' . $this->categorySeoName . '/' . $subcategory['seo_name'] . '/colectia-' . $this->collectionSeoName . '#scroll">' . $subcategory['name'] . '</a> <span class="v_line"><img src="images/vertical_line_1.gif" alt=""/></span>';
                            }
                        }
                    } else {
                        if ($this->collectionId == NULL)
                            $display .= '<a class="subcategory"' . $style . ' href="' . $this->categorySeoName . '/' . $subcategory['seo_name'] . '#scroll">' . $subcategory['name'] . '</a>';
                        else {
                            if (($this->collectionSeoName == "Elite" || $this->collectionSeoName == "Inno" || $this->collectionSeoName == "Top") && $subcategory['seo_name'] == 'Etajere') {
                                $display .= '<a class="subcategory"  style="color:#dddddd"' . $style . ' href="#">' . $subcategory['name'] . '</a>';
                            } else if ($this->collectionSeoName == "Top" && $subcategory['seo_name'] == 'Casetiere') {
                                $display .= '<a class="subcategory"  style="color:#dddddd"' . $style . ' href="#">' . $subcategory['name'] . '</a>';
                            } else {
                                $display .= '<a class="subcategory"' . $style . ' href="' . $this->categorySeoName . '/' . $subcategory['seo_name'] . '/colectia-' . $this->collectionSeoName . '#scroll">' . $subcategory['name'] . '</a>';
                            }
                        }
                    }
                }
                $display .= '</div></div>';
                
                return $display;
            } else
                return '';
        }
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
                $this->query->execute("SELECT * FROM `products` WHERE `category_id` =" . $this->categoryId . " AND `collection_id` =" . $collection_id);
            }
        }
        $num_rows = $this->query->result->num_rows;
        if ($num_rows > 0) {
            while ($row = $this->query->result->fetch_object()) {
                $product_ids[] = $row->id;
            }
        }
        
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
        return $product_ids;
    }
    
    
    
    public function breadcrumb()
    {
        
        if ($this->activeSubcategoryId == NULL) 
		{
            if ($this->collectionId == NULL)
                $breadcrumb = '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><a href="' . $this->categorySeoName . '">' . $this->categoryName . '</a>';
            else
			{
                
				if($this->productName == NULL)
				{
					$breadcrumb = '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><a href="' . $this->categorySeoName . '/colectia-' . $this->collectionSeoName . '">' . $this->categoryName . '</a><span style="float:left">&nbsp; &raquo; &nbsp;' . $this->collectionName . '</span>';
				}
				else
				{
					$breadcrumb = '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><a href="' . $this->categorySeoName . '/colectia-' . $this->collectionSeoName . '">' . $this->categoryName . '</a><span style="float:left">&nbsp; &raquo; &nbsp;</span><a href="' . $this->categorySeoName . '/colectia-' . $this->collectionSeoName . '">' . $this->collectionName . '</a>';
					 $offset = $_REQUEST['offset'];
					 if (!isset($_REQUEST['variant_id'])) 
					 {
					 	
			             $breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span>
								 <span style="float:left">' . $this->productName.'</span>';
					 }
					 else
					 {
					 	$breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span><a href="' . $this->categorySeoName . '/colectia-' . $this->collectionName . '/p='. $this->productSeoName.'&id='.$offset.'">' . $this->productName . '</a>';
						$this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
           			    $row = $this->query->result->fetch_object();
			            $breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span>
						    <span style="float:left">' . $row->product_name. '</span>';
					 }
					 
				
				}
				
			}
        } 
		else 
		{
            if ($this->collectionId == NULL)
			{
               if($this->productName == NULL)
				{
			    	$breadcrumb = '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span ><a href="' . $this->categorySeoName . '/' . $this->activeSubcategorySeoName . '">' . $this->categoryName . '</a><span style="float:left">&nbsp; &raquo; &nbsp;</span>	
					<span style="float:left">' . $this->activeSubcategoryName . '</span>';
				}
				else
				{
					$breadcrumb = '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span ><a href="' . $this->categorySeoName . '/' . $this->activeSubcategorySeoName . '">' . $this->categoryName . '</a><span style="float:left">&nbsp; &raquo; &nbsp;</span>	
					<a href="' . $this->categorySeoName . '/' . $this->activeSubcategorySeoName . '">' . $this->activeSubcategoryName. '</a>';
					 
					 $offset = $_REQUEST['offset'];
					 if (!isset($_REQUEST['variant_id'])) 
					 {
					 	
			             $breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span>
								 <span style="float:left">' . $this->productName.'</span>';
					 }
					 else
					 {
					 	$breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span><a href="' . $this->categorySeoName . '/' . $this->activeSubcategorySeoName.'/p='. $this->productSeoName.'&id='.$offset.'">' . $this->productName . '</a>';
						$this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
           			    $row = $this->query->result->fetch_object();
			            $breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span>
						    <span style="float:left">' . $row->product_name. '</span>';
					 }
				}
			}
            else
			{
                if($this->productName == NULL)
				{
					$breadcrumb = '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span ><a href="' . $this->categorySeoName . '/colectia-' . $this->collectionName . '">' . $this->categoryName . '</a><span style="float:left">&nbsp; &raquo; &nbsp;</span>
								 <span style="float:left">' . $this->collectionName . '&nbsp; &raquo; &nbsp; ' . $this->activeSubcategoryName . '</span>';
				}
				else
				{
					$breadcrumb = '<a href="http://www.greenforest.ro">Acasa</a><span style="float:left">&nbsp; &raquo; &nbsp;</span ><a href="' . $this->categorySeoName . '/colectia-' . $this->collectionName . '">' . $this->categoryName . '</a><span style="float:left">&nbsp; &raquo; &nbsp;</span>
								 <a href="' . $this->categorySeoName .'/colectia-' . $this->collectionName . '">' . $this->collectionName . '</a><span style="float:left">&nbsp; &raquo; &nbsp;</span>
								 <a href="' . $this->categorySeoName . '/'.$this->activeSubcategorySeoName.'/colectia-' . $this->collectionName . '">' . $this->activeSubcategoryName . '</a>';
				    
					$offset = $_REQUEST['offset'];
					if (!isset($_REQUEST['variant_id'])) 
					 {
					 	
			             $breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span>
								 <span style="float:left">' . $this->productName.'</span>';
					 }
					 else
					 {
					 	$breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span><a href="' . $this->categorySeoName . '/' . $this->activeSubcategorySeoName.'/colectia-' . $this->collectionName . '/p='. $this->productSeoName.'&id='.$offset.'">' . $this->productName . '</a>';
						$this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
           			    $row = $this->query->result->fetch_object();
			            $breadcrumb .= '<span style="float:left">&nbsp; &raquo; &nbsp;</span>
						    <span style="float:left">' . $row->product_name. '</span>';
					 }
				}
			}
        }
			
        return $breadcrumb;
    }
    
    
    
    public function displayPage()
    {
        if (isset($_REQUEST['offset']))
            $offset = $_REQUEST['offset'];
        else
            $offset = 0;
        return "Pagina " . (($offset / 3) + 1) . " din " . ceil($this->nbProducts / 3);
        
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
        if ($this->productId != NULL) {
            $product_id = $this->productId;
            $this->query->execute('SELECT * FROM `products` WHERE `id` = ' . $product_id);
            $row = $this->query->result->fetch_object();
            if (!isset($_REQUEST['variant_id'])) {
                
                
                $this->query->execute('SELECT * FROM `variant_of_product` WHERE `product_id` = ' . $product_id . ' ORDER BY `variant_id`');
                
                $variants = "";
                $num_rows = $this->query->result->num_rows;
                if ($num_rows) {
                    $nb_var = 0;
                    
                    while ($row1 = $this->query->result->fetch_object()) {
                        $nb_var++;
                        $href = ($this->productId != NULL) ? $this->getCurrentUrl() . '-' . $row1->variant_id : $this->getCurrentUrl() . '/p=' . $seo_name . '&id=0-' . $row1->variant_id;
                        
                        
                        
                        if ($row1->variant_id == $row->selected_var_id)
                            $id = "id='selected_variant'";
                        else
                            $id = "";
                        
                        if ($num_rows == 1)
                            $id = "";
                        if ($nb_var < $num_rows) {
                            $variants .= '<a class="product_variant" href="' . $href . '" ' . $id . '>' . $row1->short_name . '<input type="hidden" class="variant_image" value="images/products/' . $row1->image . '"/></a>';
                        } else {
                            $variants .= '<a class="product_variant" href="' . $href . '" ' . $id . '>' . $row1->short_name . '<input type="hidden" class="variant_image" value="images/products/' . $row1->image . '"/></a>';
                        }
                    }
                }
                
                
                
                $product_info .= ' <div class="product_info"><div id="product_title"><div id="product_title_outer"><div id ="product_title_inner"><h1 style="white-space:nowrap;">' . $row->name . '</h1></div></div></div>
								 <div class="clear_box"></div>
								 <div id="product_big_image"><img src="images/products/' . $row->image . '" style="box-shadow: 2px 2px 2px 0px rgba(0, 0, 0, 0.35);" alt="' . $row->alt_image . '"/></div>
								 <div id="prod_variants"><div id="product_variants_outer"><div id="product_variants_inner"><b>Selectează produsul:</b> ' . $variants . '</div></div>
								 </div>
								 <div class="clear_box"></div>
								 <div class="product_range_desc">' . $this->getProductsDescription() . '</div>
								 </div>
								 <div class="clear_box"></div>';
                
            } else {
                $this->query->execute('SELECT * FROM `variant_of_product` WHERE `variant_id` = ' . $_REQUEST['variant_id']);
                if (!$this->query->result->num_rows)
				{
                    header('HTTP/1.0 404 Not Found', true, 404);
					readfile('page_not_found.php');
					exit();
				}
                $row1 = $this->query->result->fetch_object();
                
                
                if (($row->category_id == DULAPURI_CAT_ID || $row->category_id == CASETIERE_CAT_ID) && ($row->collection_id != COLECTIA_ELITE_ID) && ($row->collection_id != COLECTIA_INNO_ID)) {
                    if ($row->collection_id == COLECTIA_ERGO_ID) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
									  <div id="desc">' . $row1->description . '</div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div id="colors_frame"></div><div id="colors_frame_title">carcasa: <span>alb, gri</span></div>
									  <div id="colors_f"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb"  style="float:left;border:1px solid #d9d9cf;"/> <img src="images/products/' . $row1->color_2 . '" alt="culoare gri"  style="float:left;margin-left:15px;border:1px solid #d9d9cf;"/></div>
									 <div id="colors_material"></div><div id="colors_material_title">fronturi: <span>alb, gri, albastru, mesteacăn, fag</span></div>
									 <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									  <div id="variant_schema">';
                        if ($row1->schema)
                            $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                        $product_info .= '</div></div>
									  <div class="clear_box"></div></div>';
                        
                    } else if ($row->collection_id == COLECTIA_TOP_ID) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
									  <div id="desc" style="border-bottom:none">' . $row1->description . '</div>
									 ' . $social_buttons . '
									  </div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									  <div id="variant_schema">';
                        if ($row1->schema)
                            $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                        $product_info .= '</div></div>
									  <div class="clear_box"></div></div>';
                    } else {
                        if ($this->productName == "Dulapuri cu usa rulou") {
                            $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
									  <div id="desc">' . $row1->description . '</div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div id="colors_frame"></div><div id="colors_frame_title">carcasa: <span>alb, gri</span></div>
									  <div id="colors_f"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb"  style="float:left;border:1px solid #d9d9cf;"/> <img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;border:1px solid #d9d9cf;"/></div>
									  <div id="colors_material"></div><div id="colors_material_title">rulou: <span>gri</span></div>
									  <div id="colors_m"><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" " style="float:left;"/><div class="clear_box"></div></div>
									  ' . $social_buttons . '
									  </div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									  <div id="variant_schema">';
                            if ($row1->schema)
                                $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                            $product_info .= '</div></div>
									  <div class="clear_box"></div></div>';
                        } else {
                            $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
									  <div id="desc">' . $row1->description . '</div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div id="colors_frame"></div><div id="colors_frame_title">carcasa: <span>alb, gri</span></div>
									  <div id="colors_f"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb"  style="float:left;border:1px solid #d9d9cf;"/> <img src="images/products/' . $row1->color_2 . '" alt="culoare gri"  style="float:left;margin-left:15px;border:1px solid #d9d9cf;"/></div>
									  <div id="colors_material"></div><div id="colors_material_title">fronturi: <span>alb, gri, mesteacăn, fag</span></div>
									  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb"  style="float:left"/> <img src="images/products/' . $row1->color_2 . '"  alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									  <div id="variant_schema">';
                            if ($row1->schema)
                                $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                            $product_info .= '</div></div>
									  <div class="clear_box"></div></div>';
                        }
                    }
                    
                } else if ($row->category_id == ETAJERE_CAT_ID) {
                    
                    if ($row->collection_id != COLECTIA_ERGO_ID) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_frame"></div><div id="colors_frame_title">carcasa: <span>alb, gri</span></div>
								  <div id="colors_f" style="border-bottom:none !important"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb"  style="float:left;border:1px solid #d9d9cf;"/> <img src="images/products/' . $row1->color_2 . '" alt="culoare_gri" style="float:left;margin-left:15px;border:1px solid #d9d9cf;"/><div class="clear_box"></div></div>
								  ' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                        if ($row1->schema)
                            $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                        $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                        
                    } else {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_material"></div><div id="colors_material_title">carcasa: <span>alb, gri, albastru, mesteacăn, fag</span></div>
									 <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
								  ' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                        if ($row1->schema)
                            $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                        $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                    }
                } else if ($row->id == MESE_MEETING_ERGO_ERM_ID) {
                    $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
								  ' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                } else if ($row->id == MESE_MEETING_ERGO_ERMV_ID) {
                    $product_info .= '<div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>alb, gri</span></div>
								  <div id="colors_f"><img src="images/products/' . $row1->frame_4 . '" alt="" style="float:left;"/><img src="images/products/' . $row1->frame_6 . '" alt="" style="float:left;margin-left:10px;"/></div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
									' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                } else if ($row->id == MESE_MEETING_ERGO_ERMTS_ID) {
                    $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>alb, gri</span></div>
								  <div id="colors_f"><img src="images/products/' . $row1->frame_3 . '" alt="" style="float:left;"/><img src="images/products/' . $row1->frame_5 . '" alt="" style="float:left;margin-left:10px;"/></div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
								  ' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                } else if ($row->id == MESE_DISCUTII_ERGO_ERMD_ID) {
                    $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>alb, gri</span></div>
								  <div id="colors_f"></div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
								  ' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                } else if ($row->id == MESE_DISCUTII_ERGO_ERM_ID) {
                    $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>alb, gri</span></div>
								  <div id="colors_f"></div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
									' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                } else if ($row->id == MESE_MEETING_ERGO_ERMO_ID) {
                    $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>alb, gri</span></div>
								  <div id="colors_f"></div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
									' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                } else if ($row->category_id == SCAUNE_ERGONOMICE_ID) {
                    
                    if ($row1->arms_chairs_img)
                        $img_arms = '<img src="images/products/' . $row1->arms_chairs_img . '"/>';
                    else
                        $img_arms = '';
                    if ($row1->variant_id == X_PANDER_ID) {
                        
                        
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Bra&#355;e:</div>
									  <div style="float:left;width:330px;padding-left:20px;padding-top:3px">' . $row1->arms_chairs_text . '</div>
									  <div style="float:left;">' . $img_arms . '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;width:330px;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px"><div style="width:100px;float:left">Cu spatar negru:</div><img src="images/products/X-Pander_colors_1.jpg" alt="culori" style="float:left"/> <div class="clear_box"></div>
											  
											  <div style="width:100px;float:left">Cu spatar alb:</div><img src="images/products/X-Pander_colors_2.jpg" alt="culori" style="float:left"/> <div class="clear_box"></div>
											  </div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  </div><div class="clear_box"></div></div>';
                        
                    } else if ($row1->variant_id == 1100 || $row1->variant_id == 1131 || $row1->variant_id == 1141 || $row1->variant_id == 1151 || $row1->variant_id == 1161 || $row1->variant_id == 1162 || $row1->variant_id == 1171 || $row1->variant_id == 1172 || $row1->variant_id == 1180 || $row1->variant_id == 1220 || $row1->variant_id == 1221 || $row1->variant_id == 1222 || $row1->variant_id == 1230 || $row1->variant_id == 1231 || $row1->variant_id == 1232 || $row1->variant_id == 1260 || $row1->variant_id == 1261 || $row1->variant_id == 1271 || $row1->variant_id == 1272) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Bra&#355;e:</div>
									  <div style="float:left;width:330px;padding-left:20px;padding-top:3px">' . $row1->arms_chairs_text . '</div>
									  <div style="float:left;">' . $img_arms . '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;width:330px;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px">';
                        if ($row1->colors_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" />';
                        $product_info .= ' <div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  </div><div class="clear_box"></div></div>';
                    } else if ($row1->variant_id == 1190 || $row1->variant_id == 1191 || $row1->variant_id == 1181 || $row1->variant_id == 1240 || $row1->variant_id == 1250) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Bra&#355;e:</div>
									  <div style="float:left;width:330px;padding-left:20px;padding-top:3px">' . $row1->arms_chairs_text . '</div>
									  <div style="float:left;">' . $img_arms . '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;width:330px;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px">';
                        if ($row1->colors_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" />';
                        $product_info .= '<div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  </div><div class="clear_box"></div></div>';
                    } else {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Bra&#355;e:</div>
									  <div style="float:left;width:330px;padding-left:20px;padding-top:3px">' . $row1->arms_chairs_text . '</div>
									  <div style="float:left;">' . $img_arms . '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;width:330px;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px">';
                        if ($row1->colors_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" />';
                        $product_info .= '<div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  </div><div class="clear_box"></div></div>';
                    }
                    
                } else if ($row->category_id == SCAUNE_EXECUTIVE_ID || $row->category_id == SCAUNE_MEETING_ID) {
                    
                    if ($row1->arms_chairs_img)
                        $img_arms = '<img src="images/products/' . $row1->arms_chairs_img . '"/>';
                    else
                        $img_arms = '';
                    
                    if ($row1->variant_id == 1200 || $row1->variant_id == 1210) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Bra&#355;e:</div>
									  <div style="float:left;width:330px;padding-left:20px;padding-top:3px">' . $row1->arms_chairs_text . '</div>
									  <div style="float:left;">' . $img_arms . '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;width:330px;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px">';
                        if ($row1->colors_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" />';
                        $product_info .= '<div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div><div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  <div class="clear_box"></div></div></div>';
                    } else if ($row1->variant_id == 1280 || $row1->variant_id == 1281 || $row1->variant_id == 1290) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Bra&#355;e:</div>
									  <div style="float:left;width:330px;padding-left:20px;padding-top:3px">' . $row1->arms_chairs_text . '</div>
									  <div style="float:left;">' . $img_arms . '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;width:330px;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px">';
                        if ($row1->colors_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" />';
                        $product_info .= '<div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  </div><div class="clear_box"></div></div>';
                    } else if ($row1->variant_id == 1300 || $row1->variant_id == 1301 || $row1->variant_id == 1302 || $row1->variant_id == 1310 || $row1->variant_id == 1311 || $row1->variant_id == 1312) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Bra&#355;e:</div>
									  <div style="float:left;width:330px;padding-left:20px;padding-top:3px">' . $row1->arms_chairs_text . '</div>
									  <div style="float:left;">' . $img_arms . '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;width:330px;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px">';
                        if ($row1->colors_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" />';
                        $product_info .= '<div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  </div><div class="clear_box"></div></div>';
                    } else {
					    
						
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>' . $row1->size_info . '</p>
									  <div id="desc" style="border-bottom:none;padding-left:0">' . $row1->description . '
									  <div id="colors_title">Optional:</div>
									  <div style="float:left;padding-top:3px">' . $row1->optional_chairs . '</div>
									  <div style="float:left;">';
                        if ($row1->roller_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->roller_chairs_img . '"/>';
                        $product_info .= '</div>
									  <div class="clear_box"></div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div style="padding:5px 0px 5px 20px">';
                        if ($row1->colors_chairs_img)
                            $product_info .= '<img src="images/products/' . $row1->colors_chairs_img . '" alt="culori" />';
                        $product_info .= '<div class="clear_box"></div></div>
										' . $social_buttons . '
									  </div></div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									 
									  </div><div class="clear_box"></div></div>';
                    }
                } else if ($row->collection_id == COLECTIA_ELITE_ID || $row->collection_id == COLECTIA_INNO_ID) {
                    $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>nuc aida, stejar ferrara deschis, stejar ferrara inchis</span></div>
								  <div id="colors_m"><img src="images/products/nuc-aida.jpg" alt="culoare nuc aida" style="float:left;margin-left:15px;"/><img src="images/products/stejar-ferrara-deschis.jpg" alt="culoare stejar ferrara decshis" style="float:left;margin-left:15px;"/><img src="images/products/stejar-ferrara-inchis.jpg" alt="culoare stejar ferrara inchis" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
								  ' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div><div class="clear_box"></div></div>';
                    
                } else if ($row->collection_id == COLECTIA_ERGO_ID || $row->collection_id == COLECTIA_SITSTAND_ID) {
                    $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
								  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>alb, gri</span></div>
								  <div id="colors_f">';
								  if($row1->frame_3 && $row1->frame_4 && $row1->frame_5 && $row1->frame_6 )  $product_info .= '<img src="images/products/' . $row1->frame_3 . '" alt=""  style="float:left"/> <img src="images/products/' . $row1->frame_4 . '" alt="" style="float:left;margin-left:10px;"/><img src="images/products/' . $row1->frame_5 . '" alt="" style="float:left;margin-left:20px;"/><img src="images/products/' . $row1->frame_6 . '" alt="" style="float:left;margin-left:10px;"/>';
								  $product_info .= '</div>
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
									' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div><div class="clear_box"></div></div>';
                    
                } else if ($row->collection_id == COLECTIA_ACTIVE_ID || $row->collection_id == COLECTIA_WORK_ID) {
                    if ($row->id != 202 && $row->id != 252) {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
				
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, albastru, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_5 . '" alt="culoare albastru" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
									' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                        if ($row1->schema)
                            $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                        $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                    } else {
                        $product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc">' . $row1->description . '</div>
								  <div id="colors_title">Culori disponibile:</div>
				
								  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, mesteacăn, fag</span></div>
								  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/><img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
									' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                        if ($row1->schema)
                            $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                        $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                    }
                    
                } else if ($row->collection_id == COLECTIA_TOP_ID) {
                    $product_info .= ' <div class="product_detailed_info" ><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
								  <div id="desc" style="border-bottom:none">' . $row1->description . '</div>
								
								  ' . $social_buttons . '
								  </div>
								  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
								  <div id="variant_schema">';
                    if ($row1->schema)
                        $product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
                    $product_info .= '</div></div>
								  <div class="clear_box"></div></div>';
                } else {
				
				    if($row->collection_id == COLECTIA_MOVI_ID)
					{
						
						
						
						$product_info .= ' <div class="product_detailed_info movi"><div id="variant_description" style="width:550px"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
									  <div id="desc">' . $row1->description . '</div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>crem fildes RAL 1015, alb RAL 9010, gri argintiu RAL 9006, gri antracit RAL 7024, negru RAL 9017, metal lacuit, rosu RAL 3000, galben RAL 1023, albastru RAL 5024, albastru aqua RAL 5021, verde RAL 6011, violet RAL 4007</span></div>';
						if($row->id == BIROU_MBA_ID || $row->id == MASA_MMA_ID)
						{			  
									  $product_info .= '<div id="colors_f" style="padding-left:0;height:180px"><a href="images/products/Cadru-crem-fildes-RAL-1015-picior-rectangular.jpg" style="float:left;" title="RAL 1015"><img src="images/products/RAL-1015-picior-rectangular.png" alt="cadru metalic RAL 1015" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-alb-RAL-9010-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 9010"><img src="images/products/RAL-9010-picior-rectangular.png" alt="cadru metalic RAL 9010" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-gri-argintiu-RAL-9006-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 9006"><img src="images/products/RAL-9006-picior-rectangular.png" alt="cadru metalic RAL 9006" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-gri-antracit-RAL-7024-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 7024"><img src="images/products/RAL-7024-picior-rectangular.png" alt="cadru metalic RAL 7024" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-negru-RAL-9017-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 9017"><img src="images/products/RAL-9017-picior-rectangular.png" alt="cadru metalic RAL 9017" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-metal-lacuit-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="metal"><img src="images/products/metal-picior-rectangular.png" alt="cadru metal lacuit"/ style="width:80px;height:73px;"></a>
									  <div style="clear:both;height:15px" ></div>
									  <a href="images/products/Cadru-rosu-RAL-3000-picior-rectangular.jpg" style="float:left;" title="RAL 3000"><img src="images/products/RAL-3000-picior-rectangular.png" alt="cadru metalic RAL 3000" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-galben-RAL-1023-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 1023"><img src="images/products/RAL-1023-picior-rectangular.png" alt="cadru metalic RAL 1023" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-albastru-RAL-5024-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 5024"><img src="images/products/RAL-5024-picior-rectangular.png" alt="cadru metalic RAL 5024" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-albastru-aqua-RAL-5021-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 5021"><img src="images/products/RAL-5021-picior-rectangular.png" alt="cadru metalic RAL 5021" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-verde-RAL-6011-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 6011"><img src="images/products/RAL-6011-picior-rectangular.png" alt="cadru metalic RAL 6011" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-violet-RAL-4007-picior-rectangular.jpg" style="float:left;margin-left:10px;" title="RAL 4007"><img src="images/products/RAL-4007-picior-rectangular.png" alt="cadru metalic RAL 4007"/ style="width:80px;height:73px;"></a>
									  
									  
									  </div>';
						}
						else 
						{
							 $product_info .= '<div id="colors_f" style="padding-left:0;height:180px"><a href="images/products/Cadru-crem-fildes-RAL-1015-picior-rotund.jpg" style="float:left;" title="RAL 1015"><img src="images/products/RAL-1015.png" alt="cadru metalic RAL 1015" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-alb-RAL-9010-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 9010"><img src="images/products/RAL-9010.png" alt="cadru metalic RAL 9010" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-gri-argintiu-RAL-9006-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 9006"><img src="images/products/RAL-9006.png" alt="cadru metalic RAL 9006" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-gri-antracit-RAL-7024-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 7024"><img src="images/products/RAL-7024.png" alt="cadru metalic RAL 7024" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-negru-RAL-9017-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 9017"><img src="images/products/RAL-9017.png" alt="cadru metalic RAL 9017" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-metal-lacuit-picior-rotund.jpg" style="float:left;margin-left:10px;" title="metal"><img src="images/products/metal.png" alt="cadru metal lacuit"/ style="width:80px;height:73px;"></a>
									  <div style="clear:both;height:15px" ></div>
									  <a href="images/products/Cadru-rosu-RAL-3000-picior-rotund.jpg" style="float:left;" title="RAL 3000"><img src="images/products/RAL-3000.png" alt="cadru metalic RAL 3000" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-galben-RAL-1023-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 1023"><img src="images/products/RAL-1023.png" alt="cadru metalic RAL 1023" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-albastru-RAL-5024-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 5024"><img src="images/products/RAL-5024.png" alt="cadru metalic RAL 5024" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-albastru-aqua-RAL-5021-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 5021"><img src="images/products/RAL-5021.png" alt="cadru metalic RAL 5021" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-verde-RAL-6011-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 6011"><img src="images/products/RAL-6011.png" alt="cadru metalic RAL 6011" style="width:80px;height:73px;"/></a><a href="images/products/Cadru-violet-RAL-4007-picior-rotund.jpg" style="float:left;margin-left:10px;" title="RAL 4007"><img src="images/products/RAL-4007.png" alt="cadru metalic RAL 4007"/ style="width:80px;height:73px;"></a>
									  
									  
									  </div>';
						}
						$product_info .= '<div id="colors_material"></div><div id="colors_material_title">culori PAL melaminat uni: <span>iasomie U116, alb W1000, gri uni U708, verde fistic U608, albastru denim U540, grafit U961 </span></div>
									  <div id="colors_m" style="padding-left:20px;margin-left:0;"><a href="images/products/PAL-MELAMINAT-UNI-U116-IASOMIE.jpg" style="float:left;" title="U116"><img src="images/products/PAL-melaminat-iasomie-U116.jpg" alt="PAL melaminat iasomie U116" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT-UNI-ALB-W1000.jpg" style="float:left;margin-left:10px;" title="W1000"><img src="images/products/PAL-melaminat-alb-W1000.jpg" alt="PAL melaminat alb W1000" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT-UNI-GRI-U708.jpg" style="float:left;margin-left:10px;" title="U708"><img src="images/products/PAL-melaminat-gri-uni-U708.jpg" alt="PAL melaminat gri uni U708" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT-UNI-VERDE-FISTIC-U608.jpg" style="float:left;margin-left:10px;" title="U608"><img src="images/products/PAL-melaminat-verde-fistic-U608.jpg" alt="PAL melaminat verde fistic U608" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT-UNI-ALBASTRU-DENIM-U540.jpg" style="float:left;margin-left:10px;" title="U540"><img src="images/products/PAL-melaminat-albastru-denim-U540.jpg" alt="PAL melaminat albastru denim U540" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT-UNI-NEGRU-GRAFIT-U961.jpg" style="float:left;margin-left:10px;" title="U961"><img src="images/products/PAL-melaminat-grafit-U961.jpg" alt="PAL melaminat grafit U961" style="width:80px;height:80px;"></a><div class="clear_box"></div></div>
									  
									  <div class="colors_material_title">culori PAL melaminat fibra lemn: <span> mesteacan H1733, stejar ferara H1334, fag bavaria H1511, nuc pacific H3700, nuc aida H3704, stejar ferara H1137</span></div>
									  <div class="colors_m" style="padding-left:20px;margin-left:0;"><a href="images/products/PAL-MELAMINAT_MESTEACAN-H1733.jpg" style="float:left;" title="H1733"><img src="images/products/PAL-melaminat-mesteacan-H1733.jpg" alt="PAL melaminat mesteacan H1733" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT_STEJAR-FERARA-H1334.jpg" style="float:left;margin-left:10px;" title="H1334"><img src="images/products/PAL-melaminat-stejar-ferara-H1334.jpg" alt="PAL melaminat stejar ferara H1334" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT_FAG-BAVARIA-H1511.jpg" style="float:left;margin-left:10px;" title="H1511"><img src="images/products/PAL-melaminat-fag-bavaria-H1511.jpg" alt="PAL melaminat fag bavaria H1511" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT_NUC-PACIFIC-H3700.jpg" style="float:left;margin-left:10px;" title="H3700"><img src="images/products/PAL-melaminat-nuc-pacific-H3700.jpg" alt="PAL melaminat nuc pacific H3700" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT_NUC-AIDA-H3704.jpg" style="float:left;margin-left:10px;" title="H3704"><img src="images/products/PAL-melaminat-nuc-aida-H3704.jpg" alt="PAL melaminat nuc aida H3704" style="width:80px;height:80px;"/></a><a href="images/products/PAL-MELAMINAT_STEJAR-FERARA-H1137.jpg" style="float:left;margin-left:10px;" title="H1137"><img src="images/products/PAL-melaminat-stejar-ferara-H1137.jpg" alt="PAL melaminat stejar ferara H1137"/ style="width:80px;height:80px;"></a><div class="clear_box"></div></div>
									  
									  ' . $social_buttons . '
									  </div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									  <div id="variant_schema">';
						if ($row1->schema)
							$product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
						$product_info .= '</div></div>
									  <div class="clear_box"></div></div>';
					}
					else
					{
						$product_info .= ' <div class="product_detailed_info"><div id="variant_description"><h1>' . $row1->product_name . '</h1><p>(' . $row1->size_info . ')</p>
									  <div id="desc">' . $row1->description . '</div>
									  <div id="colors_title">Culori disponibile:</div>
									  <div id="colors_frame"></div><div id="colors_frame_title">cadru metalic: <span>alb, gri</span></div>
									  <div id="colors_f"><img src="images/products/' . $row1->frame_1 . '" alt=""  style="float:left"/> <img src="images/products/' . $row1->frame_2 . '" alt="" style="float:left;margin-left:15px;"/></div>
									  <div id="colors_material"></div><div id="colors_material_title">materiale blat: <span>alb, gri, mesteacăn, fag</span></div>
									  <div id="colors_m"><img src="images/products/' . $row1->color_1 . '" alt="culoare alb" style="float:left"/> <img src="images/products/' . $row1->color_2 . '" alt="culoare gri" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_3 . '" alt="culoare mesteacan" style="float:left;margin-left:15px;"/><img src="images/products/' . $row1->color_4 . '" alt="culoare fag" style="float:left;margin-left:15px;"/><div class="clear_box"></div></div>
									  ' . $social_buttons . '
									  </div>
									  <div id="variant_images"><img src="images/products/' . $row1->image . '" style="box-shadow: 3px 3px 3px 0px rgba(0, 0, 0, 0.35);" alt="' . $row1->alt_image . '" />
									  <div id="variant_schema">';
					if ($row1->schema)
						$product_info .= '<img src="images/products/' . $row1->schema . '"  alt="' . $row1->alt_schema . '"/>';
					$product_info .= '</div></div>
								  <div class="clear_box"></div></div>';

					}
                }
                
            }
            $product_info .= '<div class="horizontal_line_products" style="margin-top:0px;height:11px"></div>
								<a href="javascript:window.history.back();" class="arrow_back_grey hidden-xs "><img src="images/back-arrow.png" alt=""/></a><div class="breadcrumb hidden-xs">' . $this->breadcrumb() . '</div>
								<div class="clear_box"></div>';
        } else {
            $product_info = "<div style='height:47px'></div>";
        }
        
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
            if (isset($_REQUEST['offset']))
                $url .= '&id=' . $_REQUEST['offset'];
            else
                $url .= '&id=0';
            if (isset($_REQUEST['variant_id']))
                $url .= '-' . $_REQUEST['variant_id'];
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