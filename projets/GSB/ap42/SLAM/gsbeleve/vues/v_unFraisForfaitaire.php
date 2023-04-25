<!-- Derniere modification le 22/05/2019 à 15H11 -->
<div id="contenu">

<?php
 	if ($_REQUEST['action']=="supprimer") 
		{echo '<h2>SUPPRESSION D\'UN FRAIS FORFAITAIRE</h2>';
		echo '<form name="unFraisForfaitaire" action="index.php?uc=gererFraisForfaitaire&action=validerSupprimer&forfait='.$unForfait['lfForfait'].'" method="POST">';} 
	else 
		{echo '<h2>EDITION D\'UN FRAIS FORFAITAIRE</h2>';
		echo '<form name="unFraisForfaitaire" action="index.php?uc=gererFraisForfaitaire&action=validerModifier&forfait='.$unForfait['lfForfait'].'" method="POST">';}
?>	
		<table class="listeLegere">
			<thead>
				<tr>
					<th class="date">Quantit&eacute;</th>
					<th class="eltForfait">Nature de la d&eacute;pense</th>
					<th class="montant">Prix</th>
					<th class="montant">Montant</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="text" name="zQte" onkeyup="calculer()" style="text-align:right;border: 0;" value="<?php echo $unForfait['lfQuantite'].'"';if ($_REQUEST['action']=="supprimer") {echo ' disabled';}?>>
					<input type="hidden" name="zMois" value="<?php echo $leMois; ?>"></td>
					<td><input type="text" name="zForfait" value="<?php echo $unForfait['fLibelle']; ?>" style="text-align:left;border: 0;" disabled></td>
					<td><input type="text" name="zPrix" value="<?php echo number_format($unForfait['lfMontant'],2,',','.'); ?>" style="text-align:right;border: 0;" disabled></td>
					<td><input type="text" name="zMontant"  value="<?php echo number_format($unForfait['lfQuantite']*$unForfait['lfMontant'],2,',','.'); ?>" style="text-align:right;border: 0;" disabled></td>
				</tr>
			</tbody>
		</table>
		<p align="right"><input type="image" id="zValider" alt="Oui" src="images/valider.jpg" onclick="valider()"><input type="image" name="zAnnuler" alt="Non" src="images/annuler.jpg" onclick="annuler()"></p>
				
	</form>

</div>
	
	<script src="include/proceduresJava.js" type="text/javascript"></script>
	
	<script type="text/javascript">
		function calculer()
		{
			if (!isNaN(document.unFraisForfaitaire.zQte.value)) {document.unFraisForfaitaire.zMontant.value=(parseFloat(document.unFraisForfaitaire.zPrix.value)*parseInt(document.unFraisForfaitaire.zQte.value))};
		}
		
		function valider()
		{	
			document.unFraisForfaitaire.zQte.disabled=false;
			document.unFraisForfaitaire.submit();
		}
		
		function annuler()
		{
			document.unFraisForfaitaire.zQte.disabled=false;
			document.unFraisForfaitaire.zQte.value=0;
			document.unFraisForfaitaire.submit();
		}
		
		window.onload = function() { calculer(); };		
		
	</script>