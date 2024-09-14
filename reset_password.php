<?php
include('bdd.php');
$head = "false";
if($head=="true"){
    header("Location: index.php");
}
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
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautés</li></a></div>
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
                    echo "<div class='ligne' id='ligne_inscription'><a href='inscription.php'><img src='img/login.png'><li id='inscription'>S'inscrire</li></a></div>";
                }
            ?>      
        </ul>
        <script src="navigation.js"></script>       
    </nav>
</header>

<div class="content" id="form_co">
    <section class="connexion">



<?php
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Vérifier le jeton et sa validité
    $stmt = $bdd->prepare("SELECT * FROM users WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);


    if (isset($data['token'])) {
        $user = $data['id'];
        // Afficher le formulaire pour changer le mot de passe
        ?>
<form class="form" method="post" action="">
    <input type="hidden" name="token" value="<?php echo $token; ?>">

    <p id="heading">Modifier mot de passe</p>
    <div class="field">
        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
        </svg>
        <input type="password" placeholder="Entrez votre mot de passe ..." id="pass" name="password" class="input-field" required>
        <button type="button" id="togglePassword" class="password_changer" >Afficher</button><script src="password.js"></script>
    </div>
    <div class="btn">
    <input type="submit" class="button1" value="Mettre à jour" name="maj" class="ok">
    </div>


        <?php

    } else {
        echo "<p>Le lien de réinitialisation est invalide ou a expiré.</p>";
    }

} else {
    echo "Jeton manquant.";
}

if(isset($_POST['maj']) AND $data['token'] != 0){

    extract($_POST);
    $token = 0;
    $hash_pass = md5($password);
    $stmt = $bdd->prepare("UPDATE users SET mdp = :mdp, token = :token WHERE id = :id");
    $stmt->bindParam(':mdp', $hash_pass);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':id', $user);
    $stmt->execute();
    echo "<p class='co_error'>Mot de passe bien changé ! Vous pouvez vous connecter !</p>";
    $head ="true";
}
?>
</form>
    </section>
</div>
</body>
</html>