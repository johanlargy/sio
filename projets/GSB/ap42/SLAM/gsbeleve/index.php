<?php
session_start();
// ***************************************'
//  Le CASTEL-BTS SIO/ PROJET PPE4 GSB    '
//  Programme: index.php                  '
//  Objet    : Gestion des frais          '
//  Client   : laboratoires GSB           '
//  Version  : 2.0                        '
//  Date     : 22/05/2019  15H11          '
//  Auteur v1: pascal-blain@wanadoo.fr    '
//****************************************'

require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.php");

$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();

// on vrifie que l'utilisateur est authentifi
if(!isset($_REQUEST['uc']) || !$estConnecte){
     $_REQUEST['uc'] = 'connexion';
}
// on analyse le cas d'utilisation en cours ...
$uc = $_REQUEST['uc'];
switch($uc){
	case 'connexion':{ 
		include("controleurs/c_connexion.php");break;
		}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; 
		}
	case 'gererFraisForfaitaire' :{
		include("controleurs/c_gererFraisForfaitaire.php");break; 
		}
	case 'gererFraisHorsForfait' :{
		include("controleurs/c_gererFraisHorsForfait.php");break; 
		}
}
include("vues/v_pied.php") ;
?>