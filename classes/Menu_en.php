<?php
    define('CATEGORIA_BIROURI_OPERATIVE_ID','1');
	define('CATEGORIA_BIROURI_EXECUTIVE_ID','6');
	define('CATEGORIA_BIROURI_REGLABILE_ID','7');
	define('CATEGORIA_CORPURI_DEPOZITARE_ID','2');
	define('CATEGORIA_MESE_ID','3');
	define('CATEGORIA_SCAUNE_ID','4');
	define('CATEGORIA_SCAUNE_OPERATIVE_ID','41');
	define('CATEGORIA_SCAUNE_EXECUTIVE_ID','42');
	define('CATEGORIA_SCAUNE_MEETING_ID','43');	
	define('CATEGORIA_SOLUTII_LOUNGE_ID','44');	
	define('MOBILIER_ID','1');
	define('SCAUNE_ID','2');
	define('COMUNICARE_E_ID','3');
	class Menu
	{
		private $query;

		
		public function __construct($query)
		{
			$this->query = $query;
		}
		
		
		public function displayHeaderMainMenu()
		{
		
			$menu = 
			'<div class="header_main_menu">
    			 <div id="ddtopmenubar" class="mattblackmenu">
					 <ul>
						<li><a id="colectii" rel="ddsubmenu1">Collections</a></li>
						<li><a id="produse"  rel="ddsubmenu2">Products</a></li>
						<li><a id="proiecte" rel="ddsubmenu3">Projects</a></li>
					</ul>
				</div>
				<script type="text/javascript">
					ddlevelsmenu.setup("ddtopmenubar", "topbar");
				</script>
				
				<ul id="ddsubmenu1" class="ddsubmenustyle">';
						
					$this->query->execute("SELECT * FROM `collections` WHERE `parrent_id` IS NULL ORDER BY `id`;");
					
					$result = $this->query->result;
					$num_rows = $result->num_rows;
					if($num_rows > 0)
					{
						while($row= $result->fetch_object())
						{
							
							$children = $this->get_collection_children($row->id);    
							if($children['num_children'] > 0)
							{
								$menu .= '<li><a>'.$row->name_en.'</a>';
								$menu .= '<ul>';
								for ($i=0; $i< $children['num_children'];$i++)
								{
									if($row->id == MOBILIER_ID)
									{
										if($children['children_seo_names'][$i] != 'Active' && $children['children_seo_names'][$i] != 'Top' && $children['children_seo_names'][$i] != 'Work' && $children['children_seo_names'][$i] != 'SitStand')
										$menu .= '<li><a href="en/'.$children['children_seo_names'][$i].'-furniture-collection">'.$children['children_names'][$i].'</a></li>';
									}
									else if($row->id == SCAUNE_ID)
									{
										$menu .= '<li><a href="en/Chairs-'.$children['children_seo_names'][$i].'">'.$children['children_names'][$i].'</a></li>';
									}
									
								}
								$menu .= '</ul></li>';
							}
							else
							{
								if(($row->id == MOBILIER_ID) || ($row->id == COMUNICARE_E_ID))
								{
									if($row->seo_name!="Comunicare-e")
										$menu .= '<li><a href="en/'.$row->seo_name_en.'-furniture-collection">'.$row->name_en.'</a></li>';
									else
									   $menu .= '<li><a href="en/'.$row->seo_name_en.'-collection">'.$row->name_en.'</a></li>';
								}
								else if($row->id == SCAUNE_ID)
								{
									$menu .= '<li><a href="en/Chairs-'.$row->seo_name_en.'">'.$row->name_en.'</a></li>';
								}
							}
						}
					}	
							
								
				$menu .= '</ul>';
			
			$menu .='<ul id="ddsubmenu2" class="ddsubmenustyle">';
					
 			$this->query->execute("SELECT * FROM `categories` WHERE `parrent_id` IS NULL ORDER BY `ord_menu`;");
			
            $result = $this->query->result;
			$num_rows = $result->num_rows;
			if($num_rows > 0)
			{
				while($row= $result->fetch_object())
				{
					
					if($row->id == CATEGORIA_BIROURI_OPERATIVE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul><li><a href="en/Operative-desks/collection-ErgoPlus">ErgoPlus</a></li>
						              <li><a href="en/Operative-desks/collection-Ergo">Ergo</a></li>
									  <li><a href="en/Operative-desks/collection-Active">Active</a></li>
									  <li><a href="en/Operative-desks/collection-Work">Work</a></li></ul></li>';
					}
					else if($row->id == CATEGORIA_CORPURI_DEPOZITARE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul><li><a href="en/Storage-furniture/collection-ErgoPlus">ErgoPlus</a></li>
						              <li><a href="en/Storage-furniture/collection-Ergo">Ergo</a></li>
									  <li><a href="en/Storage-furniture/collection-Elite">Elite</a></li>
									  <li><a href="en/Storage-furniture/collection-Inno">Inno</a></li>
									  <li><a href="en/Storage-furniture/collection-Top">Top</a></li>
									  </ul></li>';
					}
					else if($row->id == CATEGORIA_MESE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul><li><a href="en/Tables/collection-ErgoPlus">ErgoPlus</a></li>
						              <li><a href="en/Tables/collection-Ergo">Ergo</a></li>
									  <li><a href="en/Tables/collection-Elite">Elite</a></li>
									  <li><a href="en/Tables/collection-Inno">Inno</a></li>
									  <li><a href="en/Tables/collection-Top">Top</a></li>
									   <li><a href="en/Tables/collection-Movi">Movi</a></li>
									  </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_OPERATIVE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul>
									 <li><a href="en/Operative-chairs/collection-Topstar">Topstar</a></li>
									 <li><a href="en/Operative-chairs/collection-Wagner">Wagner</a></li>
									 <li><a href="en/Operative-chairs/collection-Patra">Patra</a></li>
								 </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_EXECUTIVE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul>
									 <li><a href="en/Executive-chairs/collection-Topstar">Topstar</a></li>
									 <li><a href="en/Executive-chairs/collection-Wagner">Wagner</a></li>
								 </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_MEETING_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul>
									 <li><a href="en/Meeting-chairs/collection-Topstar">Topstar</a></li>
								 </ul></li>';
					}
					else if($row->id == CATEGORIA_SOLUTII_LOUNGE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul>
									 <li><a href="en/Lounge-solutions/collection-Wagner">Wagner</a></li>
								 </ul></li>';
					}
					else if($row->id == CATEGORIA_BIROURI_EXECUTIVE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul><li><a href="en/Executive-desks/collection-Elite">Elite</a></li>
						              <li><a href="en/Executive-desks/collection-Inno">Inno</a></li>
									  <li><a href="en/Executive-desks/collection-Top">Top</a></li>
						              </ul></li>';
					}
					else if($row->id == CATEGORIA_BIROURI_REGLABILE_ID)
					{
						$menu .= '<li><a>'.$row->name_en.'</a>';
						$menu .= '<ul><li><a href="en/Adjustable-desks/collection-SitStand">SitStand</a></li>
						              <li><a href="en/Adjustable-desks/collection-Movi">Movi</a></li>
						              </ul></li>';
					}
					else $menu .= '<li><a href="en/'.$row->seo_name_en.'">'.$row->name_en.'</a></li>';
					
					
					
					
				}
			}
				$menu .='</ul>';
						
			$menu .='<ul id="ddsubmenu3" class="ddsubmenustyle">';
					
 			$this->query->execute("SELECT * FROM `projects` ORDER BY `name_en`;");
			
            $result = $this->query->result;
			$num_rows = $result->num_rows;
			if($num_rows > 0)
			{
				while($row= $result->fetch_object())
				{
					$menu .= '<li><a href="en/Project-'.$row->seo_name_en.'">'.$row->name_en.'</a></li>';
				}
			}
			
			$menu .='</ul></div>';			
			return $menu; 				
						
		}
		public function getXsScreenMenu(){
		
		$menu = 
			'  <li class="dropdown">
					<a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">Colections <b class="caret"></b></a>
					<ul class="dropdown-menu">';
					
					$this->query->execute("SELECT * FROM `collections` WHERE `parrent_id` IS NULL ORDER BY `id`;");
					
					$result = $this->query->result;
					$num_rows = $result->num_rows;
					if($num_rows > 0)
					{
						while($row= $result->fetch_object())
						{
							
							if($row->id == COMUNICARE_E_ID)
							{
								$menu .=  '<li><a href="en/'.$row->seo_name_en.'-collection" style="padding-bottom:15px">'.$row->name_en.'</a></li>';
							}
							else
							{
								$children = $this->get_collection_children($row->id);    
								if($children['num_children'] > 0)
								{
									$menu .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.' <b class="caret"></b></a>
												<ul class="dropdown-menu">';
									
									for ($i=0; $i< $children['num_children'];$i++)
									{
										if($row->id == MOBILIER_ID)
										{
											if($children['children_seo_names'][$i] != 'Active' && $children['children_seo_names'][$i] != 'Top' && $children['children_seo_names'][$i] != 'Work' && $children['children_seo_names'][$i] != 'SitStand')
											$menu .= '<li><a href="en/'.$children['children_seo_names'][$i].'-furniture-collection">-->'.$children['children_names'][$i].'</a></li>';
										}
										else if($row->id == SCAUNE_ID)
										{
											$menu .= '<li><a href="en/Chairs-'.$children['children_seo_names'][$i].'">-->'.$children['children_names'][$i].'</a></li>';
										}
										
									}
									$menu .= '</ul></li>';
								}
							}
							
						}
					}	
					$menu .='</ul></li>';
                  
                 $menu .='<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
					<ul class="dropdown-menu">';
					
					$this->query->execute("SELECT * FROM `categories` WHERE `parrent_id` IS NULL ORDER BY `ord_menu`;");
			
            $result = $this->query->result;
			$num_rows = $result->num_rows;
			if($num_rows > 0)
			{
				while($row= $result->fetch_object())
				{
					
					if($row->id == CATEGORIA_BIROURI_OPERATIVE_ID)
					{
						$menu .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><li><a href="en/Operative-desks/collection-ErgoPlus">-->ErgoPlus</a></li>
						              <li><a href="en/Operative-desks/collection-Ergo">-->Ergo</a></li>
									  <li><a href="en/Operative-desks/collection-Active">-->Active</a></li>
									  <li><a href="en/Operative-desks/collection-Work">-->Work</a></li></ul></li>';
					}
					
					else if($row->id== CATEGORIA_CORPURI_DEPOZITARE_ID)
					{
						$menu .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><a href="en/Storage-furniture/collection-ErgoPlus">-->ErgoPlus</a></li>
						              <li><a href="en/Storage-furniture/collection-Ergo">-->Ergo</a></li>
									  <li><a href="en/Storage-furniture/collection-Elite">-->Elite</a></li>
									  <li><a href="en/Storage-furniture/collection-Inno">-->Inno</a></li>
									  <li><a href="en/Storage-furniture/collection-Top">-->Top</a></li>
									  </ul></li>';
					}
					else if($row->id == CATEGORIA_MESE_ID)
					{
						$menu .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
						            <li><a href="en/Tables/collection-ErgoPlus">-->ErgoPlus</a></li>
						              <li><a href="en/Tables/collection-Ergo">-->Ergo</a></li>
									  <li><a href="en/Tables/collection-Elite">-->Elite</a></li>
									  <li><a href="en/Tables/collection-Inno">-->Inno</a></li>
									  <li><a href="en/Tables/collection-Top">-->Top</a></li>
									  <li><a href="en/Tables/collection-Movi">-->Movi</a></li>
									  </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_OPERATIVE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="en/Operative-chairs/collection-Topstar">-->Topstar</a></li>
												 <li><a href="en/Operative-chairs/collection-Wagner">-->Wagner</a></li>
												 <li><a href="en/Operative-chairs/collection-Patra">-->Patra</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_EXECUTIVE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="en/Executive-chairs/collection-Topstar">-->Topstar</a></li>
												 <li><a href="en/Executive-chairs/collection-Wagner">-->Wagner</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_MEETING_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="en/Meeting-chairs/collection-Topstar">-->Topstar</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_SOLUTII_LOUNGE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="en/Lounge-solutions/collection-Wagner">-->Wagner</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_BIROURI_EXECUTIVE_ID)
					{
					    $menu .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><a href="en/Executive-desks/collection-Elite">-->Elite</a></li>
						              <li><a href="en/Executive-desks/collection-Inno">-->Inno</a></li>
									  <li><a href="en/Executive-desks/collection-Top">-->Top</a></li>
						              </ul></li>';
					}
					else if($row->id == CATEGORIA_BIROURI_REGLABILE_ID)
					{
					    $menu .= '<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name_en.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><a href="en/Adjustable-desks/collection-SitStand">-->SitStand</a></li>
						                <li><a href="en/Adjustable-desks/collection-Movi">-->Movi</a></li>
						              </ul></li>';
					}
					else $menu .= '<li><a href="en/'.$row->seo_name_en.'">'.$row->name_en.'</a></li>';
					
					
					
					
				}
			}
					$menu .='</ul></li>';

                 $menu .=' <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">Projects <b class="caret"></b></a>';
					$menu .= '<ul class="dropdown-menu">';
						$this->query->execute("SELECT * FROM `projects` ORDER BY `name_en`;");
			
            $result = $this->query->result;
			$num_rows = $result->num_rows;
			if($num_rows > 0)
			{
				while($row= $result->fetch_object())
				{
					$menu .= '<li><a href="en/Project-'.$row->seo_name_en.'">'.$row->name_en.'</a></li>';
				}
			}
			
				  
				 $menu .='</ul></li>'; 
                  $menu .='<li><a href="en/About-us">About us</a></li>
				  <li><a href="http://e-shop.greenforest.ro">e-Shop</a></li>
                  <li><a href="http://www.greenforest.ro./blog">Blog</a></li>
				  <li><a href="en/Contact">Contact</a></li>
           ';
						
						
			return $menu; 					
		}
		
		private function get_collection_children($collection_id){
			$children= array();
		
			$this->query->execute("SELECT * FROM `collections` WHERE `parrent_id` = ". $collection_id." ORDER BY `id`;");
			
            $result = $this->query->result;
			$children['num_children'] = $result->num_rows;
			if($children['num_children'] > 0)
			{
				$i = 0;
				while($row = $result->fetch_object())
				{
					$children['children_seo_names'][$i] = $row->seo_name_en;
					$children['children_names'][$i] = $row->name_en;
					$i++;
				}
			}
			
			return $children;	
			
		}
		
}

