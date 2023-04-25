<!-- Choix d'un visiteur / Derniere modification le 22/05/2019 à 15H11 par Pascal Blain -->

<?php
	
	if ($_SESSION['statut']!="V")
	{
	$nbV=count($lesVisiteurs);
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
				$i=1; 
				foreach ($lesVisiteurs as $unVisiteur)
					{	
						if($unVisiteur['id'] == $visiteurChoisi or $visiteurChoisi == 'premier')
							{echo "<option selected value=\"".$unVisiteur['id']."\">".$unVisiteur['nom']." ".$unVisiteur['prenom']."</option>\n	";
							$visiteurChoisi = $unVisiteur['id'];
							$noV=$i;}
						else
							{echo "<option value=\"".$unVisiteur['id']."\">".$unVisiteur['nom']." ".$unVisiteur['prenom']."</option>\n		";
							$i=$i+1;}
					}
	            
	            
				 
					
						
						
						
					
						
						
					           
			   echo '    
	        </select>
	        Mois de ';
	  }      
?>