
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

<h1>Conditions Générales d'Utilisation (CGU)</h1>
<p><strong>Objet :</strong></p>
<p>Les présentes CGU ont pour objet de définir les conditions d'utilisation du site web et des services associés.</p>

<p><strong>Accès au site :</strong></p>
<p>Le site est accessible gratuitement à tout utilisateur disposant d’un accès à Internet. Certains services peuvent être réservés aux utilisateurs inscrits.</p>

<p><strong>Comportement des utilisateurs :</strong></p>
<p>Les utilisateurs s'engagent à utiliser le site de manière légale et à ne pas publier de contenu offensant, diffamatoire ou contraire aux lois en vigueur.</p>

<p><strong>Propriété intellectuelle :</strong></p>
<p>Le contenu du site est protégé par les droits d'auteur et ne peut être reproduit sans autorisation préalable.</p>

<p><strong>Limitation de responsabilité :</strong></p>
<p>Nous ne sommes pas responsables des interruptions de service ou des dommages indirects résultant de l'utilisation du site.</p>

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