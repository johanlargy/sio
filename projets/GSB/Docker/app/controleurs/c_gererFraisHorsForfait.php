<?php
// *****************************************'
//  Le CASTEL-BTS SIO/ PROJET PPE4 GSB      '
//  Programme: c_gererFraisHorsForfait.php  '
//  Objet    : Ajout/modif/suppression frais'
//  Client   : laboratoires GSB             '
//  Version  : 2.0                          '
//  Date     : 22/05/2019 � 15H11           '  
//  Auteur v1: pascal-blain@wanadoo.fr      '
//******************************************'
$idVisiteur = $_SESSION['idVisiteur'];
$leMois = $_SESSION['leMois'];
$action = $_REQUEST['action'];
//----------------------------------------- AJOUT
if ($action=='ajouter')
	{ 
		include("vues/v_entete.php");
		include("vues/v_ajoutFraisHorsForfait.php");
	}
if ($action=='valider')
	{// enregistrement de la ligne et retour vers l'etat des frais
		$date = $_REQUEST['zDate'];
		if ($date>0)
		{	$libelle=addslashes($_REQUEST['zLibelle']);
			$montant = str_replace(",",".",$_REQUEST['zMontant']);
			$montant = str_replace(" ","",$montant);
			$pdo->ajoutFraisHorsForfait($idVisiteur, $leMois, $date, $libelle, $montant); //insertion dans la table;
		}
		$moisASelectionner = $leMois;
		header ('location: index.php?uc=etatFrais&action=voir&lstMois='.$leMois);
	}
//----------------------------------------- MODIFICATION
if ($action=='editer')
	{ 
		$nbRemboursementsAValider = $pdo->getNbRemboursementsAValider();
		include("vues/v_entete.php");
		$idFrais = $_REQUEST['idFrais'];	
		$unFrais = $pdo->getUnFraisHorsForfait($idFrais);
		include("vues/v_unFraisHorsForfait.php");
	}
if ($action=='validerModifier')
	{// mise � jour de la ligne et retour vers l'etat des frais
		$montant = $_REQUEST['zMontant'];
		if ($montant>0)
		{
			$idFrais = $_REQUEST['idFrais'];
			$date = $_REQUEST['zDate'];
			$libelle=addslashes($_REQUEST['zLibelle']);
			$montant = str_replace(",",".",$_REQUEST['zMontant']);
			$montant = str_replace(" ","",$montant);
			$pdo->majFraisHorsForfait($idFrais, $date, $libelle, $montant); //mise � jour de la table;
		}
		$moisASelectionner = $leMois;
		header ('location: index.php?uc=etatFrais&action=voir&lstMois='.$leMois.'&lstVisiteurs='.$idVisiteur);
	}
//----------------------------------------- SUPPRESSION
if ($action=='supprimer')
	{ 
		$nbRemboursementsAValider = $pdo->getNbRemboursementsAValider();
		include("vues/v_entete.php");
		$idFrais = $_REQUEST['idFrais'];
	
		$unFrais = $pdo->getUnFraisHorsForfait($idFrais);	
		//var_dump($unFrais);
	 	include("vues/v_unFraisHorsForfait.php");
	}
if ($action=='validerSupprimer')
	{
		$montant = $_REQUEST['zMontant'];
		if ($montant>0)
		{
			if($_SESSION['statut'] = 'C')
			{
				$idFrais = $_REQUEST['idFrais'];
				$Libelle = "REFUSEE ";
				$Libelle .= $_REQUEST['LibelleHorsForfait'];
				$pdo->supprimerFraisHorsForfaitComptable($idFrais, $Libelle);
			}
			else
			{
				$idFrais = $_REQUEST['idFrais'];
				$pdo->supprimerFraisHorsForfait($idFrais); //suppession de la ligne dans la table;
			}
		}
		$moisASelectionner = $leMois;
		header ('location: index.php?uc=etatFrais&action=voir&lstMois='.$leMois.'&lstVisiteurs='.$idVisiteur);
	}
?>