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
    <section class="connexion">


<form class="form" method="post" action="">
    <p id="heading">Login</p>
    <div class="field">
    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"></path>
    </svg>
        <input type="email" placeholder="Entrez votre email ..." class="input-field" id="email" name="email" required>
    </div>
    <div class="field">
    <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
    </svg>
    <input type="password" placeholder="Entrez votre mot de passe ..." id="pass" name="pass" class="input-field" required>
    <button type="button" id="togglePassword" class="password_changer" >Afficher</button><script src="password.js"></script>
    </div>
    <div class="btn">
    <input type="submit" class="button1" value="Connexion" name="connexion" class="ok">
    <a href="inscription.php" class="button2">Inscription</a>
    </div>

<?php
include("bdd.php");
if(isset($_POST['connexion'])){
    $email = $_POST["email"];
    $pass = md5($_POST["pass"]); 
    if($email != "" && $pass !=""){
        $requete = $bdd->prepare("SELECT * FROM users WHERE email = :email and mdp = :mdp");
        $requete->bindParam(':email', $email);
        $requete->bindParam(':mdp', $pass);
        $requete->execute();
        $data = $requete->fetch(PDO::FETCH_ASSOC); // Récupérer les résultats
        /*
        if(isset($_POST['remember'])){
           setcookie('auth', $requete->id .'-----'.sha1($requete->mdp . $requete->email), time() + 3600 * 24 * 3, '/', 'localhost', false, true);
        }
        */
        if($data == ""){
            echo "<p class='co_error'>Email ou mot de passe incorrect !</p>";
        }
        else{
            $_SESSION['id'] = $data['id'];
            $_SESSION['nom'] = $data['nom'];
            $_SESSION['niveau'] = $data['niveau'];
            $_SESSION['mdp'] = $data['mdp'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['date_inscription'] = $data['date_inscription'];
            $_SESSION['ia_admin'] = $data['ia_admin'];
            $_SESSION['insta'] = $data['insta'];
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





