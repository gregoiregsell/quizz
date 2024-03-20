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
    // paramètres de la BDD
    include("conf_bdd.php");

    try 
    {
        // connexion bdd
        $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $user, $pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // on récupère les données
        $i = $_SESSION['nbq'];
        $tabrep = $_SESSION['idq'];

        $k=0; // créer les questions
        $j=1; // numérotation des questions
        $result = 0; // résultat du quiz

        
		echo '<header class="bg-body-tertiary" style="height: 75px;">
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
                            <a class="nav-link active" aria-current="page" href="index.htm">Page Dacceuil</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="Inscription.htm">Sinscrire</a>
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
          
    </header>';
    echo '<br><br><br><br><h1 class="questions"> Résultats du QUIZ </h1><br>';
        While ($k<$i)
        {

            // récupération des réponses aux questions
            $reponse[$k] = $_POST["q$k"];

            // récupération des questions et affichage
            foreach($bdd->query('SELECT idq, question, A, B, C, D, reponse from quiz where idq = "'.$tabrep[$k].'" ') as $row)
            
            {
                echo '<p class="questions"> Question '.$j.' : '.$row[1].'<br/> Votre réponse : '.$reponse[$k].'<br/>';
                if ($row[6]==$reponse[$k])
                {
                    switch($row[6])
                    {
                        case 'A' : echo '<font color=green>Juste -- '.$row[2].'</font><br/>'; break;
                        case 'B' : echo '<font color=green>Juste -- '.$row[3].'</font><br/>'; break;
                        case 'C' : echo '<font color=green>Juste -- '.$row[4].'</font><br/>'; break;
                        case 'D' : echo '<font color=green>Juste -- '.$row[5].'</font><br/>'; break;
                    }
                    $result++;
                }
                else {
                    switch($row[6])
                    {
                        case 'A' : echo '<font color=red>Faux -- La bonne réponse est '.$row[2].'</font><br/>'; break;
                        case 'B' : echo '<font color=red>Faux -- La bonne réponse est '.$row[3].'</font><br/>'; break;
                        case 'C' : echo '<font color=red>Faux -- La bonne réponse est '.$row[4].'</font><br/>'; break;
                        case 'D' : echo '<font color=red>Faux -- La bonne réponse est '.$row[5].'</font><br/>'; break;
                    }
                }
                echo '</p>';
            } 
            $k++;
            $j++;
        }
        $bdd = null; 
        echo '<br><h2 class="questions">Le résultat du quiz est de '.round($result*100/$i,2).' %</h2>'; *
        // ROUND arrondi les calucls 2 chiffres après la virgule
    }
    catch(PDOException $erreur)
        {
        // traitement des erreurs PHP SQL
            echo $erreur.' --  '. $erreur->getMessage();
        }
}
else header('location:connexion.htm'); // retour à la page connexion
?>