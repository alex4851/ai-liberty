<?php
include("bdd.php");
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
            <div class="ligne"  id="active"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
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


<section class="share_space">

<div class="chat_space">
<h1>Chat global : </h1>
<div id="chat-box"></div>
    <form id="chat-form" action="" method="post">
        <input type="text" id="message-input" name="message_content" placeholder="Entrez votre message">
        <button id="send-button" name="message"><img src="img/send.png" alt="send"></button>
    </form>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function () {
    let userScrolling = false;  // Variable pour détecter si l'utilisateur scrolle manuellement

    // Fonction pour scroller automatiquement en bas
    function autoScroll() {
        const chatBox = document.getElementById('chat-box');
        if (!userScrolling) {
            chatBox.scrollTop = chatBox.scrollHeight;  // Scroll vers le bas
        }
    }

    // Détecter si l'utilisateur scrolle manuellement
    $('#chat-box').on('scroll', function () {
        const chatBox = $(this);
        const scrollTop = chatBox.scrollTop();  // Position du scroll actuel
        const scrollHeight = chatBox.prop('scrollHeight');  // Hauteur totale du contenu
        const clientHeight = chatBox.prop('clientHeight');  // Hauteur visible

        if (scrollTop + clientHeight < scrollHeight) {
            userScrolling = true;  // L'utilisateur scrolle manuellement
        } else {
            userScrolling = false;  // L'utilisateur est en bas, réactiver le scroll automatique
        }
    });

    // Fonction pour charger les messages
    function loadMessages() {
        $.get('get_messages.php', function (data) {
            console.log("Messages reçus:", data);
            const messages = JSON.parse(data);
            $('#chat-box').html('');  // Vider la boîte de chat avant de la remplir

            messages.forEach(function (message) {
                // Appliquer une classe spéciale si l'utilisateur est un admin
                const adminClass = message.ia_admin == "true" ? 'admin' : 'user';
                const alignmentClass = message.is_me ? 'right' : 'left';  // Messages envoyés à droite ou à gauche
                
                $('#chat-box').append(
                    '<p class="message ' + adminClass + ' ' + alignmentClass + '">' +
                    '<strong class="chat_nom">' + message.nom + ':</strong> ' +
                    message.message + ' <em class="date">(' + message.timestamp + ')</em></p>'
                );
            });

            autoScroll();  // Scroll automatique uniquement si l'utilisateur n'a pas scrollé manuellement
        }).fail(function () {
            console.error("Erreur lors de la récupération des messages.");
        });
    }

    loadMessages();  // Charger les messages au démarrage
    setInterval(loadMessages, 3000);  // Recharger les messages toutes les 3 secondes

    $('#chat-form').submit(function (e) {
        e.preventDefault();
        const message = $('#message-input').val();

        if (message.trim() !== '') {
            $.post('send_message.php', { message_content: message }, function () {
                $('#message-input').val('');  // Vider l'input après l'envoi
                loadMessages();  // Recharger les messages après l'envoi
            }).fail(function () {
                console.error("Erreur lors de l'envoi du message.");
            });
        }
    });
});
    </script>




</section>












</body>
</html>