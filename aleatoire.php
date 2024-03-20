<!DOCTYPE html>
<html lang="fr">
<head>
<title>Site Quiz</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="Quiz.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
<?php
//On démarre une nouvelle session
session_start();

// vérification session active
if(isset($_SESSION['idu']))
{
	$idu = $_SESSION['idu'];

	// paramètres de la BDD
	include("conf_bdd.php");

	try 
	{
		// connexion bdd
		$bdd = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		$i=0;
		// requete sql 
		// chaque champ de données deviendra une cellule du tableau
		foreach($bdd->query('SELECT max(idq) from quiz') as $row) 
		{
		}
		$result = $row[0]; // nb questions dans la table quiz
		$k = 0; // boucle pour nombre aleatoire
		$nb_questions_quiz = $_POST['nbquestions'];  // nb questions pour le quiz
		
		// fonction aleatoire
		$tableau = array();
		while ($k < $nb_questions_quiz)
		{
			$aleat = rand(1, $result);
			foreach($bdd->query('SELECT idq from quiz where idq="'.$aleat.'"') as $row) 
			{}
			if ($row[0]!=NULL)
			{
				if (!in_array($aleat, $tableau)) 
				{
					$tableau[] = $aleat;        
					$k++;
				}
			}
		}
		// récupérer la taille d'un tableau 
		$i = count($tableau);
		$k=0; // créer les questions
		$j=1; // numérotation des questions

		// requete sql 
		foreach($bdd->query('SELECT nom, prenom from utilisateurs where idu="'.$idu.'" ') as $row) 
		{	
		}
		?>
		<header class="bg-body-tertiary" style="height: 75px;">
    <div class="container text-center">
        <div class="row bg-body-tertiary">
          <div class="col">
            <nav class="navbar navbar-expand-lg" style="margin-top: 15px;">
                <div class="container-fluid">
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                      <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.htm">Page D'acceuil</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="Inscription.htm">S'inscrire</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="connexion.htm">Se connecter</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </nav>
          </div>
          <div class="col">
                <a  href="index.htm"><img src="image/Quiz de poulet.png" alt="Logo quiz de poulet" style="max-height: 70px; margin-top: 10px;"></a>
          </div>
          <div class="col">
            <nav class="navbar bg-body-tertiary" style="margin-top: 15px;">
                <div class="container-fluid justify-content-end">
                  <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Rechercher">
                    <button class="btn btn-outline-0 bg-Danger text-white" type="submit">Rechercher</button>
                  </form>
                </div>
              </nav>
          </div>

        </div>
      </div>
</header>
	  <?php
		echo '<br><br><br><br><br><br><br><p></p>';
		
		echo '<form action="trait.php" method="post">';
		// affichage du questionnaire
		While ($k<$i)
		{
			// récupération des questions et affichage
			foreach($bdd->query('SELECT question, A, B, C, D from quiz where idq = "'.$tableau[$k].'" ') as $row) 
			{
				echo '<div class="questions "><p><b> Question '.$j.' - <label for="question">'.$row[0].'</label></b><br/>';
				echo '<input type="radio" id="question" name="q'.$k.'" value="A"> Réponse A : '.$row[1].'<br/>';
				echo '<input type="radio" id="question" name="q'.$k.'" value="B"> Réponse B : '.$row[2].'<br/>';
				echo '<input type="radio" id="question" name="q'.$k.'" value="C"> Réponse C : '.$row[3].'<br/>';
				echo '<input type="radio" id="question" name="q'.$k.'" value="D"> Réponse D : '.$row[4].'<br/></p></div><br>';
			}
			$j++;
			$k++;
		}
		$bdd = null;   // fermeture connexion
		echo '<div class="valider">
		<button type="submit">Valider</button>
	</div>
	</form>';

	$_SESSION['nbq'] = $i;
	$_SESSION['idq'] = $tableau;
	} 
	catch (PDOException $e) 
	{
		//traitement des erreurs
		print "Erreur !: " . $e->getMessage() . "<br/>";
		die();
	}
}
else header('location:connexion.htm'); // retour à la page connexion
?>