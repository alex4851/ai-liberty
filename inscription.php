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
<section class="inscription">
    <div class="formulaire_inscription">
        <form  method="post" action="inscription.php">
            <h2>S'inscrire</h2>

            <label for="prenom">Votre prenom : *</label>
            <input type="text" placeholder="Entrez votre prenom ..." id="prenom" name="prenom" required> <br/>
            
            <label for="niveau">Niveau : </label>
            <select name="niveau" id="niveau">
                <option value="lyceen">Lyceen</option>
                <option value="etudient">Etudient</option>
                <option value="professionnel">Professionnel</option>
            </select> <br />

            <label for="email">Votre email : *</label>
            <input type="email" placeholder="Entrez votre email ..." id="email" name="email" required> <br />

            <label for="pass">Votre mot de passe : *</label>
            <input type="password" placeholder="Entrez votre mot de passe ..." id="pass" name="pass" required> <br />
            
            <label for="pass2">Confirmer mot de passe : *</label>
            <input type="password" placeholder="Confirmer votre mot de passe ..." id="pass2" name="pass2" required> <br />

<?php
session_start();
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







            <div class="button1">
                <input type="submit" value="M'inscrire" name="ok" class="ok">
            </div>
        </form>

        <div class="reste">
            <div class="button2">   
                <p>J'ai déja un compte ?</p>
                <a href="connexion.php"><button>Se connecter</button></a>
            </div>
        </div>
    </div>
</section>

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







