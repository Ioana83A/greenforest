<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	header('Content-Type: text/html; charset=utf-8');
	
	class Contact extends PageTemplate
	{
		public function execute()
		{
		    
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Text}'=>$this->getText(),
				'{Contact_form}'=>$this->getContactForm()
			    	
			    );
			
			$this->templateEngine->load($data, 'contact.html');
		}
		
		
		
		
		private function getText()
		{
			
			return '<div class="category_outer"><div class="category_inner"><h1>Contact sc. <span id="company_name">Green Forest</span> srl</h1></div></div><br/><br/><br>
			<div class="clear_box"></div>
			<span class="location">RO. 300133, Timisoara</span>
			<p>Bd. Simion Barnutiu, Nr. 28</p>
			<p>Tel/Fax: 0256 490284</p>
			<p>0256 226621</p>
			<p>email: office@greenforest.ro</p>
	
			
			
			<span class="location">Bucuresti</span>
			<p>Cladirea World Trade Center Bucuresti, intrarea D, et. 1, sp. 1.13</p>
			<p>P-ta Montreal nr. 10</p>
			<p>Sector 1, Bucuresti, ROMANIA</p>
			<p>Tel: 021/230.60.60</p>
			<p>031/805.41.24</p>
			<p>email: bucuresti@greenforest.ro</p>'; 	
		}
		
		private function getContactForm(){
		
			$form='<div id="contact_form" style="width:550px;margin:0 auto;color:#a0a7a9;font-size:10px;">
			      <form id="contact_form" action="contact.php" method="POST">
			       <input type="text" name="nume" value="Nume" style="border:1px solid #dcdbd9;float:left;margin-top:5px;height:25px;" size="35"/>
				   <input type="text" name="prenume" value="Prenume" style="border:1px solid #dcdbd9;float:left;margin-top:5px;height:25px;margin-left:10px;" size="35"/>
				   <input type="text" name="nume_firma" value="Nume firma" style="border:1px solid #dcdbd9;float:left;margin-top:5px;height:25px;" size="35"/>
				   <input type="text" name="profil_activitate" value="Profil activitate" style="border:1px solid #dcdbd9;float:left;margin-top:5px;height:25px;margin-left:10px" size="35"/>
				   <input type="text" name="email" value="Adresa e-mail" style="border:1px solid #dcdbd9;float:left;margin-top:5px;height:25px;" size="35"/>
				   <input type="text" name="Adresa web" value="Nume" style="border:1px solid #dcdbd9;float:left;margin-top:5px;height:25px;margin-left:10px" size="35"/>
				   <textarea name="mesaj" style="border:1px solid #dcdbd9;padding-top:5px">Mesajul tau</textarea></div>
			
			
			';
			return $form;
		}
	}
	
	$contact = new Contact();
	$contact->execute();

?>
