<?php
// *****************************************'
//  Le CASTEL-BTS SIO/ PROJET PPE4 GSB      '
//  Programme: c_gererFraisForfaitaire.php  '
//  Objet    : Ajout/modif/suppression frais'
//  Client   : laboratoires GSB             '
//  Version  : 2.0                          '
//  Date     : 22/05/2019 à 15H11           '
//  Auteur   : pascal-blain@wanadoo.fr      '
//******************************************'
$idVisiteur = $_SESSION['idVisiteur'];
$leMois = $_SESSION['leMois'];
$action = $_REQUEST['action'];
//----------------------------------------- AJOUT
if ($action=='choix')
	{ 
		include("vues/v_entete.php"); 
		$lesForfaitsPossibles= $pdo->getLesForfaitsPossibles();
		$prixKm=$pdo->getPrixKm($idVisiteur,$leMois);
		include("vues/v_ajoutFraisForfaitaire.php");
	}
if ($action=='valider')
	{// enregistrement de la ligne et retour vers l'etat des frais
		$qte = $_REQUEST['zQte'];
		if ($qte>0)
		{	$forfait = $_REQUEST['zForfait'];
			$montant = str_replace(",",".",$_REQUEST['zPrix']);
			$montant = str_replace(" ","",$montant);
			$pdo->ajoutFraisForfait($idVisiteur, $leMois, $forfait, $qte, $montant); //insertion dans la table;
		}
		$moisASelectionner = $leMois;
		header ('location: index.php?uc=etatFrais&action=voir&lstMois='.$leMois);
	}
//----------------------------------------- MODIFICATION
if ($action=='editer')
	{ 
		include("vues/v_entete.php");
		$forfait = $_REQUEST['forfait'];	
		$unForfait = $pdo->getUnFraisForfait($idVisiteur, $leMois, $forfait);
		include("vues/v_unFraisForfaitaire.php");
	}
if ($action=='validerModifier')
	{// mise à jour de la ligne et retour vers l'etat des frais
		$qte = $_REQUEST['zQte'];
		if ($qte>0)
		{
			$forfait = $_REQUEST['forfait'];
			$pdo->majFraisForfait($idVisiteur, $leMois, $forfait, $qte); //mise à jour de la table;
		}
		$moisASelectionner = $leMois;
		header ('location: index.php?uc=etatFrais&action=voir&lstMois='.$leMois);
	}
//----------------------------------------- SUPPRESSION
if ($action=='supprimer')
	{ 
		include("vues/v_entete.php");
		$forfait = $_REQUEST['forfait'];
		
		$unForfait = $pdo->getUnFraisForfait($idVisiteur, $leMois, $forfait);
	 	include("vues/v_unFraisForfaitaire.php");
	}
	
if ($action=='validerSupprimer')
	{// suppression de la ligne et retour vers l'etat des frais
		$qte = $_REQUEST['zQte'];
		if ($qte>0)
		{
			$forfait = $_REQUEST['forfait'];
			$pdo->supprimerFraisForfait($idVisiteur, $leMois, $forfait); //suppession de la ligne dans la table;
		}
		$moisASelectionner = $leMois;
		header ('location: index.php?uc=etatFrais&action=voir&lstMois='.$leMois);
	}
?>