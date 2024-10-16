<?php
include('bdd.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$message_email_fail = "";
require 'phpmailer/vendor/autoload.php';
session_start();

/*Validation du compte par email*/

if(isset($_POST['ok'])){
    extract($_POST);
    $cle = rand(1000000, 9999999);
    if(isset($pass) and $pass != $pass2){
    }
    else{
        $email_verif = $bdd->query("SELECT * FROM users WHERE email = '$email'");
        $email_verif_test = $email_verif->fetch();
        $confirme = 0;
        if($email_verif_test == ""){
            
            $pass = md5($pass);
            $pass2 = md5($pass2);
            $requete = $bdd->prepare("INSERT INTO users VALUES (0, :nom, :niveau, :mdp, :email, :date_inscription, :ia_admin, :cle, :confirme, :insta, :token)");
            $requete->execute(
                array(
                    "nom" => strip_tags($prenom),
                    "niveau" => $niveau,
                    "mdp" => $pass,
                    "email" => strip_tags($email),
                    "date_inscription" => $date,
                    "ia_admin" => $ia_admin,
                    "cle" => $cle,
                    "confirme" => $confirme,
                    "insta" => "",
                    "token" => "",
                )   
            );
            


$mail = new PHPMailer(true);

try {
    // Configurer le serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';  // Remplacez par votre serveur SMTP
    $mail->SMTPAuth = true;
    $mail->Username = $my_email;  // Votre email SMTP
    $mail->Password = $my_pass;  // Votre mot de passe SMTP
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Destinataire
    $mail->setFrom($my_email, 'AI LIBERTY');
    $mail->addAddress($email);

    // Contenu de l'email
    $mail->isHTML(true);
    $mail->Subject = 'Confirmation de votre adresse e-mail';
    $mail->Body    = '
<html>
    <head>
        <style>
        *{
            text-align : center;
            color: black;
        }
            body {
                font-family: Arial, sans-serif;
                background-color: white;
                color: #141317;
                margin: 0;
                padding: 0;
                text-align: center;
                di
            }
            .container {
                border: 1px solid black;
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                max-width: 600px;
                margin: 0 auto;
            }
            .header {
                text-align: center;
                font-size: 24px;
                color: black;
                margin-bottom: 20px;
            }
            .content {
                font-size: 16px;
                color: black;
                margin-bottom: 30px;
                text-align: center;
            }
            .button-container {
                margin: 20px 0;
            }
            .button {
                background-color: #6b3bf4;
                color: #fff;
                text-decoration: none;
                padding: 15px 25px;
                border-radius: 50px;
                font-size: 18px;
                transition: background-color 0.3s ease;
            }
            .button:hover {
                background-color: #5a2bd9;
            }
            .footer {
                font-size: 12px;
                color: #dcdde1;
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                Bienvenue dans AI LIBERTY  '.$prenom.' !
            </div>
            <div class="content">
                Merci de rejoindre notre plateforme. Cliquez sur le bouton ci-dessous pour vérifier votre compte :
            </div>
            <div class="button-container">
                <a href="ai-liberty.fr/verify.php?code=' . $cle . '" class="button">Vérifier mon compte</a>
            </div>
            <div class="footer">
                Si vous n\'avez pas demandé cette vérification, vous pouvez ignorer cet email.
            </div>
            <img src="img/logo.png" src="ai-liberty logo">
        </div>
    </body>
    </html>';
    
    $mail->send();
    $message_alert = "show";
} catch (Exception $e) {
    echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
}

            if($confirme == 1){
            $requete = $bdd->prepare("SELECT * FROM users WHERE email = :email and mdp = :mdp");
            $requete->bindParam(':email', $email);
            $requete->bindParam(':mdp', $pass);
            $requete->execute();
            $data = $requete->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id']=$data['id'];
            $_SESSION['nom']=$data['nom'];
            $_SESSION['niveau'] = $data['niveau'];
            $_SESSION['mdp']=$data['mdp'];
            $_SESSION['email']=$data['email'];
            $_SESSION['date_inscription']=$data['date_inscription'];
            $_SESSION['ia_admin']=$data['ia_admin'];

            header("Location: index.php");
            exit();
            }
        }
        else{
            $message_email_fail = "<p class='co_error'>Email déjà utilisé</p>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez les outils IA de pointe qui vous correspondent. En seulement 5 minutes. Accéder gratuitement.">
    <link rel="website icon" type="png" href="img/logo_head.png">
    <title>AI LIBERTY</title>
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
                    echo '<div class="ligne"  id="active"><a href="connexion.php"><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo "<div class='ligne' id='ligne_inscription'><a href='inscription.php'><img src='img/login.png'><li id='inscription'>S'inscrire</li></a></div>";
                }
            ?>      
        </ul>
    </nav>
</header>

<div class="content" id="form_co">
<div class="inscription">
        <form class="form" action="inscription.php"  method="post">
        <p id="heading">S'inscrire</p>
            <div class="field">
                <input type="text" class="input-field" placeholder="Entrez votre prenom ..." id="prenom" name="prenom" required> <br/>
            </div>
            <div class="field">
                <select name="niveau" id="niveau" class="input-field">
                    <option value="lyceen">Lyceen</option>
                    <option value="entrepreneur">Entrepreneur</option>
                    <option value="professionnel">Professionnel</option>
                    <option value="content_creator">Créateur de contenu</option>
                </select> <br />
            </div>

            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"></path>
                </svg>
                <input class="input-field" type="email" placeholder="Entrez votre email ..." id="email" name="email" required>
            </div>
            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                </svg>
                <input class="input-field" type="password" placeholder="Entrez votre mot de passe ..." id="pass" name="pass" required>
    <button type="button" id="togglePassword" class="password_changer" >Afficher</button><script src="password.js"></script>

            </div>
            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                </svg>
                <input type="password" class="input-field" placeholder="Confirmez votre mot de passe ..." id="pass2" name="pass2" required>
            </div>
            
            <div class="btn">
                <input type="submit" value="S'inscrire" class="button1" name="ok" class="ok">
                <a href="connexion.php" id="less" class="button2">Connexion</a>
            </div>

            <?php
            if(isset($_POST['ok'])){
            if(isset($pass) and $pass != $pass2){
                echo '<p class="co_error">Mots de passe différents</p>';
            }
            if(@$message_alert == "show"){echo '<p class="co_error">Email de vérification envoyé à '.$email. '. Merci de revenir une fois effectuée<p>';}

            echo $message_email_fail;

         } ?>

         
<?php

?>

        </form>
</div>

</div>





</body>
</html>







