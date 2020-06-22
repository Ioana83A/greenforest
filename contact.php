<?php

	error_reporting(E_ALL);

	require_once 'classes/Config.php';
	require_once 'classes/DatabaseConnection.php';
	require_once 'classes/Query.php';
	require_once 'classes/Menu.php';
	require_once 'classes/PageTemplate.php';
	require_once 'classes/TemplateEngine.php';
	//header('Content-Type: text/html; charset=utf-8');
	//header_remove("X-Powered-By");
	
	class Contact extends PageTemplate
	{
		public function execute()
		{
			
			$this->URLCheck();
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Text}'=>$this->getText(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu(),
				'{Contact_form}'=>$this->getContactForm(),
				'{Canonical_URL}'=>$this->getCanonicalURL(),
			    	
			    );
			$this->templateEngine->load($data, 'contact.html');
		}
		
		private function getText()
		{
			
			return '<div style="overflow:hidden"><div class="category_outer" ><div class="category_inner"><h1>Contact <span id="company_name">GreenForest</span></h1></div><div class="clear_box"></div></div><div class="clear_box"></div></div><br/><br/>
			<div id="contact_left" class="col-sm-5 col-xs-12">
			<div class="location" style="margin-top:0 !important;">Timisoara 300133, Romania</div>
			<p>Bd. Simion Barnutiu nr. 28</p>
			<p>Tel/Fax:&nbsp;&nbsp;0040 256 490284</p>
			<p style="padding-left:48px">0040 256 226621</p>
			<p>email: office@greenforest.ro</p>
					
			<div class="location" >Bucuresti 011469, Romania</div>
			<p>Galeria World Trade Center</p>
			<p>Piata Montreal nr. 10</p>
			<p>Tel:	  0040 212 306060</p>
			<p>Fax:	  0040 318 054124</p>
			<p>email: bucuresti@greenforest.ro</p>
						
			<div class="location">Cluj Napoca 400237, Romania</div>
			<p>Str. Septimiu Muresan nr. 5-7</p>
			<p>Tel/Fax:  0040 364 737182</p>
			<p>email: cluj@greenforest.ro</p></div>';
		}
		
		private function getContactForm(){
			$send_status ="";
			$style_send_status="";
			$style_input=array("nume"=>"color:#99a1a3;", "prenume"=>"color:#99a1a3;", "email"=>"color:#99a1a3","nr_tel"=>"color:#99a1a3;","nume_firma"=>"color:#99a1a3;","profil_activitate"=>"color:#99a1a3;",
			                   "mesaj"=>"color:#99a1a3;'");
			$nume="Nume";
			$prenume = "Prenume";
			$email = "Adresa e-mail";
			$nr_tel = "Telefon";
			$nume_firma = "Nume firma";
			$profil = "Profil activitate";
			$mesaj="Mesajul tau";
			if(isset($_POST['nume'])){
			
			    if($_POST['nume']  != 'Nume') $style_input['nume']= "color:#000000";
				if($_POST['prenume']  != 'Prenume') $style_input['prenume']= "color:#000000";
				if($_POST['email']  != 'Adresa e-mail') $style_input['email']= "color:#000000";
				if($_POST['nr_tel']  != 'Telefon') $style_input['nr_tel']= "color:#000000";
				if($_POST['nume_firma']  != 'Nume firma') $style_input['nume_firma']= "color:#000000";
				if($_POST['profil_activitate']  != 'Profil activitate') $style_input['profil_activitate']= "color:#000000";
				if($_POST['mesaj']  != 'Mesajul tau') $style_input['mesaj']= "color:#000000";
					
				$nume= $_POST['nume'];
				$prenume = $_POST['prenume'];
				$email = $_POST['email'];
				$nr_tel = $_POST['nr_tel'];
				$nume_firma = $_POST['nume_firma'];
				$profil= $_POST['profil_activitate'];
				$mesaj = $_POST['mesaj'];
				if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				                           $send_status = "Adresa de e-mail nu e valida!";
										   $style_send_status = 'style="color:#CC0000"';
										  }
			    else if(!$this->validPhone($_POST['nr_tel']))
				{
					 $send_status = "Numarul de telefon nu e valid!";
					 $style_send_status = 'style="color:#CC0000"';
				}
				else if(($_POST['mesaj']=="") ||($_POST['mesaj']=="Mesajul tau")) 
				{
					 $send_status = "Nu ati introdus mesajul!";
					 $style_send_status = 'style="color:#CC0000"';
				}
				else
				{
				
					 $nume=$_POST['nume'];
					 $prenume=$_POST['prenume'];
					 $email=$_POST['email'];
					 $telefon=$_POST['nr_tel'];
					 $nume_firma = $_POST['nume_firma'];
					 $profil_activitate = $_POST['profil_activitate'];
					 $comentarii=$_POST['mesaj'];
					
					$contact="ioana.orhei@gmail.com";
	
					$subject="Contact vizitator";
					$headers  = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$headers .= "From:". $nume." ". $prenume ." <" . $email . ">\r\n";
	
	
					$data   = gmdate("j-m-Y");
	
	
					$str_mail='
						<style type="text/css">
					<!--
					.text2 {
						font-family: Geneva, Arial, Helvetica, sans-serif;
						font-size: 14px;
						font-weight: bolder;
						color: #000000;
						text-decoration: none;
						text-align: justify;
					}
					.text {
						font-family: Verdana, Arial, Helvetica, sans-serif;
						font-size: 12px;
						font-weight: bolder;
						color: #000000;
						text-decoration: none;
					}
					-->
					</style>
					<center>
					<table border="1" width="400" class="text">
					
						
					<tr><td>De la: '.$nume.' '.$prenume.'</td></tr>
					
					
					<tr><td>Adresa e-mail : '.$email.'</td></tr>
					<tr><td>Numar telefon : '.$telefon.'</td></tr>
					<tr><td>Nume firma : '.$nume_firma.'</td></tr>
					<tr><td>Profil activitate : '.$profil_activitate.'</td></tr>
					
					<tr><td>Comentarii(daca exista) : '.$comentarii.'</td></tr>
					
					</table>
					</center>
					';
	
					if (!mail($contact, $subject, $str_mail, $headers))
					{
					
					
						die("E-mailul nu a putut fi trimis");
						exit();
					}
					else
					{
						
						$nume="Nume";
						$prenume = "Prenume";
						$email = "Adresa e-mail";
						$nr_tel = "Telefon";
						$nume_firma = "Nume firma";
						$profil = "Profil activitate";
						$mesaj="Mesajul tau";
						$send_status = "Mesajul a fost trimis!";
						$style_send_status = 'style="color:#007A29"';
						$style_input=array("nume"=>"color:#99a1a3;", "prenume"=>"color:#99a1a3;", "email"=>"color:#99a1a3","nr_tel"=>"color:#99a1a3;","nume_firma"=>"color:#99a1a3;","profil_activitate"=>"color:#99a1a3;",
												   "mesaj"=>"color:#99a1a3;'");
					}
				}
			}
			$form='<div id="contact_right" class="col-sm-7 col-xs-12"><div class="contact_form" style="width:510px;float:right">
			      <form id="contact_form" action="Contact#send" method="post">
			       <input type="text" class="input_text" name="nume" value="'.$nume.'" id="nume" style="border:1px solid #dcdbd9;float:left;margin:5px 0px 0px 0px;height:25px;font-size:10px;padding:0px 0px 0px 5px ;'.$style_input['nume'].'"  />
				   <input type="text" class="input_text" name="prenume" value="'.$prenume.'" id="prenume" style="border:1px solid #dcdbd9;float:left;margin:5px 0px 0px 10px;height:25px;;font-size:10px;padding:0px 0px 0px 5px ;'.$style_input['prenume'].'"  />
				   <input type="text" class="input_text" name="nume_firma" value="'.$nume_firma.'" id="nume_firma" style="border:1px solid #dcdbd9;float:left;margin:5px 0px 0px 0px;height:25px;font-size:10px;padding:0px 0px 0px 5px ;;'.$style_input['nume_firma'].'"  />
				   <input type="text" class="input_text" name="profil_activitate" value="'.$profil.'" id="profil_activitate" style="border:1px solid #dcdbd9;float:left;margin:5px 0px 0px 10px;height:25px;font-size:10px;padding:0px 0px 0px 5px ;'.$style_input['profil_activitate'].'" />
				   <input type="text" class="input_text" name="email" value="'.$email.'" id="email" style="border:1px solid #dcdbd9;float:left;margin:5px 0px 0px 0px;height:25px;font-size:10px;padding:0px 0px 0px 5px ;'.$style_input['email'].'"  />
				   <input type="text" class="input_text" name="nr_tel" value="'.$nr_tel.'" id="nr_tel" style="border:1px solid #dcdbd9;float:left;margin:5px 0px 0px 10px;height:25px;font-size:10px;padding:0px 0px 0px 5px ;'.$style_input['nr_tel'].'"  />
				   <textarea name="mesaj" id="mesaj" style="border:1px solid #dcdbd9;padding-top:5px;font-size:10px;padding-left:5px;margin-top:10px;'.$style_input['mesaj'].'" cols="76" rows="15" >'.$mesaj.'</textarea>
				   <div class="clear_box"></div>
				   <div id="send_btn" style="margin-top:10px;float:right;"><button type="button" class="btn btn-default" id="send">Trimite</button></div>
				   <div class="clear_box"></div>
				   <div id="send_status" class="send_status_outer" '.$style_send_status.'><div class="send_status_inner">'.$send_status.'</div></div>
				   <div class="clear_box"></div>
				   </form>
				   <a name="down"></a> 
				   </div></div>
			
			
			';
			return $form;
		}
		
		private function validPhone ($phone) {
			$phone = trim($phone);
			$reg = "/((\(\+4\)|\+4))?[-\s]?\(?((01|02|03|04|05|06|07)\d{2})?\)?[-\s]?\d{3}[-\s]?\d{3}$/";
			$matches = array();
			$no_of_matches = preg_match_all($reg, $phone, $matches);
			if(!$no_of_matches) return FALSE;
			return TRUE;
        }

		private function getCanonicalURL(){
			return 'http://www.greenforest.ro/Contact';
		}
		private function URLCheck(){
		    header_remove("X-Powered-By");
			if(substr($_SERVER['REQUEST_URI'], -1) == '/')	
			{
			
				$without_slash = substr($_SERVER['REQUEST_URI'], 0, -1);
				header("HTTP/1.1 301 Moved Permanently"); 
				header("Location: http://".$_SERVER['HTTP_HOST'].$without_slash); 
				exit();
			}
		}
	}
	
	$contact = new Contact();
	$contact->execute();
?>
