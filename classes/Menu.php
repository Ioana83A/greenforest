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
						<li><a id="colectii" rel="ddsubmenu1" >Colectii</a></li>
						<li><a id="produse" rel="ddsubmenu2">Produse</a></li>
						<li><a href="Servicii">Servicii</a></li>
						<li><a id="proiecte"  rel="ddsubmenu3">Proiecte</a></li>
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
								$menu .= '<li><a>'.$row->name.'</a>';
								$menu .= '<ul>';
								for ($i=0; $i< $children['num_children'];$i++)
								{
									if($row->id == MOBILIER_ID)
									{
										if($children['children_seo_names'][$i] != 'Active' && $children['children_seo_names'][$i] != 'Top' && $children['children_seo_names'][$i] != 'Work' && $children['children_seo_names'][$i] != 'SitStand')
										$menu .= '<li><a href="Colectia-mobilier-de-birou-'.$children['children_seo_names'][$i].'">'.$children['children_names'][$i].'</a></li>';
									
									}
									else if($row->id == SCAUNE_ID)
									{
										$menu .= '<li><a href="Scaune-'.$children['children_seo_names'][$i].'">'.$children['children_names'][$i].'</a></li>';
									}
									
								}
								$menu .= '</ul></li>';
							}
							else
							{
								if(($row->id == MOBILIER_ID) || ($row->id == COMUNICARE_E_ID))
								{
									if($row->seo_name!="Comunicare-e")
										$menu .= '<li><a href="Colectia-mobilier-de-birou-'.$row->seo_name.'">'.$row->name.'</a></li>';
									else 
										$menu .= '<li><a href="Colectia-'.$row->seo_name.'">'.$row->name.'</a></li>';
								}
								else if($row->id == SCAUNE_ID)
								{
									$menu .= '<li><a href="Scaune-'.$row->seo_name.'">'.$row->name.'</a></li>';
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
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul><li><a href="Birouri-operative/colectia-ErgoPlus">ErgoPlus</a></li>
						              <li><a href="Birouri-operative/colectia-Ergo">Ergo</a></li>
									  <li><a href="Birouri-operative/colectia-Active">Active</a></li>
									  <li><a href="Birouri-operative/colectia-Work">Work</a></li></ul></li>';
					}
					else if($row->id == CATEGORIA_CORPURI_DEPOZITARE_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul><li><a href="Corpuri-depozitare/colectia-ErgoPlus">ErgoPlus</a></li>
						              <li><a href="Corpuri-depozitare/colectia-Ergo">Ergo</a></li>
									  <li><a href="Corpuri-depozitare/colectia-Elite">Elite</a></li>
									  <li><a href="Corpuri-depozitare/colectia-Inno">Inno</a></li>
									  <li><a href="Corpuri-depozitare/colectia-Top">Top</a></li>
									  </ul></li>';
					}
					else if($row->id == CATEGORIA_MESE_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul><li><a href="Mese/colectia-ErgoPlus">ErgoPlus</a></li>
						              <li><a href="Mese/colectia-Ergo">Ergo</a></li>
									  <li><a href="Mese/colectia-Elite">Elite</a></li>
									  <li><a href="Mese/colectia-Inno">Inno</a></li>
									  <li><a href="Mese/colectia-Top">Top</a></li>
									  <li><a href="Mese/colectia-Movi">Movi</a></li>
									  </ul></li>';
					}
					
					else if($row->id == CATEGORIA_BIROURI_EXECUTIVE_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul><li><a href="Birouri-executive/colectia-Elite">Elite</a></li>
						              <li><a href="Birouri-executive/colectia-Inno">Inno</a></li>
									  <li><a href="Birouri-executive/colectia-Top">Top</a></li>
						              </ul></li>';
					}
					else if($row->id == CATEGORIA_BIROURI_REGLABILE_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul><li><a href="Birouri-reglabile/colectia-SitStand">SitStand</a></li>
									  <li><a href="Birouri-reglabile/colectia-Movi">Movi</a></li>
						              </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_OPERATIVE_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul>
									 <li><a href="Scaune-operative/colectia-Topstar">Topstar</a></li>
									 <li><a href="Scaune-operative/colectia-Wagner">Wagner</a></li>
									 <li><a href="Scaune-operative/colectia-Patra">Patra</a></li>
								 </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_EXECUTIVE_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul>
									 <li><a href="Scaune-executive/colectia-Topstar">Topstar</a></li>
									 <li><a href="Scaune-executive/colectia-Wagner">Wagner</a></li>
								 </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_MEETING_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul>
									 <li><a href="Scaune-meeting/colectia-Topstar">Topstar</a></li>
								 </ul></li>';
					}
					else if($row->id == CATEGORIA_SOLUTII_LOUNGE_ID)
					{
						$menu .= '<li><a>'.$row->name.'</a>';
						$menu .= '<ul>
									 <li><a href="Solutii-lounge/colectia-Wagner">Wagner</a></li>
								 </ul></li>';
					}
					else $menu .= '<li><a href="'.$row->seo_name.'">'.$row->name.'</a></li>';
					
					
					
					
				}
			}
			$menu .='</ul>';
						
			$menu .='<ul id="ddsubmenu3" class="ddsubmenustyle">';
					
 			$this->query->execute("SELECT * FROM `projects` ORDER BY `name`;");
			
            $result = $this->query->result;
			$num_rows = $result->num_rows;
			if($num_rows > 0)
			{
				while($row= $result->fetch_object())
				{
					$menu .= '<li><a href="Proiect-'.$row->seo_name.'">'.$row->name.'</a></li>';
				}
			}
			
			$menu .='</ul></div>';			
			return $menu; 					
		}
		public function getXsScreenMenu(){
		
		$menu = 
			'  <li class="dropdown">
					<a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">Colectii <b class="caret"></b></a>
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
								$menu .=  '<li><a href="Colectia-'.$row->seo_name.'" style="padding-bottom:15px">'.$row->name.'</a></li>';
							}
							else
							{
								$children = $this->get_collection_children($row->id);    
								if($children['num_children'] > 0)
								{
									$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.' <b class="caret"></b></a>
												<ul class="dropdown-menu">';
									
									for ($i=0; $i< $children['num_children'];$i++)
									{
										if($row->id == MOBILIER_ID)
										{
											if($children['children_seo_names'][$i] != 'Active' && $children['children_seo_names'][$i] != 'Top' && $children['children_seo_names'][$i] != 'Work' && $children['children_seo_names'][$i] != 'SitStand')
											$menu .= '<li><a href="Colectia-mobilier-de-birou-'.$children['children_seo_names'][$i].'">-->'.$children['children_names'][$i].'</a></li>';
										}
										else if($row->id == SCAUNE_ID)
										{
											$menu .= '<li><a href="Scaune-'.$children['children_seo_names'][$i].'">-->'.$children['children_names'][$i].'</a></li>';
										}
										
									}
									$menu .= '</ul></li>';
								}
							}
							
						}
					}	
					$menu .='</ul></li>';
                  
                 $menu .='<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">Produse <b class="caret"></b></a>
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
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><li><a href="Birouri-operative/colectia-ErgoPlus">-->ErgoPlus</a></li>
						              <li><a href="Birouri-operative/colectia-Ergo">-->Ergo</a></li>
									  <li><a href="Birouri-operative/colectia-Active">-->Active</a></li>
									  <li><a href="Birouri-operative/colectia-Work">-->Work</a></li></ul></li>';
					}
					
					else if($row->id== CATEGORIA_CORPURI_DEPOZITARE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><a href="Corpuri-depozitare/colectia-ErgoPlus">-->ErgoPlus</a></li>
						              <li><a href="Corpuri-depozitare/colectia-Ergo">-->Ergo</a></li>
									  <li><a href="Corpuri-depozitare/colectia-Elite">-->Elite</a></li>
									  <li><a href="Corpuri-depozitare/colectia-Inno">-->Inno</a></li>
									  <li><a href="Corpuri-depozitare/colectia-Top">-->Top</a></li>
									  </ul></li>';
					}
					else if($row->id == CATEGORIA_MESE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
						            <li><a href="Mese/colectia-ErgoPlus">-->ErgoPlus</a></li>
						              <li><a href="Mese/colectia-Ergo">-->Ergo</a></li>
									  <li><a href="Mese/colectia-Elite">-->Elite</a></li>
									  <li><a href="Mese/colectia-Inno">-->Inno</a></li>
									  <li><a href="Mese/colectia-Top">-->Top</a></li>
									  <li><a href="Mese/colectia-Movi">-->Movi</a></li>
									  </ul></li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_OPERATIVE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="Scaune-operative/colectia-Topstar">-->Topstar</a></li>
												 <li><a href="Scaune-operative/colectia-Wagner">-->Wagner</a></li>
												 <li><a href="Scaune-operative/colectia-Patra">-->Patra</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_EXECUTIVE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="Scaune-executive/colectia-Topstar">-->Topstar</a></li>
												 <li><a href="Scaune-executive/colectia-Wagner">-->Wagner</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_SCAUNE_MEETING_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="Scaune-meeting/colectia-Topstar">-->Topstar</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_SOLUTII_LOUNGE_ID)
					{
						$menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu">
											     <li><a href="Solutii-lounge/colectia-Wagner">-->Wagner</a></li>
											</ul>
									   </li>';
					}
					else if($row->id == CATEGORIA_BIROURI_EXECUTIVE_ID)
					{
					    $menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><a href="Birouri-executive/colectia-Elite">-->Elite</a></li>
						              <li><a href="Birouri-executive/colectia-Inno">-->Inno</a></li>
									  <li><a href="Birouri-executive/colectia-Top">-->Top</a></li>
						              </ul></li>';
					}
					else if($row->id == CATEGORIA_BIROURI_REGLABILE_ID)
					{
					    $menu .= '<li class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" style="color:#333333">'.$row->name.'<b class="caret"></b></a>';
						$menu .= '<ul class="dropdown-menu"><li><a href="Birouri-reglabile/colectia-SitStand">-->SitStand</a></li>
						                                    <li><a href="Birouri-reglabile/colectia-Movi">-->Movi</a></li>
						              </ul></li>';
					}
					else $menu .= '<li><a href="'.$row->seo_name.'">'.$row->name.'</a></li>';
					
					
					
					
				}
			}
			$menu .='</ul></li>';
			
					
                   $menu .='<li><a href="Servicii">Servicii</a></li>';
                 $menu .=' <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown">Proiecte <b class="caret"></b></a>';
					$menu .= '<ul class="dropdown-menu">';
						$this->query->execute("SELECT * FROM `projects` ORDER BY `name`;");
			
            $result = $this->query->result;
			$num_rows = $result->num_rows;
			if($num_rows > 0)
			{
				while($row= $result->fetch_object())
				{
					$menu .= '<li><a href="Proiect-'.$row->seo_name.'">'.$row->name.'</a></li>';
				}
			}
			
				  
				 $menu .='</ul></li>'; 
                  $menu .='<li><a href="Despre-noi">Despre noi</a></li>
				  <li><a href="http://e-shop.greenforest.ro">e-Shop</a></li>
                  <li><a href="http://www.greenforest.ro./blog">Blog</a></li>
				  <li><a href="Contact">Contact</a></li>
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
					$children['children_seo_names'][$i] = $row->seo_name;
					$children['children_names'][$i] = $row->name;
					$i++;
				}
			}
			
			return $children;	
			
		}
}

