<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="website icon" type="png" href="img/logo_head.png">
    <link href="https://fonts.googleapis.com/css2?family=Spinnaker&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA TOOLS</title>
</head>
<body <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?> >

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne" id="active"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
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
                    echo '<div class="ligne"><a href="connexion.php"><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo '<div class="ligne" id="ligne_inscription"><a href="inscription.php"><img src="img/login.png"><li id="inscription">S"inscrire</li></a></div>';
                }
            ?>      
        </ul>
        <script src="navigation.js"></script>       
    </nav>
</header>

<div class="content">
<div class="inscription">
        <form class="form"  method="post" action="inscription.php">
        <p id="heading">S'inscrire</p>
            <div class="field">
                <input type="text" class="input-field" placeholder="Entrez votre prenom ..." id="prenom" name="prenom" required> <br/>
            </div>
            <div class="field">
                <select name="niveau" id="niveau" class="input-field">
                    <option value="lyceen">Lyceen</option>
                    <option value="etudient">Etudient</option>
                    <option value="professionnel">Professionnel</option>
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
            </div>
            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"></path>
                </svg>
                <input type="password" class="input-field" placeholder="Confirmez votre mot de passe ..." id="pass2" name="pass2" required>
            </div>
            <div class="btn">
            <input type="submit" value="S'inscrire" class="button1" name="ok" class="ok">
            <a href="connexion.php" class="button2">Sign In</a>
            </div>
        </form>

<?php
require "php_mailer/PHPMailerAutoload.php";
include('bdd.php');




if(isset($_POST['ok'])){
    extract($_POST);
    $cle = rand(1000000, 9999999);
    $ia_admin = "false";
    if(isset($pass) and $pass != $pass2){
        echo '<p>Mots de passe différents</p>';
    }
    else{
        $email_verif = $bdd->query("SELECT * FROM users WHERE email = '$email'");
        $email_verif_test = $email_verif->fetch();
        if($email_verif_test == ""){
            
            $pass = md5($pass);
            $requete = $bdd->prepare("INSERT INTO users VALUES (0, :nom, :niveau, :mdp, :email, :date_inscription, :ia_admin, :cle, :confirme)");
            $requete->execute(
                array(
                    "nom" => $prenom,
                    "niveau" => $niveau,
                    "mdp" => $pass,
                    "email" => $email,
                    "date_inscription" => $date,
                    "ia_admin" => $ia_admin,
                    "cle" => $cle,
                    "confirme" => 0,
                )   
            );
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
 /*           function smtpmailer($to, $from, $from_name, $subject, $body)

            {
                include("test.php");
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true; 
        
                $mail->SMTPSecure = 'ssl'; 
                $mail->Host = $host_email;
                $mail->Port = $port_email;  
                $mail->Username = $username_email;
                $mail->Password = $password_email;   
        
            //   $path = 'reseller.pdf';
            //   $mail->AddAttachment($path);
        
                $mail->IsHTML(true);
                $mail->From=$username_email;
                $mail->FromName=$from_name;
                $mail->Sender=$from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
            }
            
            $to   = $email;
            $from = $username_email;
            $name = 'AI LIBERTY';
            $subj = 'Email de confirmation de création du compte';
            $msg = 'http://localhost/projet_ai/verif.php?id='.$_SESSION['id'].'&cle='.$cle;
            if(!$mail->Send())
                {
                    $error ="Please try Later, Error Occured while Processing...";
                    return $error; 
                }
                else 
                {
                    $error = "Thanks You !! Your email is sent.";  
                    return $error;

                }
            $error= smtpmailer($to,$from, $name ,$subj, $msg);
                }*/
        }
        else{
            echo "<h5>Email déjà utilisé</h5>";
        }
    }

}

?>

</div>

</div>






<!--
<footer>
    <div class="reseau">
    <h5>Nos reseaux sociaux</h5>
    <ul>
        <li><a href="#">Linkedin</a></li>
        <li><a href="#">Instagram</a></li>
        <li><a href="#"></a></li>
        <li><a href="#"></a></li>
    </ul>
    </div>
    <div class="aide">
    <h5>Assistance</h5>
    <ul>
        <li><a href="#">Nous contacter</a></li>
        <li><a href="#">Centre d'aide</a></li>
    </ul>
    </div>
    <div class="A propos">
    <h5>Assistance</h5>
    <ul>
        <li><a href="#">Fonctionnement du site</a></li>
        <li><a href="#">Données et confidentialité</a></li>
    </ul>
    </div>
</footer>
-->
</body>
</html>







