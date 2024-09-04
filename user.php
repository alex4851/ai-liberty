<?php
session_start();
if(isset($_SESSION['email']) and isset($_SESSION['mdp']))
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
    <link rel="website icon" type="png" href="img/logo_head.png">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA TOOLS</title>
</head>
<body>
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
                       
                        <div class="ligne"  id="active"><a href="user.php"><img src="img/account.png"><li>Mon compte</li></a></div>   
                        <div class="ligne"><a href="logout.php"><img src="img/logout.png"><li>Se déconnecter</li></a></div>
                    
                <?php  }
                else{
                    echo '<div class="ligne"><a href="connexion.php"><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo '<div class="ligne" id="ligne_inscription"><a href="inscription.php"><img src="img/login.png"><li id="inscription">S"inscrire</li></a></div>';
                }
            ?>      
        </ul>
    </nav>
</header>


<main class="content">
<section class="user_main">
    <div class="user_header">
        <h1>Infos sur mon compte : </h1> 
        <button class="edit"><a href="user_edit.php"><img src="img/edit.png" alt="edit button"></a></button>
    </div>
    <ul>
        <li>Nom : <?php if(isset($_SESSION["nom"])){echo $_SESSION["nom"];} ?></li> 
        <li>Adresse mail : <?php if(isset($_SESSION["email"])){echo $_SESSION["email"];} ?></li>
        <li>Date d'inscription : <?php if(isset($_SESSION["date_inscription"])){echo $_SESSION["date_inscription"];} ?></li>
        <li>Niveau : <?php if(isset($_SESSION["niveau"])){echo $_SESSION["niveau"];} ?></li>
        <li>Instagram : <?php if(isset($_SESSION["insta"])){echo $_SESSION["insta"];} ?></li>
    </ul>
</section>

<div class="user_message">
        <h3>Mes notifications privées : </h3> 
            <?php
            $sql = "SELECT * FROM private_messages WHERE receiver_id = :id ";
            $res = $bdd->prepare($sql);
            $res->bindValue(":id", $_SESSION['id'], PDO::PARAM_INT);
            $res->execute();
            $ans = $res->fetchAll();
            foreach ($ans as $row) {
                $sql = "SELECT * FROM private_messages WHERE id = :id ";
                $stmt = $bdd->prepare($sql);
                $stmt->bindValue(":id", $row['id'], PDO::PARAM_INT);
                $stmt->execute();
                $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <p>Message de <?php 
            $sql2 = "SELECT * FROM users WHERE id = :id";
            $res = $bdd->prepare($sql2);
            $res->bindValue(":id", $row2['sender_id'], PDO::PARAM_INT);
            $res->execute();
            $name = $res->fetch(PDO::FETCH_ASSOC);
            echo $name['nom']; 
            ?>  : <?php echo $row2['content']; ?></p>
            <?php } ?>

</div>









</main>
</body>
</html>