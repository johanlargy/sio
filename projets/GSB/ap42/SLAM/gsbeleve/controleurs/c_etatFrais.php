<?php
// ***************************************'
//  Le CASTEL-BTS SIO/ PROJET PPE4 GSB    '
//  Programme: c_etatFrais.php            '
//  Objet    : consultations des frais    '
//  Client   : laboratoires GSB           '
//  Version  : 2.0                        '
//  Date     : 22/05/2019 à 15H11        '
//  Auteur   : pascal-blain@wanadoo.fr    '
//****************************************'

$action = $_REQUEST['action'];
switch($action) {
case 'voir':
	{
		$nbRemboursementsAValider=$pdo->getNbRemboursementsAValider();
		include("vues/v_entete.php");
		
		if ($_SESSION['statut']!='V')
			{
			$lesVisiteurs=$pdo->getLesVisiteurs();
			include("vues/v_choixVisiteur.php");
			if ($_SESSION['idVisiteur']!=$visiteurChoisi) {unset($_REQUEST['lstMois']);$_SESSION['idVisiteur']=$visiteurChoisi;}
			} 
		$idVisiteur = $_SESSION['idVisiteur'];
		$lesMois=$pdo->getLesMoisDisponibles($idVisiteur);
		include("vues/v_choixMois.php");
		$_SESSION['leMois']= $moisChoisi;
		
		$leMois=$_SESSION['leMois'];
		$lesInfosRemboursement = $pdo->getInfosRemboursement($idVisiteur,$leMois);
		$libEtat = $lesInfosRemboursement['libEtat'];
		$montantValide = $lesInfosRemboursement['montantValide'];
		$nbJustificatifs = $lesInfosRemboursement['nbJustificatifs'];
		$dateModif =  $lesInfosRemboursement['dateModif'];
		$etatRemboursement = $lesInfosRemboursement['rEtat'];
		
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$leMois);
		$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
		
		$ajoutFraisPossible = $pdo->getAjoutFraisPossible($idVisiteur, $leMois, $etatRemboursement);
		include("vues/v_etatFrais.php");
		break;
	}
case 'validerEtat':
	{
	
		$idVisiteur = $_SESSION['idVisiteur'];
		$leMois=$_SESSION['leMois'];
		if (count($_REQUEST['justificatifs'])==0) {$justifies='null';} else {$justifies=implode(',',$_REQUEST['justificatifs']);}
		$lesReports=$pdo->getLesFraisReportes($idVisiteur,$leMois,$justifies);
		if (count($lesReports)>0)
		{		  
			$leMoisSuivant=intval(substr($leMois,4,2))+1;
			if ($leMoisSuivant>12) {$leMoisSuivant = (intval(substr($leMois,0,4))+1)*100+1;} else {$leMoisSuivant = intval(substr($leMois,0,4)) * 100 + intval(substr($leMois,4,2))+1;}
			$leRemboursement=$pdo->existeRemboursement($idVisiteur,$leMoisSuivant);
			/* si le remboursement pour le mois suivant n'existe pas (=0) il faut le créer */
			if ($leRemboursement==0)
			{
				$pdo->creeNouveauRemboursement($idVisiteur,$leMoisSuivant);
			}
			/* puis associer la (ou les) depense(s) reportee(s) au mois suivant*/
			foreach ($lesReports as $unReport)
			{
				$pdo->transfertFraisHorsForfait($unReport['lhId'], $leMoisSuivant);
			}		
		}
		/* il faut actualiser le code etat, la date, le nombre de justificatifs et le montant valide */
		$pdo->valideRemboursement($idVisiteur,$leMois);
		$moisASelectionner = $leMois;
		header ('location: index.php?uc=etatFrais&action=voir&lstMois='.$leMois);
		break;
	}
default :
	{
		echo 'erreur d\'aiguillage !'.$action;
		break;

	}
}	
?>