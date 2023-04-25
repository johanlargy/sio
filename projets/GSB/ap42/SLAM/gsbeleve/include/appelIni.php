stocker le nom d'utilisateur et le mot de passe dans la classe n'est pas une très bonne idée pour le code mis en production ... Une bonne solution consiste a stocker les paramètres de connexion à la base de données dans un fichier .ini et à en restreindre l'accès. Par exemple de cette façon:

private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsb2021';   		
      	private static $user='root' ;    		
      	private static $mdp='root' ;
		
gsb.ini:
[database]
driver = mysql
host = localhost
port = 3306
schema = gsb2021
username = root
password = root	

	
Database connection:
<?php
class MyPDO extends PDO
{
    public function __construct($file = 'gsb.ini')
    {
        if (!$settings = parse_ini_file($file, TRUE)) throw new exception('acces impossible ' . $file . '.');
       
        $dns = $settings['database']['driver'] .
        ':host=' . $settings['database']['host'] .
        ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
        ';dbname=' . $settings['database']['schema'];
       
        parent::__construct($dns, $settings['database']['username'], $settings['database']['password']);
    }
}
?>