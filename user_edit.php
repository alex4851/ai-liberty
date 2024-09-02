<?php
session_start();
if(isset($_SESSION['email']) and isset($_SESSION['mdp']))
{
  include("bdd.php");
}
else{
    header('Location:connexion.php');
}
if(isset($_POST['valider_niveau'])) {
    extract($_POST);

        $requete = $bdd->prepare("UPDATE users SET nom = :nom, niveau = :niveau, insta = :insta  WHERE id = :id");
        $requete->bindParam(':nom', $nom_user);
        $requete->bindParam(':niveau', $niveau);
        $requete->bindParam(':insta', $insta);
        $requete->bindParam(':id', $_SESSION['id']);
        $requete->execute();
        $_SESSION['nom'] = $nom_user;
        $_SESSION['niveau'] = $niveau;
        $_SESSION['insta'] = $insta;

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

<?php if(isset($_SESSION['nom'])){ ?>

<main class="content">
<section class="user_main">
    <div class="user_header">
        <h1>Modifier mon compte : </h1> 
    </div>
                <form method="post" action="user_edit.php">

                    <ul>
                        <li><label for="nom_user">Nom : </label><input type="text" name="nom_user" value="<?php if(isset($_SESSION["nom"])){echo $_SESSION["nom"];} ?>"></li> 
                        <li>Adresse mail :  <?php if(isset($_SESSION["email"])){echo $_SESSION["email"];} ?></li>
                        <li>Date d'inscription : <?php if(isset($_SESSION["date_inscription"])){echo $_SESSION["date_inscription"];} ?></li>
                        <li><label for="niveau">Niveau : </label>
                                        <select name="niveau" id="niveau" required>
                                            <option value="lyceen" >Lycéen</option>
                                            <option value="entrepreneur">Entrepreneur</option>
                                            <option value="professionnel">Professionnel</option>
                                            <option value="content_creator">Créateur de contenu</option>
                                            <option value="undefined">Aucun</option>
                                        </select></li>
                        <li><label for="insta">Instagram : </label><input type="text" name="insta" value="<?php if(isset($_SESSION["insta"])){echo $_SESSION["insta"];} ?>"></li>
                    </ul>
                                
                    <input type="submit" id="submit" name="valider_niveau">
                </form>
</section>
                

<?php }
else {echo "Connectez vous";}


?>

</main>
</body>
</html>