<?php
session_start();
if(isset($_SESSION['email']) and isset($_SESSION['mdp']) and $_SESSION['ia_admin']=='true')
{
  include("bdd.php");
}
else{
    header('Location:connexion.php');
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="website icon" type="png" href="img/admin.png">
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
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
            <?php 
            if(isset($_SESSION['ia_admin'])){
                if($_SESSION["ia_admin"] === "true"){
                echo '<div class="ligne" id="active"><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
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
                    echo '<div class="ligne" id="ligne_inscription"><a href="inscription.php"><img src="img/login.png"><li id="inscription">S"inscrire</li></a></div>';
                }
            ?>      
        </ul>
        <script src="navigation.js"></script>       
    </nav>
</header>


<div class="content">
    <div class="content_admin">
        <h1>Tools :</h1>
        <section class="tools"> 
            <a href="add_ia.php"><button>Add a new ia</button></a>
            <a href="modify_ai.php"><button>Modify an ia</button></a>
            <a href="" target="_blank"><button>Access the data base</button></a>
        </section>
        <h1>Statistiques :</h1>
        <section class="stats">
            <p>Nombre d'utilisateurs connectés :</p>
            <p>Nombre d'inscrits : <?php
            $res = $bdd->prepare("SELECT nom FROM users");
            $res->setFetchMode(PDO::FETCH_ASSOC);
            $res->execute();
            $user_nombre = $res->fetchAll();
            echo count($user_nombre); ?></p>
            <p>Nombre d'IA dans la data base : <?php
            $res = $bdd->prepare("SELECT nom FROM ia_infos");
            $res->setFetchMode(PDO::FETCH_ASSOC);
            $res->execute();
            $ia_nombre = $res->fetchAll();
            echo count($ia_nombre); ?> </p>
        </section>
    </div>           
</div>
            
</body>