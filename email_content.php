<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';
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
                        $mail->Body    = 'Bonjour '.$prenom. ', <br>Vous venez de créer un compte sur AI LIBERTY. <br>Nous voulons être sûr que vous êtes le créateur de cette demande.<br> Merci de cliquez sur le lien suivant pour vérifier votre adresse e-mail : 
    <a href="ai-liberty.fr/verify.php?code=' . $cle . '">Vérifier votre email</a> <br> Si vous ne savez pas de quoi il retourne, merci de ne pas prendre en compte de ce message.';
                        
                        $mail->send();
                        $message_alert = "show";
                    } catch (Exception $e) {
                        echo "L'email n'a pas pu être envoyé. Erreur: {$mail->ErrorInfo}";
                    }

                    $requete = $bdd->prepare("SELECT * FROM users WHERE email = :email and mdp = :mdp");
                    $requete->bindParam(':email', $email);
                    $requete->bindParam(':mdp', $pass_hashed);
                    $requete->execute();
                    $data = $requete->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['id']=$data['id'];
                    $_SESSION['nom']=$data['nom'];
                    $_SESSION['niveau'] = $data['niveau'];
                    $_SESSION['mdp']=$data['mdp'];
                    $_SESSION['email']=$data['email'];
                    $_SESSION['date_inscription']=$data['date_inscription'];
                    $_SESSION['ia_admin']=$data['ia_admin'];
?>