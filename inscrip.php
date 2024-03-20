<?php
// paramètres de la BDD
include("conf_bdd.php");

// récupération des données
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mail=$_POST['email'];
$mdp=$_POST['mdp'];
// cryptage du mot de passe
$mdpc = hash('sha512', $mdp);

// Insertion de ddonnées dans une table de BDD
try {
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname",
	$user, $pass);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, 
	PDO::ERRMODE_EXCEPTION);
	
	// requete sql préparée - évite les injections sql
	$prepare = $bdd->prepare("INSERT INTO utilisateurs (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)");
    $prepare->bindParam(':nom', $nom);
    $prepare->bindParam(':prenom', $prenom);
    $prepare->bindParam(':email', $mail);
    $prepare->bindParam(':mdp', $mdpc);
	$prepare->execute();
    // supprime l'objet BDD donc évite un trou de sécurité
    $bdd = null; 
	// redirection sur la page ajout.html pour refaire un autre ajout
    header('location:index.htm');
    }
catch(PDOException $erreur)
    {
	// traitement des erreurs PHP SQL
		echo $erreur.' --  '. $erreur->getMessage();
    }
?>