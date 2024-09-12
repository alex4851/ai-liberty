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
        header('Location:user.php');

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

<?php if(isset($_SESSION['nom'])){ 
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $bdd->prepare($sql);
$stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_DEFAULT);
?>

<main class="content">
<section class="user_main">
    <div class="user_header">
        <h1>Modifier mon compte : </h1> 
    </div>
                <form method="post" action="">
                    <ul>
                        <li><label for="nom_user">Nom : </label><input type="text" name="nom_user" value="<?php echo $result["nom"];?>"></li> 
                        <li>Adresse mail :  <?php echo $result["email"]; ?></li>
                        <li>Date d'inscription : <?php if(isset($result["date_inscription"])){echo $result["date_inscription"];} ?></li>
                        <li><label for="niveau">Niveau : </label>
                                        <select name="niveau" id="niveau" required>
                                            <option value="lyceen" >Lycéen</option>
                                            <option value="entrepreneur">Entrepreneur</option>
                                            <option value="professionnel">Professionnel</option>
                                            <option value="content_creator">Créateur de contenu</option>
                                            <option value="undefined">Aucun</option>
                                        </select></li>
                        <li><label for="insta">Instagram : </label><input type="text" name="insta" value="<?php if(isset($result["insta"])){echo $result["insta"];} ?>"></li>
                    </ul>


                                
                    <input type="submit" value="Modifier" id="submit" name="valider_niveau">
                </form>



            
    <div class="user_header">
        <h1>Modifier votre mot de passe : </h1> 
    </div>
        <form class="modify_pass" action="" method="post">
                <div class="field">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                    </svg>
                    <input class="input-field" type="text" placeholder="Ancien mot de passe ..." id="pass" name="old_pass" required>
                </div>

                <div class="field">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                    </svg>
                    <input class="input-field" type="password" placeholder="Nouveau mot de passe ..." id="pass1" name="pass1" required>
                    <button type="button" id="togglePassword1" class="password_changer" >Afficher</button><script src="password1.js"></script>
                </div>

                <div class="field">
                    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                    </svg>
                    <input type="password" class="input-field" placeholder="Confirmez nouveau mot de passe ..." id="pass" name="pass2" required>
                </div>
                <?php 
if(isset($_POST['changer_mdp'])){
    extract($_POST);
    if($result['mdp'] == md5(string: $old_pass)){
        if($pass1 == $pass2){
            $sql = "UPDATE users SET mdp = :mdp WHERE id=:id";
            $stmt = $bdd->prepare(query: $sql);
            $stmt->bindValue(':mdp', md5($pass1), PDO::PARAM_STR);
            $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            echo "MDP bien changé !<br>";
        }
        else{
            echo "MDP différents !<br>";
        }
    }
    else{
        echo "Votre ancien mot de passe est incorrect<br>";
    }
}
?>  
                <input type="submit" value="Modifier" id="submit" name="changer_mdp">
        </form>   
</section>
            

<?php }
else {echo "Connectez vous";}


?>

</main>
</body>
</html>