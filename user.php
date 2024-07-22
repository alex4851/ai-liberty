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
        <script src="navigation.js"></script>       
    </nav>
</header>


<main class="content">
<section class="user_main">
<h1>Infos sur mon compte :</h1>
<ul>
    <li>Nom : <?php if(isset($_SESSION["nom"])){echo $_SESSION["nom"];} ?></li> 
    <li>Adresse mail : <?php if(isset($_SESSION["email"])){echo $_SESSION["email"];} ?></li>
    <li>Date d'inscription : <?php if(isset($_SESSION["date_inscription"])){echo $_SESSION["date_inscription"];} ?></li>
    <li>Niveau : <?php if(isset($_SESSION["niveau"])){echo $_SESSION["niveau"];} ?></li>
    <li>Instagram : <?php if(isset($_SESSION["instagram"])){echo $_SESSION["instagram"];} ?></li>
</ul>
</section>
<?php if(isset($_SESSION['nom'])){ ?>
<h1>Tu souhaites changer de niveau :</h1>
                <form method="post" action="user.php">
                <label for="niveau">Niveau : </label>
                    <select name="niveau" id="niveau" required>
                        <option value="lyceen" >Lyceen</option>
                        <option value="etudient">Etudient</option>
                        <option value="professionnel">Professionnel</option>
                        <option value="undefined">Aucun</option>
                    </select>
                <input type="submit" id="submit" value="Confirmer" name="valider_niveau">
</form>
<?php }
else {echo "Connectez vous";}

if(isset($_POST['niveau']) && isset($_SESSION['email'])) {
    $niveau = $_POST['niveau'];
    $email_session = $_SESSION['email'];


    try {
        $requete = $bdd->prepare("UPDATE users SET niveau = :niveau WHERE email = :email");
        $requete->bindParam(':niveau', $niveau);
        $requete->bindParam(':email', $email_session);
        $requete->execute();
        $_SESSION['niveau'] = $niveau;


        echo "Niveau bien changé";
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

</main>
</body>
</html>