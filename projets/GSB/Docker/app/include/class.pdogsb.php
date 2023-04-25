<?php
/** derniere modification le 22/05/2019 à 15H11 par Pascal BLAIN (attention a la casse !)

 * Classe d'acces aux donnees. 
 * Utilise les services de la classe PDO pour l'application GSB
 * Les attributs sont tous statiques, les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

/* test pour le .env
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

// Définir les variables de connexion à partir des variables d'environnement
$serveur = getenv('DB_HOST');
$bdd = getenv('DB_NAME');
$user = getenv('DB_USERNAME');
$mdp = getenv('DB_PASSWORD');

// Établir une connexion à la base de données
try {
    $connexion = new PDO("mysql:host=$serveur;dbname=$bdd", $user, $mdp);
    // Configurer les erreurs PDO pour renvoyer des exceptions
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
*/
class PdoGsb
{   		
      	private static $serveur='mysql:host=db';
      	private static $bdd='dbname=sdis29';   		
      	private static $user='slam' ;    		
      	private static $mdp='slam' ;	
		private static $monPdo;
		private static $monPdoGsb=null;
/**
 * Constructeur prive, cree l'instance de PDO qui sera sollicitee
 * pour toutes les methodes de la classe
 */				
	private function __construct()
	{
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
		
		//PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct()
	{
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui cree l'unique instance de la classe
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb()
	{
		if(PdoGsb::$monPdoGsb==null)
		{
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}

/**
 * Retourne les coordonnées de l'entreprise
 */
	public function getParametres()
	{
		$req = "select pNom, pRue, pCp, pVille, pTel, pAdele, pSiret
				from parametres
				limit 1";
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}

/**
 * Retourne les informations d'un utilisateur
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prenom sous la forme d'un tableau associatif 
*/
	public function getInfosUtilisateur($login,$mdp)
	{
		$req = "select uId as id, uNom as nom, uPrenom as prenom, uStatut as statut
				from utilisateur
				where uLogin='$login' 
				and uMdp='$mdp'";
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$ligne = $rs->fetch();
		return $ligne;
	}

/**
 * Retourne les informations de la table Visiteur
 * @return un tableau associatif 
*/
	public function getLesVisiteurs()
	{
		$req = "select uId as id, uNom as nom, uPrenom as prenom
				from utilisateur
				where uStatut = '1'";
		$rs = PdoGsb::$monPdo->prepare($req);
		$rs->execute();
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes;	 
	}
/**
 * Retourne deux valeurs indiquant si un ajout de frais est possible
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @paral etatRemboursement
*/
	public function getAjoutFraisPossible($idVisiteur, $leMois, $etatRemboursement)
	{
		$possible = array('forfait' => "non", 'horsForfait' => "non", 'modifComptable' => 'non');
		if ($_SESSION['statut']=='V' && $etatRemboursement=='CR') 
		{
			$req = "select	count(*) as nbForfaits
				from	forfait 
				where	fId not in (select lfForfait
									from ligneForfait
									where lfVisiteur='$idVisiteur' 
									and lfMois = '$leMois')";			
			$rs = PdoGsb::$monPdo->query($req);
			if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
			$laLigne = $rs->fetch();
			if ($laLigne['nbForfaits']==0 ? $possible = array('forfait' => "non", 'horsForfait' => "oui", 'modifComptable' => 'non') : $possible = array('forfait' => "oui", 'horsForfait' => "oui", 'modifComptable' => 'non'));
		}
		else 
		{	
			if ($_SESSION['statut']!='V' && $etatRemboursement=='CL') {$possible = array('forfait' => "non", 'horsForfait' => "non", 'modifComptable' => "oui");} 
		}
		return $possible;
	}

/**
 * Retourne les informations pour ajout d'un nouveau frais forfaitaire
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libell, le montant sous la forme d'un tableau associatif 
*/
	public function getLesForfaitsPossibles()
	{
	    $req = "select	fId, fLibelle, fMontant
				from	forfait";
				 
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}
	
/**
 * Retourne le tarif KM pour un motorisation et une puissance donnee a une date 
*/
	public function getPrixKm($idVisiteur,$leMois)
	{
	    $laDate=substr($leMois,0,4).'-'.substr($leMois,4,2).'-01';

	    $req = "SELECT aPuissance, aMotorisation, DATE_FORMAT(aDate,'%d/%m/%Y') as aDate, aMontant
				FROM utilisateur u1 INNER JOIN automobile ON (u1.uMotorisation = automobile.aMotorisation AND u1.uPuissance = automobile.aPuissance)
				where u1.uID='$idVisiteur' and adate=(select max(adate) 
							from  utilisateur u2 INNER JOIN automobile ON (u2.uMotorisation = automobile.aMotorisation AND u2.uPuissance = automobile.aPuissance)
							where u1.uId=u2.uId and adate<='$laDate')";					
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne; 
	}

/** 
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais hors forfait concernees par les deux arguments
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois)
	{
	    $req = "select	lhId, lhVisiteur, lhMois, DATE_FORMAT(lhDate, '%d/%m/%Y') as lhDate, lhLibelle, lhMontant, lhJustificatif, if(substring(lhLibelle,1,6)='REFUSE', True, False) as lhRefus
	    		from	ligneHorsForfait
	    		where	lhVisiteur = '$idVisiteur' 
				and 	lhMois = '$mois' ";			
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}

/**
*/
	public function getLesFraisReportes($idVisiteur,$mois,$justifies)
	{
	    $req = "select	lhId, lhVisiteur, lhMois, DATE_FORMAT(lhDate, '%d/%m/%Y') as lhDate, lhLibelle, lhMontant, lhJustificatif, if(substring(lhLibelle,1,6)='REFUSE', True, False) as lhRefus
	    		from	ligneHorsForfait
	    		where	lhVisiteur = '$idVisiteur' 
				and 	lhMois = '$mois'
				and		substring(lhLibelle,1,6)<>'REFUSE'
				and 	lhId NOT IN (".$justifies.") ";		
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}

/**
 * Retourne le nombre de justificatif d'un Visiteurpour un mois donnee
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le nombre entier de justificatifs 
*/
	public function getNbjustificatifs($idVisiteur, $mois)
	{
		$req = "select	count(*) as nb 
				from 	ligneHorsForfait 
				where	lhVisiteur='$idVisiteur' 
				and 	lhMois = '$mois'
				and		substring(lhLibelle,1,6)<>'REFUSE'";			
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne['nb'];
	}

/**
 * Retourne le montant valide pour un remboursement (cumul des frais forfaitaires et des autres depenses (hors forfaits)
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return le montant 
*/
	public function getMontantValide($idVisiteur, $mois)
	{
		$req = "select	sum(lfQuantite*lfMontant) as montant 
				from 	ligneForfait 
				where	lfVisiteur='$idVisiteur' 
				and 	lfMois = '$mois'";			
		$rs = PdoGsb::$monPdo->query($req);
		$laLigne = $rs->fetch();
		$montantValide=$laLigne['montant'];
		$req = "select	sum(lhMontant) as montant 
				from 	ligneHorsForfait 
				where	lhVisiteur='$idVisiteur' 
				and 	lhMois = '$mois'
				and		substring(lhLibelle,1,6)<>'REFUSE'";			
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		$montantValide=$montantValide+$laLigne['montant'];	
		return $montantValide;
	}

/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait concernees par les deux arguments
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantite sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois)
	{
		$req = "select fId as idfrais, fLibelle, lfQuantite, lfMontant, lfQuantite * lfMontant as totalLigne 
				from ligneForfait inner join forfait 
				on forfait.fId = ligneForfait.lfForfait
				where lfVisiteur='$idVisiteur' 
				and lfMois='$mois' 
				order by lfForfait";	
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$lesLignes = $rs->fetchAll();
		return $lesLignes; 
	}

/**
 * Met a jour la table ligneForfait pour un Visiteur et un mois donne en enregistrant le nouveau montant
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $qte
*/
	public function getUnFraisForfait($idVisiteur, $mois, $forfait)
	{
		$req = "select lfVisiteur, lfMois, lfForfait, lfQuantite, lfMontant, fLibelle
				from ligneForfait inner join forfait on ligneForfait.lfForfait=forfait.fId
				where lfVisiteur= '$idVisiteur' 
				and lfMois = '$mois'
				and lfForfait = '$forfait'";
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne;
	}

/**
 * Met a jour la table ligneForfait pour un Visiteur et un mois donne en enregistrant le nouveau montant
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $qte
*/
	public function majFraisForfait($idVisiteur, $mois, $forfait, $qte)
	{
		$req = "update ligneForfait set lfQuantite = $qte
				where lfVisiteur= '$idVisiteur' 
				and lfMois = '$mois'
				and lfForfait = '$forfait'";
		PdoGsb::$monPdo->exec($req);
	}
	
/**
 * supprime une ligneForfait pour un Visiteur et un mois donne 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $forfait
*/
	public function supprimerFraisForfait($idVisiteur, $mois, $forfait)
	{
		$req = "delete 
				from ligneForfait
				where lfVisiteur= '$idVisiteur' 
				and lfMois = '$mois'
				and lfForfait = '$forfait'";
		PdoGsb::$monPdo->exec($req);
	}
	
/**
 * ajoute une ligne dans la table ligneForfait pour un Visiteur et un mois donne
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $forfait
 * @param $qte
 * @param $montant
 */
	public function ajoutFraisForfait($idVisiteur, $mois, $forfait, $qte, $montant)
	{
			$req = "insert into ligneForfait (lfVisiteur, lfMois, lfForfait, lfQuantite, lfMontant) 
					values ('$idVisiteur', '$mois', '$forfait', '$qte', '$montant')";
			PdoGsb::$monPdo->exec($req);		
	}
	
/**
 * Met a jour la table ligneForfait pour un Visiteur et un mois donne en enregistrant le nouveau montant
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $qte
*/
	public function getUnFraisHorsForfait($idFrais)
	{
		$req = "select lhId, lhVisiteur, lhMois, lhLibelle, DATE_FORMAT(lhDate,'%d/%m/%Y') as lhDate, lhMontant
				from ligneHorsForfait
				where lhId= $idFrais";
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne;
	}

/**
 * Met ajour la table ligneHorsForfait (nouvelles valeurs)
*/
	public function majFraisHorsForfait($idFrais, $date, $libelle, $montant)
	{
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "update ligneHorsForfait set lhDate = '".$dateFr."', lhLibelle='".$libelle."', lhMontant=$montant
				where lhId = $idFrais";
		PdoGsb::$monPdo->exec($req);
	}
	
/**
 * Met a jour la table ligneHorsForfait pour report au mois suivant
*/
	public function transfertFraisHorsForfait($idFrais, $mois)
	{
		$req = "update ligneHorsForfait set lhMois = '$mois'
				where lhId = $idFrais";
		PdoGsb::$monPdo->exec($req);
	}

/**
 * Cree un nouveau frais hors forfait pour un Visiteurun mois donne a partir des parametres
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format franÃ§ais jj//mm/aaaa
 * @param $montant : le montant
*/
	public function ajoutFraisHorsForfait($idVisiteur,$mois,$date,$libelle,$montant)
	{
		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into ligneHorsForfait (lhVisiteur, lhMois, lhLibelle, lhDate, lhMontant) 
				values('$idVisiteur','$mois','$libelle','$dateFr','$montant')";
		PdoGsb::$monPdo->exec($req);
	}
	
/**
 * Supprime le frais hors forfait dont l'id est passe en argument 
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais)
	{	
		$req = "delete 
		from ligneHorsForfait
		where lhId = $idFrais";
		PdoGsb::$monPdo->exec($req);
	}

	public function supprimerFraisHorsForfaitComptable($idFrais, $Libelle)
	{
		$req = "update ligneHorsForfait set lhRefus = 1, lhLibelle = '$Libelle'
		where lhId = $idFrais";
		PdoGsb::$monPdo->exec($req);	
	}

/**
 * Retourne les mois pour lesquel un Visiteura une fiche de frais 
 * @param $idVisiteur 
 * @return un tableau associatif de clefs un mois -aaaamm- et de valeurs l'anne et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur)
	{
        $tabMois = array(	'01' => "Janvier",
					'02' => "F&eacute;vrier",
					'03' => "Mars",
					'04' => "Avril",
					'05' => "Mai",
					'06' => "Juin",
					'07' => "Juillet",
					'08' => "Ao&ucirc;t",
					'09' => "Septembre",
					'10' => "Octobre",
					'11' => "Novembre",
					'12' => "D&eacute;cembre");
		$req = "select	rMois as mois 
				from 	remboursement 
				where	rVisiteur='$idVisiteur' ";
		if ($_SESSION['statut']<>'V') {$req=$req."and	rEtat<>'CR'";} 
		$req=$req." order by rMois desc limit 12";		 		
				
		$rs = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$laLigne = $rs->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =$tabMois[substr( $mois,4,2)];
			$lesMois["$mois"]=array("mois"=>"$mois", "numAnnee"=>"$numAnnee", "numMois"=>"$numMois");
			$laLigne = $rs->fetch(); 		
		}
		return $lesMois;
	}
	
/**
*/
	public function existeRemboursement($idVisiteur,$mois)
	{	
		$req = "select	count(*) as nb
				from	remboursement
				where	rVisiteur='$idVisiteur'
				and		rMois='$mois'";
		$rs = PdoGsb::$monPdo->query($req);
		$laLigne = $rs->fetch();
		return $laLigne['nb'];
	}

/**
*/
	public function getNbRemboursementsAValider()
	{	
		$req = "select	count(*) as nb
				from	remboursement
				where	rEtat='CL'";
		$rs = PdoGsb::$monPdo->query($req);
		$laLigne = $rs->fetch();
		return $laLigne['nb'];
	}

/**
*/
	public function creeNouveauRemboursement($idVisiteur,$mois)
	{	
		$req = "insert into remboursement (rVisiteur,rMois,rNbJustificatifs,rMontantValide,rDateModif,rEtat) 
				values ('$idVisiteur','$mois',0,0,now(),'CR')";
		PdoGsb::$monPdo->exec($req);
	}

/**
 * Retourne les informations d'une fiche de frais d'un Visiteur pour un mois donne
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'etat 
*/	
	public function getInfosRemboursement($idVisiteur,$mois)
	{
		$req = "select	rVisiteur, rMois, rEtat, DATE_FORMAT(rDateModif,'%d/%m/%Y') as dateModif, rNbJustificatifs as nbJustificatifs, rMontantValide as montantValide, eLibelle as libEtat 
				from 	remboursement inner join etat on remboursement.rEtat = etat.eId 
				where	rVisiteur='$idVisiteur' 
				and 	rMois = '$mois'";		
		$rs = PdoGsb::$monPdo->query($req);
		if ($rs === false) {afficherErreurSQL("Probleme lors de la lecture ..", $req, PdoSasti::$monPdo->errorInfo());}
		$laLigne = $rs->fetch();
		return $laLigne;
	}
	
 /**
  * Actualise le montant valide et le nb de justificatifs recus 
 */
	public function valideRemboursement($idVisiteur,$mois)
	{	
		$NbJustificatifs = $this->getNbjustificatifs($idVisiteur,$mois);
		$montantValide = $this->getMontantValide($idVisiteur,$mois);
		$req = "update	remboursement set rEtat = 'VA', rDateModif = now(), rNbJustificatifs=$NbJustificatifs, rMontantValide=$montantValide
				where	rVisiteur='$idVisiteur' 
				and 	rMois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}
	
/**
 * Modifie l'etat et la date de modification d'une fiche de frais
 * Modifie le champ idEtat et met la date de modif a aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
	public function majRemboursement($idVisiteur,$mois,$etat)
	{
		$req = "update	remboursement set rEtat = '$etat', rDateModif = now() 
				where	rVisiteur='$idVisiteur' 
				and 	rMois = '$mois'";
		PdoGsb::$monPdo->exec($req);
	}

/**
 * Clos les fiches de frais
 * Modifie le champ idEtat et met la date de modif a aujourd'hui
*/
	public function clotureMois($mois)
	{
		$req = "update	remboursement set rEtat = 'CL', rDateModif = now() 
				where	rMois <= '$mois'
				and 	rEtat='CR'";
		PdoGsb::$monPdo->exec($req);
	}
}
?>
