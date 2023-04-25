<!-- ajout d'un frais hors forfaits / Dernière modification le 22/05/2019 à 15H11 par P. Blain -->
<div id="contenu">
	<h2>AJOUT D'UN FRAIS HORS FORFAIT</h2>
	<form name="unFraisHorsForfait" action="index.php?uc=gererFraisHorsForfait&action=valider" method="POST">
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
					<td><input type="hidden" name="zMois" value="<?PHP echo $leMois; ?>">
					<input type="text" name="zDate" style="text-align:center;border:0;"></td>
					<td><input type="text" name="zLibelle" style="text-align:left;border:0;" size='80' maxlength='80' ></td>
					<td><input type="text" name="zMontant" style="text-align:right;border:0;"></td>	
				</tr>
			</tbody>
		</table>
		<p align="right"><input type="image" name="zValider" alt="Valider" src="images/valider.jpg" onclick="valider()"><input type="image" name="zAnnuler" alt="Annuler" src="images/annuler.jpg" onclick="annuler()"></p>
	</form>	
</div>

<script type="text/javascript">
		function valider()
			{
			document.unFraisHorsForfait.submit();
			}
		
		function annuler()
			{
			document.unFraisHorsForfait.reset();
			document.unFraisHorsForfait.submit();
			}
		
</script>
<!-- fin -->