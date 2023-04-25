<?php
// ***************************************'
//  Le CASTEL-BTS SIO/ PROJET PPE4 GSB    '
//  Programme: c_connexion.php  v2.0      '
//  Objet    : gestion remboursements frais'
//  Client   : laboratoires GSB           '
//  Date     : 22/05/2019 à 15H11         '
//  Auteur   : pascal-blain@wanadoo.fr    '
//****************************************'
if(!isset($_REQUEST['action'])){$_REQUEST['action'] = 'demandeConnexion';}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
	session_unset();
	$param = $pdo->getParametres();
	$_SESSION['adr1']= $param['pRue'];
	$_SESSION['adr2']= $param['pCp'].' '.$param['pVille'];
	include("vues/v_entete.php");
	include("vues/v_connexion.php");
	break;
	}
	case 'valideConnexion':{
		$login = $_REQUEST['login'];
		$mdp = $_REQUEST['mdp'];
		$utilisateur = $pdo->getInfosUtilisateur($login,$mdp);
		if(!is_array( $utilisateur)){
			include("vues/v_entete.php");
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");}
		else{
			$id = $utilisateur['id'];
			$nom =  $utilisateur['nom'];
			$prenom = $utilisateur['prenom'];
			$statut= $utilisateur['statut'];
			connecter($id,$nom,$prenom, $statut);
			if (date('m')-1>0) {$leMoisPrecedent = date('Y')*100 + date('m')-1;} else {$leMoisPrecedent = (date('Y')-1)*100 + 12;}
			$pdo->clotureMois($leMoisPrecedent);
			if ($statut=='V')		/* si le remboursement pour le mois courant n'existe pas (=0) il faut le créer*/
			{
				$leMois=date('Ym');
				$leRemboursement=$pdo->existeRemboursement($id,$leMois);
				if ($leRemboursement==0)	{$pdo->creeNouveauRemboursement($id,$leMois);} 
			}
			header ('location: index.php?uc=etatFrais&action=voir');}
		break;}
	default :{
		include("vues/v_entete.php");
		include("vues/v_connexion.php");
		break;}
}
?>