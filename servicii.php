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
	
	class Servicii extends PageTemplate
	{
		public function execute()
		{
			$this->URLCheck();
			$data = array(
			    '{Header_main_menu}'=>$this->menu->displayHeaderMainMenu(),
				'{Text}'=>$this->getText(),
				'{XS_Menu}'=>$this->menu->getXsScreenMenu()
			    );
			
			$this->templateEngine->load($data, 'servicii.html');
		}
		
	
		
		private function getText()
		{
			    $text = '<div style="about_us_text">
					<h2>Consultanță pentru amenajarea postului de lucru</h2>

<p>Echipele de consilieri și account manageri situați în cele 3 locații GreenForest, respectiv Timișoara, București și Cluj Napoca, oferă consultanță privind amenajarea spațiilor de lucru pentru maximizarea performanțelor clienților.</p>

<h2>Planificarea spațiului și servicii de randare</h2>

<p>Echipa de interior designeri GreenForest contribuie la optimizarea folosirii spațiilor și susțin alegerea soluțiilor ambientale potrivite în raport cu viziunea și valorile beneficiarilor.</p>

<h2>Management de proiect</h2>

<p>GreenForest oferă soluții de management de proiect care includ pe lângă amenajarea cu mobilier a spațiilor, realizarea partiționărilor interioare, pardoselilor, tavanelor și a instalațiilor interioare. Partener principal în realizarea lucrărilor de management proiect este <a href="http://www.rubiz.ro" class="movi-link">RUBIZ Management</a>. </p>

<h2>Instalare mobilier</h2>

<p>Echipele de teren GreenForest, formate din montatori de mobilier calificați, locate în Timișoara, București și Cluj Napoca, livrează și instalează mobilierul în spațiile clienților din orice locație națională sau europeană.</p>

				</div>';
				return $text;
			
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
	
	$servicii = new Servicii();
	$servicii->execute();
?>
