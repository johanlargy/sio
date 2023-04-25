<!-- Choix d'un visiteur / Derniere modification le 22/05/2019 à 15H11 par Pascal Blain -->

<?php
	
	if ($_SESSION['statut']!="V")
	{
	echo ' 
 <div id="contenu">
	<form name="choixV" action="index.php?uc=etatFrais&action=voir" method="post">
	<h2>Etat de frais de 
		        
		        <select id="lstVisiteurs" name="lstVisiteurs" onchange="submit();">';
	            if (!isset($_REQUEST['lstVisiteurs']))
	            	{$visiteurChoisi = 'premier';}
	            else
	            	{
	            	$visiteurChoisi=$_REQUEST['lstVisiteurs'];	
	            	}
	            
	            
				 
					
						
						
						
					
						
						
					           
			   echo '    
	        </select>
	        Mois de ';
	  }      
?>