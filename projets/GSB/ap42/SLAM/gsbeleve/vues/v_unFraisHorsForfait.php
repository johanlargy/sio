<!-- Derniere modification le 22/05/2019 à 15H11 -->
<div id="contenu">

<?php
 	if ($_REQUEST['action']=="supprimer") 
		{echo '<h2>SUPPRESSION D\'UN FRAIS HORS FORFAIT</h2>';
		echo '
	<form name="unFraisHorsForfait" action="index.php?uc=gererFraisHorsForfait&action=validerSupprimer&idFrais='.$unFrais['lhId'].'" method="POST">';} 
	else 
		{echo '<h2>EDITION D\'UN FRAIS HORS FORFAIT</h2>';
		echo '
	<form name="unFraisHorsForfait" action="index.php?uc=gererFraisHorsForfait&action=validerModifier&idFrais='.$unFrais['lhId'].'" method="POST">';}
?>	
		<table class="listeLegere">
			<thead>
				<tr>
					<th class="date">Date</th>
					<th class="eltForfait">Nature de la d&eacute;pense</th>
					<th class="montant">Montant</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><input type="text" name="zDate" style="text-align:center;border: 0;" value="<?php echo $unFrais['lhDate'].'"';if ($_REQUEST['action']=="supprimer") {echo ' disabled';}?>>
					<input type="hidden" name="leMois" value="<?php echo $unFrais['lhMois']; ?>"></td>
					<td><input type="text" name="zLibelle"  style="text-align:left;border: 0;" size='80' maxlength='80' value="<?php echo $unFrais['lhLibelle'].'"';if ($_REQUEST['action']=="supprimer") {echo ' disabled';}?>></td>
					<td><input type="text" name="zMontant" style="text-align:right;border: 0;"  value="<?php echo number_format($unFrais['lhMontant'],2,',','.').'"';if ($_REQUEST['action']=="supprimer") {echo ' disabled';}?>></td>
				</tr>
			</tbody>
		</table>
		<p align="right">
<?php  	if ($_REQUEST['action']=="supprimer" and $_SESSION['statut']!="V")  {echo '
 			Si vous confirmez votre choix, la d&eacute;pense invalid&eacute;e sera marqu&eacute;e "REFUSEE")';} ?>
			<input type="image" id="zValider" alt="Oui" src="images/valider.jpg" onclick="valider()">
			<input type="image" name="zAnnuler" alt="Non" src="images/annuler.jpg" onclick="annuler()">
		</p>
				
	</form>

</div>
	
<script type="text/javascript">
		function valider()
			{
			document.unFraisHorsForfait.zMontant.disabled=false;
			document.unFraisHorsForfait.zLibelle.disabled=false;
			document.unFraisHorsForfait.submit();
			}
		
		function annuler()
			{
			document.unFraisHorsForfait.zMontant.disabled=false;
			document.unFraisHorsForfait.zMontant.value=0;
			document.unFraisHorsForfait.submit();
			}
		
</script>
<!-- fin -->