
<!-- affichage du detail de la fiche frais / Derniere modification le 22/05/2019 à 15H11 par Pascal BLAIN -->
	<div class="encadre">
	<!-- ============================================================== frais forfaitaires -->
  	<table class="listeLegere">
  	   <caption><h3>&emsp;&Eacute;l&eacute;ments forfaitis&eacute;s 
  	   <?php 
  	   if ($ajoutFraisPossible['forfait']=="oui") echo '
	   <a href="index.php?uc=gererFraisForfaitaire&action=choix" title="ajout frais forfaitaire">
	   <img alt="Ajouter un frais forfaitaire" src="images/ajouter.jpg" border="0">&nbsp;</a>
	   ';?></h3>
	   </caption>
		<thead>
			<tr>
				<th class="date">Quantit&eacute;</th>
				<th class="eltForfait">Nature de la d&eacute;pense</th>
				<th class="montant">Prix</th>
				<th class="montant">Montant</th>
				<?php
				if ($ajoutFraisPossible['horsForfait']=="oui" or $ajoutFraisPossible['modifComptable']=="oui") {echo '
				<th>&nbsp;</th>
				<th>&nbsp;</th>';} ?>
			</tr>
		</thead>
		<tbody>

	        <?php
	        $totalFraisForfait=0;
			foreach ( $lesFraisForfait as $unFraisForfait ) 
			{	echo '
			 <tr>
				<td align="right">'.$unFraisForfait['lfQuantite'].'</td>
				<td>'.$unFraisForfait['fLibelle'].'</td>
				<td align="right">'.number_format($unFraisForfait['lfMontant'],2,',','.').'</td>
				<td align="right">'.number_format($unFraisForfait['totalLigne'],2,',','.').'</td>';

  	   			if ($ajoutFraisPossible['horsForfait']=="oui" or $ajoutFraisPossible['modifComptable']=="oui") echo '				
	         	<td><a href="index.php?uc=gererFraisForfaitaire&action=editer&forfait='.$unFraisForfait['idfrais'].'"><img alt="modifier" src="images/editer.jpg" border="0"></a></td>
	        	<td><a href="index.php?uc=gererFraisForfaitaire&action=supprimer&forfait='.$unFraisForfait['idfrais'].'"><img alt="supprimer" src="images/supprimer.jpg" border="0"></a></td>';
	        	
	        	echo '
			 </tr>';
			 $totalFraisForfait=$totalFraisForfait + $unFraisForfait['totalLigne'];
	         }
	         echo '
	         <tr>
	         	<td>&nbsp;</td>
	        	<td>&nbsp;</td>
	        	<td align="right"><b>Total</b></td>
	        	<td align="right"><b>'.number_format($totalFraisForfait,2,',','.').'</b></td>';
	        	
	        	if ($ajoutFraisPossible['horsForfait']=="oui" or $ajoutFraisPossible['modifComptable']=="oui") {echo '
				<td>&nbsp;</td>
				<td>&nbsp;</td>
	         </tr>';}
			?>
		</tbody>
	    </table>
	    
	    <!-- ============================================================== rappel des elements du remboursement -->
	    <form name="autresfrais" action="index.php?uc=etatFrais&action=validerEtat" method="post">
	    <div id="menu"> 
	    	<ul>
				<li>Etat : <b><?php echo $libEtat;?> </b></li>
				<li>depuis le :<br /><b><?php echo $dateModif;?></b> </li>
				<li>Justificatifs : <b><?php echo $nbJustificatifs; ?></b></li>
				<li>Montant valid&eacute; : <br /><b><?php echo number_format($montantValide,2,',','.').' &euro;';?></b> </li><br />
				<?php 
				if ($ajoutFraisPossible['modifComptable']=="oui") { echo '
				<li style="list-style-type:none;"><img alt="validation de la demande de remboursement" src="images/validation.jpg" onClick="document.autresfrais.submit();"></li>';} 
				?>
			</ul>
		</div>
		
	    <!-- ============================================================== frais hors forfaits -->
	  	<table class="listeLegere">
	  	   <caption><h3>&emsp;Autres d&eacute;penses (hors forfaits) 
	  	   <?php 
  	   		if ($ajoutFraisPossible['horsForfait']=="oui") echo '
	   		<a href="index.php?uc=gererFraisHorsForfait&action=ajouter" title="ajout frais hors forfait">
	   		<img alt="Ajouter un frais hors forfait" src="images/ajouter.jpg" border="0">&nbsp;</a>
	   		';?></h3>
	       </caption>
			<thead>
	             <tr>
	                <th class="date">Date</th>
	                <th class="libelle">Nature de la d&eacute;pense</th>
	                <th class="montant">Montant</th>
	                <?php
					if ($ajoutFraisPossible['horsForfait']=="oui" or $ajoutFraisPossible['modifComptable']=="oui") {echo '
					<th>&nbsp;</th>
					<th>&nbsp;</th>';}
					if ($ajoutFraisPossible['modifComptable']=="oui") {echo '
					<th><img name="zTous" alt="valider tous les justificatifs" src="images/cocheB.gif" width="20px" onClick="tousLesJustificatifs(document.autresfrais);" onMouseOver="src=\'images/cocheR.gif\'"  onMouseOut="src=\'images/cocheB.gif\'">
					<input type="hidden" name="zSens" value="on"></th>';} 
					?>
	             </tr> 
	        </thead>
	        <tbody> 
	        <?php 
	        	$totalFraisHorsForfait=0;
		        foreach ( $lesFraisHorsForfait as $unFraisHorsForfait ) 
				{if (substr($unFraisHorsForfait['lhLibelle'],0,6)<>'REFUSE') {$td='<td style="text-decoration:none;"';} else {$td='<td style="text-decoration:line-through; color:red;"';} 
				echo '<tr>'.
		            $td.'>'.$unFraisHorsForfait['lhDate'].'</td>'.
		            $td.'>'.$unFraisHorsForfait['lhLibelle'].'</td>'.
		            $td.' align="right">'.number_format($unFraisHorsForfait['lhMontant'],2,',','.').'</td>';
		            
	  	   			if ($ajoutFraisPossible['horsForfait']=="oui" or $ajoutFraisPossible['modifComptable']=="oui") 
	  	   			{echo '				
		         	<td><a href="index.php?uc=gererFraisHorsForfait&action=editer&idFrais='.$unFraisHorsForfait['lhId'].'"><img alt="modifier" src="images/editer.jpg" border="0"></a></td>
		        	<td><a href="index.php?uc=gererFraisHorsForfait&action=supprimer&idFrais='.$unFraisHorsForfait['lhId'].'"><img alt="supprimer" src="images/supprimer.jpg" border="0"></a></td>';
		        	}
					if ($ajoutFraisPossible['modifComptable']=="oui") 
					{if (substr($unFraisHorsForfait['lhLibelle'],0,6)<>'REFUSE') 
						{echo '<td><input type="checkbox" name="justificatifs[]" value="'.$unFraisHorsForfait['lhId'].'" checked onClick=""></td>';}
					else
						{echo '<td>&nbsp;</td>';}						
		        	}
					if($unFraisHorsForfait['lhRefus'] == 0)
					{
						$totalFraisHorsForfait=$totalFraisHorsForfait + $unFraisHorsForfait['lhMontant'];
					}
					echo '
	         	</tr>';
		       }
	         echo '
	         <tr>
	         	<td>&nbsp;</td>
	        	<td align="right"><b>Total</b></td>
	        	<td align="right"><b>'.number_format($totalFraisHorsForfait,2,',','.').'</b></td>';
			 	if ($ajoutFraisPossible['horsForfait']=="oui" or $ajoutFraisPossible['modifComptable']=="oui") {echo '
			 	<td>&nbsp;</td>
				<td>&nbsp;</td>';} 
				if ($ajoutFraisPossible['modifComptable']=="oui") {echo '
				<td>&nbsp;</td>';} echo '
	         </tr>
			</tbody>
	    </table>
	</div>    
	<h3 align="center"><b>Total de la demande de remboursement de frais : '.number_format($totalFraisForfait + $totalFraisHorsForfait,2,',','.').' &euro;</b></h3>
    </form>

  </div>'; ?>