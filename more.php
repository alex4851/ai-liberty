<?php
include("bdd.php");
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="website icon" type="png" href="img/logo_head.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA TOOLS</title>
</head>

<body <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?> >

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
            <div class="ligne"  id="active"><a href="more.php"><img src="img/news.png"><li>Nouveautés</li></a></div>
            <?php 
            if(isset($_SESSION['ia_admin'])){
                if($_SESSION["ia_admin"] === "true"){
                echo '<div class="ligne"><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
                }
            }
            ?>
            <div class="ligne"><a href="questionnaire.php"><img src="img/quiz.png"><li>Questionnaire</li></a></div>
            <?php
                if(isset($_SESSION['nom']))
                { ?>   
                       
                        <div class="ligne"><a href="user.php"><img src="img/account.png"><li>Mon compte</li></a></div>   
                        <div class="ligne"><a href="logout.php"><img src="img/logout.png"><li>Se déconnecter</li></a></div>
                    
                <?php  }
                else{
                    echo '<div class="ligne"><a href="connexion.php"><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo "<div class='ligne' id='ligne_inscription'><a href='inscription.php'><img src='img/login.png'><li id='inscription'>S'inscrire</li></a></div>";
                }
            ?>      
        </ul>
        <script src="navigation.js"></script>       
    </nav>
</header>

<section class="reste-more">

<div class="feature-card">
    <div class="card-header">
      <h2>Derniers ajouts :</h2>
    </div>
    <div class="card-body">
      <p class="feature-description">
        Nous avons ajouté une section pour pouvoir nous faire des retours !
      </p>
      <ul class="feature-list">
        <li>✔️ Fonctionnalitées 1 : Système de tickets</li>
        <li>✔️ Fonctionnalitées 2 : Modification des infos de votre compte dans "Mon compte"</li>
        <li>✔️ Fonctionnalitées 3 : Personnaliser vos recherche avec plus de critères</li>
      </ul>
      <a href="tickets.php" class="learn-more-btn">Accéder aux tickets</a>
    </div>
</div>

<div class="feature-card">
    <div class="card-header">
      <h2>Arrive bientôt :</h2>
    </div>
    <div class="card-body">
      <p class="feature-description">
        Nous sommes en train de développer quelques nouvelles fonctionnalitées pour améliorer l'experience !
      </p>
      <ul class="feature-list">
        <li>⏳ Fonctionnalitées 1 : Messagerie privée</li>
        <li>⏳ Fonctionnalitées 2 : Espace de discussion en groupe</li>
        <li>⏳ Fonctionnalitées 3 : Ajout de nouvelles IA</li>
      </ul>
      <a href="sharing_space.php" class="learn-more-btn">Espace de partage</a>
    </div>
</div>



</section>


</body>
</html>
