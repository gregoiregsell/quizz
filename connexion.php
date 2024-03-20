<?php
// paramètres de la BDD
include("conf_bdd.php");

// récupération des données
$mail = $_POST['email'];
$mdp = $_POST['mdp'];

// cryptage du mot de passe
$mdpc = hash('sha512', $mdp);

// gestion des exceptions
try 
{
	// connexion bdd
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	// requete sql 
	foreach($bdd->query('SELECT idu from utilisateurs where email="'.$mail.'" and mdp="'.$mdpc.'"') as $row) 
	{	
		
	}
	$bdd = null;   // fermeture connexion

	if (isset($row[0])){
		//On démarre une nouvelle session
 		session_start();
		$_SESSION['idu'] = $row[0];
		header('location:quiz.php');	// si requête SQL OK donc connexion
	}
	else header('location:connexion.htm'); // retour à la page connexion
} 
catch (PDOException $e) 
{
	//traitement des erreurs
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
?>