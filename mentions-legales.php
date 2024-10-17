
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez les outils IA de pointe qui vous correspondent. En seulement 5 minutes. Accéder gratuitement.">
    <link rel="website icon" type="png" href="img/logo_head.png">
    <title>AI LIBERTY</title>
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

<h1>Mentions légales</h1>
<p><strong>Éditeur du site :</strong></p>
<p>AI LIBERTY<br>

Adresse du siège social : France<br>
Email : contact@ai-liberty.fr<br>
</p>

<p><strong>Directeur de la publication :</strong></p>
<p>Neil Yamine</p>

<p><strong>Directeur du développement :</strong></p>
<p>Alexis BELIGNE</p>

<p><strong>Hébergement du site :</strong></p>
<p>Hostinger International Ltd.<br>
Adresse : 61 Lordou Vironos Street, 6023 Larnaca, Chypre<br>
Téléphone : +357 240 30107</p>

<p><strong>Propriété intellectuelle :</strong></p>
<p>Tout le contenu du site est protégé par les droits d'auteur. La reproduction, distribution ou utilisation de ce contenu est interdite sans autorisation préalable.</p>


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
