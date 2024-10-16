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
            <div class="ligne" id="active"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
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
                       
                        <div class="ligne" ><a href="user.php"><img src="img/account.png"><li>Mon compte</li></a></div>   
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


<main class="content_tickets">
<div class="ticket-container">
        <h1>Formulaire de Ticket</h1>
        <form action="tickets.php" method="POST">
            
            <label for="sujet">Sujet:</label>
        

            <select name="sujet" id="sujet">
                <option value="technique">Problème technique</option>
                <option value="proposition">Proposition d'amélioration</option>
                <option value="bully">Insécurité</option>
                <option value="autre">Autre ...</option>
            </select>
            
            <label for="description">Description:</label>
            <textarea placeholder="Dévellopez" id="description" name="description" rows="5" required></textarea>
            
            <button name="submit_ticket" type="submit_ticket">Envoyer le Ticket</button>
            <?php
if(isset($_POST['submit_ticket'])){
    extract($_POST);
    $sql = "INSERT INTO tickets (user_id , class , content) VALUES ( :user_id , :class, :content)";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':user_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->bindValue(':class', $sujet, PDO::PARAM_STR);
    $stmt->bindValue(':content', strip_tags($description), PDO::PARAM_STR);
    $stmt->execute();
    echo "<p>Ticket bien envoyé !</p>";
}

?>
        </form>
    </div>



</main>
</body>
</html>