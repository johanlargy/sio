<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>Intranet du Laboratoire Galaxy-Swiss Bourdin</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="./styles/stylesGSB.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="image/x-icon" href="./images/favicon.ico" />
  </head>
  <body>
    <div id="page">
		<div id="entete">
	        <img src="./images/logo.jpg" id="logoGSB" alt="Laboratoire Galaxy-Swiss Bourdin" title="Laboratoire Galaxy-Swiss Bourdin" />
	<?php if (isset($_SESSION['idUtilisateur'])) 
		{echo '
		<!-- affichage du menu / Derniere  modification le 28 Avril 2013  par P. Blain -->
			<div id="sommaire">
				<ul>
					<li><a href="" title="">&nbsp;</a></li>
					<li><a href="" title="">&nbsp;</a>|</li>
					<li><b>Bienvenue '.$_SESSION['prenom'].'  '.strtoupper($_SESSION['nom']).'</b> ('.$_SESSION['typeUtilisateur'].')';
					if ($_SESSION['statut']<>'V') {echo '<br /><i>Il y a '.$nbRemboursementsAValider.' demandes &agrave; valider</i>';}
					echo ' </li>
					<li><a href="index.php?uc=connexion&action=demandeConnexion" title="Se d&eacute;connecter"><img alt="déconnexion" src="images/deconnexion.png" border="0" height="26px"></a></li>
				</ul>      
			</div>';} ?>
	        <br /><br /><h1>&Eacute;TAT DES FRAIS ENGAG&Eacute;S</h1>
	        <p style="text-align=left;"><?php echo $_SESSION['adr1'].'<br />'.$_SESSION['adr2'].'</p>';?>
		</div>
<!-- fin affichage du menu -->