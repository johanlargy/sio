<!-- choix d'un mois / Derniere modification le 22/05/2019 à 15H11 par Pascal Blain -->
	<script src="include/proceduresJava.js" type="text/javascript"></script>
<?php
	if ($_SESSION['statut']=="V") {
	$nbM=count($lesMois);
	echo '
 <div id="contenu">
	<form name="choixM" action="index.php?uc=etatFrais&action=voir" method="post">
	<h2>Etat de frais de ';} ?>
 
	        <select id="lstMois" name="lstMois" onchange="submit();">
	            <?php 
	            if (!isset($_REQUEST['lstMois']))
	            	{$moisChoisi = 'premier';}
	            else
	            	{$moisChoisi=$_REQUEST['lstMois'];
	            	}	
	            $i=1; 
	            foreach ($lesMois as $unMois)
				{	
					if($unMois['mois'] == $moisChoisi or $moisChoisi == 'premier')
						{echo "<option selected value=\"".$unMois['mois']."\">".$unMois['numMois']." ".$unMois['numAnnee']."</option>\n	";
						$moisChoisi = $unMois['mois'];
						$noM=$i;}
					else
						{echo "<option value=\"".$unMois['mois']."\">".$unMois['numMois']." ".$unMois['numAnnee']."</option>\n		";
						$i=$i+1;}
				}	           
			    echo '   
	        </select></h2>';
	        ?>
	        <!-- ============================================================== navigation dans les listes visiteurs et mois -->
	        <div id="navigation">
		        <input type="image" id="zPremier" alt="premier" src="images/goPremier.gif" onclick="premier(<?php echo "'".$_SESSION['statut']."'"; ?>)">    
		        <input type="image" id="zPrecedent" alt="pr&eacute;c&eacute;dent" src="images/goPrecedent.gif" onclick="precedent(<?php echo "'".$_SESSION['statut']."'"; ?>)"> 
		        <?php
		        echo '
			        <input type="text" id="zNumero" alt="indice" value="'.$noM.'/'.$nbM.'" disabled="true" size="5" style="text-align:center;vertical-align:top;">';
		        	
		        
			        
			        
			        
			    ?>
		        <input type="image" id="zSuivant" alt="premier" src="images/goSuivant.gif" onclick="suivant(<?php echo "'".$_SESSION['statut']."'"; ?>)">    
		        <input type="image" id="zDernier" alt="premier" src="images/goDernier.gif" onclick="dernier(<?php echo "'".$_SESSION['statut']."'"; ?>)">    
		    </div>
	</form>
<!-- fin liste de choix -->