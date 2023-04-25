<!-- Derniere modification le 22/05/2019  15H11 -->
<div id="contenu">
	<h2>AJOUT FRAIS FORFAITAIRE</h2>
	<form name="nouveauFraisForfaitaire" action="index.php?uc=gererFraisForfaitaire&action=valider" method="POST">
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
					<td><input type="hidden" name="zMois" value="<?PHP echo $leMois; ?>">
					<input type="text" name="zQte" onkeyup="calculer()" style="text-align:right;"></td>
					<td><select name="zForfait" onchange="calculer()">
						<?PHP
							foreach ($lesForfaitsPossibles as $unForfait)
							{echo'<option value="'.$unForfait['fId'].'" size="1">'.$unForfait['fLibelle'].'</option>';}
						?>
						</select>
					</td>
					<td><input type="text" name="zPrix" style="text-align:right;" disabled></td>
					<td><input type="text" name="zMontant" style="text-align:right;" disabled></td>
					
				</tr>
			</tbody>
		</table>
		<?php echo 'Puissance du v&eacute;hicule : '.$prixKm['aPuissance'].' - Carburant : '.$prixKm['aMotorisation'].'  (tarif en vigueur depuis le : '.$prixKm['aDate'].')'; ?>
		<p align="right"><input type="image" name="zValider" alt="Valider" src="images/valider.jpg" onclick="valider()"><input type="image" name="zAnnuler" alt="Annuler" src="images/annuler.jpg" onclick="annuler()"></p>
	</form>	
</div>
	
	<script src="include/proceduresJava.js" type="text/javascript"></script>
	<script type="text/javascript">
		function calculer()
		{
		<?php
			$tarif = 'var tarif = ['; 
			foreach ($lesForfaitsPossibles as $unForfait)
			{
				
				
				
				$tarif .= $unForfait['fMontant'].',';
			}
			$tarif .='];';
			echo $tarif."\n"; 
		?>
			var iLeChoix = document.nouveauFraisForfaitaire.zForfait.selectedIndex;		
			var quantite = document.nouveauFraisForfaitaire.zQte.value;
			
			if (!isNaN(quantite))
			{
				document.nouveauFraisForfaitaire.zMontant.value = format_euro(quantite * (parseInt(parseFloat(tarif[iLeChoix])*1000))/1000);
			}
			document.nouveauFraisForfaitaire.zPrix.value = format_euro((parseInt(parseFloat(tarif[iLeChoix])*1000))/1000);
		}
		
		function valider()
		{
			document.nouveauFraisForfaitaire.zPrix.disabled=false;
			document.nouveauFraisForfaitaire.submit();
		}
		
		function annuler()
		{
			document.nouveauFraisForfaitaire.reset();
			document.nouveauFraisForfaitaire.submit();
		}
		
		window.onload = function() { calculer(); };
	</script>