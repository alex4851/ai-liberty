
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
<div class="legal_all">

<section class="legal">

<h1>Politique de confidentialité</h1>
<p><strong>Collecte des données :</strong></p>
<p>Nous collectons des données personnelles telles que le nom, l'adresse email, et l'adresse IP lors de votre visite ou inscription sur notre site.</p>

<p><strong>Utilisation des données :</strong></p>
<p>Vos données sont utilisées pour améliorer nos services, analyser le trafic de notre site et vous contacter si nécessaire.</p>

<p><strong>Protection des données :</strong></p>
<p>Nous mettons en œuvre des mesures de sécurité pour protéger vos données contre tout accès non autorisé.</p>

<p><strong>Durée de conservation :</strong></p>
<p>Vos données personnelles sont conservées aussi longtemps que nécessaire pour atteindre les objectifs pour lesquels elles sont collectées, ou conformément aux exigences légales.</p>

<p><strong>Vos droits :</strong></p>
<p>Vous avez le droit d'accéder, de modifier ou de supprimer vos données personnelles à tout moment en nous contactant à l'adresse suivante : contact@ai-liberty.fr .</p>

</section>
<footer>
    <div>
        <a href="mentions-legales.php">Mentions légales</a>
        <a href="politique-confidentialite.php">Politique de confidentialité</a>
        <a href="cgu.php">CGU</a>
        <a href="politique-cookies.php">Politique des cookies</a>
    </div>
    <div>
        <p style="margin: 0; font-size: 14px; color: #6c757d;">&copy; <?php echo date("Y"); ?> AI-LIBERTY - Tous droits réservés</p>
    </div>
</footer>
</div>
</body>
</html>