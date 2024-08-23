<?php
session_start();
if(isset($_SESSION['email']) and isset($_SESSION['mdp']) and $_SESSION['ia_admin']=='true')
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
    <link rel="stylesheet" href="style.css">
    <link rel="website icon" type="png" href="img/logo_head.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IA TOOLS</title>
</head>
 <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?>

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
            <?php 
            if(isset($_SESSION['ia_admin'])){
                if($_SESSION["ia_admin"] === "true"){
                echo '<div class="ligne" id="active"><a href="ia.php"><img src="img/admin.png"><li>Admin space</li></a></div>';
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
    </nav>
</header>

<section class="new_ia">

<div class="chat_space">
<a href="ia.php"><button class="button_back">Retour</button></a>

<div id="chat-box"></div>
    <form id="chat-form" action="" method="post">
        <input type="text" id="message-input" name="message_content" placeholder="Entrez votre message">
        <button id="send-button" name="message"><img src="img/send.png" alt="send"></button>
    </form>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    
    function autoScroll() {
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    }
        $(document).ready(function() {
            function loadMessages() {
                $.get('get_messages.php', function(data) {
                console.log("Messages reçus:", data); // Debugging
                const messages = JSON.parse(data);
                $('#chat-box').html('');
                messages.forEach(function(message) {
                    $('#chat-box').append('<p class="message"><strong class="chat_nom">' + message.nom + ':</strong> ' + message.message + ' <em class="date">(' + message.timestamp + ')</em></p>');
                });
                autoScroll(); // Scroll to the bottom after loading messages
            }).fail(function() {
                console.error("Erreur lors de la récupération des messages.");
            });
        }
            

            loadMessages();
            setInterval(loadMessages, 3000);

            $('#chat-form').submit(function(e) {
                e.preventDefault();
                const message = $('#message-input').val();
                if (message.trim() !== '') {
                    $.post('send_message.php', { message_content: message }, function() {
                        $('#message-input').val('');
                        loadMessages();
                    }).fail(function() {
                        console.error("Erreur lors de l'envoi du message.");
                    });
                }
            });
        });
    </script>

</section>

</body>
</html>


