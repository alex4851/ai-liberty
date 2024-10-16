<?php
// Connexion à la base de données
require 'bdd.php';
include("bdd.php");

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    
    // Rechercher le code dans la base de données
    $query = "SELECT * FROM users WHERE cle = :code";
    $stmt = $bdd->prepare($query);
    $stmt->bindValue(":code", $code , PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if(isset($result['id'])) {
        // Marquer l'utilisateur comme vérifié
        $query = "UPDATE users SET confirme = 1 WHERE cle = :code";
        $stmt = $bdd->prepare($query);
        $stmt->bindValue(":code", $code , PDO::PARAM_INT);
        $stmt->execute();
        $message = "show";
        $email = $result['email'];
        $pass = $result['mdp'];        
    } else {
        echo "Code de vérification invalide.";
    }
} else {
    echo "Code manquant.";
}


?>

<?php
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
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
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
                    echo '<div class="ligne"  id="active"><a href="connexion.php" ><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo '<div class="ligne" id="ligne_inscription"><a href="inscription.php"><img src="img/login.png"><li id="inscription">S"inscrire</li></a></div>';
                }
            ?>      
        </ul>
        <script src="navigation.js"></script>       
    </nav>
</header>

<div class="content" id="form_co">
    <section class="verify">

    <?php

if($message == "show"){
    echo "<p>Votre email a été vérifié avec succès.</p>";
}
    ?>

<form class="form" method="post" action="">
    <input type="submit" name="connexion" value="Accéder au site">

<?php
include("bdd.php");
if(isset($_POST['connexion'])){
    if($email != "" && $pass !=""){
        $requete = $bdd->prepare("SELECT * FROM users WHERE email = :email and mdp = :mdp");
        $requete->bindParam(':email', $email);
        $requete->bindParam(':mdp', $pass);
        $requete->execute();
        $data = $requete->fetch(PDO::FETCH_ASSOC); // Récupérer les résultats

        if($data != ""){
            $_SESSION['id'] = $data['id'];
            $_SESSION['nom'] = $data['nom'];
            $_SESSION['niveau'] = $data['niveau'];
            $_SESSION['mdp'] = $data['mdp'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['date_inscription'] = $data['date_inscription'];
            $_SESSION['ia_admin'] = $data['ia_admin'];
            $_SESSION['insta'] = $data['insta'];
            $_SESSION['confirme'] = $data['confirme'];
            header("Location: index.php");
        }
    }
}


?>
</form>


</section>
</div>


    
</body>
</html>