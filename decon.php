<?php
    //On démarre une nouvelle session
    session_start();
    // suppression des données de variables de session
    unset($_SESSION['idu']);
    unset($_SESSION['nbq']);
    unset($_SESSION['idq']);
    // destruction de la session
    session_destroy();  
    // retour à la page index
    header('location:index.htm'); 
?>