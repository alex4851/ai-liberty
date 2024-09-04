<?php
session_start();

if(isset($_SESSION['email']) and isset($_SESSION['mdp']) and $_SESSION['ia_admin']=='true')
{
  include("bdd.php");
  if(isset($_POST['delete_user'])){
    extract($_POST);
    $sql = "DELETE FROM tickets WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(":id", $id_deleted_user, PDO::PARAM_INT);
    $stmt->execute();
}
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
<body >
<a href="ia.php"><button class="button_back">Retour</button></a>

<section class="new_ia" id="ticket_admin">

    <div class="users_info">
        <?php 
        $res = $bdd->prepare("SELECT * FROM tickets WHERE solved != 'oui'");
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute();
        $ans = $res->fetchAll();
        foreach ($ans as $row) {
            $sql = "SELECT * FROM tickets WHERE id = :ia_id ";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(":ia_id", $row['id'], PDO::PARAM_INT);
            $stmt->execute();
            $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>

        <div class="user_info">
            <div class="info_header">
                <h1>Envoyé par : <?php 
                $sql2 = "SELECT * FROM users WHERE id = :id";
                $res = $bdd->prepare($sql2);
                $res->bindValue(":id", $row2['user_id'], PDO::PARAM_INT);
                $res->execute();
                $name = $res->fetch(PDO::FETCH_ASSOC);
                echo $name['nom']; ?></h1>
                <?php if($row2['id'] != 84){?><form method="post" action=""><div class="hidden"><input type="int" name="id_deleted_user" value="<?php echo $row2['id']; ?>"></div><button type="submit" class="delete_ticket" name="delete_user"><img class="delete_user" src="img/trash.png" alt="supprimer"></button></form><?php } ?>
            </div>
            <p>ID du ticket: <?php echo $row2['id']; ?></p>
            <p>Type de ticket : <?php echo $row2['class']; ?></p>
            <p>Contenu : <?php echo $row2['content']; ?></p>
            <p>Date d'envoi du ticket : <?php echo $row2['ticket_time']; ?></p>
        </div>

        <?php } ?>
    </div>

<section class="ticket_ans">
<div class="ticket-container">
        <h1>Réponse de Ticket</h1>
        <form action="tickets_admin.php" class="form_ticket_admin" method="POST">
            <label for="ticket">Ticket (ID) : </label>
            <input type="int" name="id_ticket"> <br>

            <label for="solve">Résolu :</label>
                <div class="wrapper_container">
                    <div class="wrapper">
                        <input value="oui" id="oui" name="solved" type="radio" class="state" />
                        <label for="oui" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">Oui</span>
                            </div>
                        </label>
                    </div>
                    <div class="wrapper">
                        <input value="non" id="non" name="solved" type="radio" class="state" />
                        <label for="non" class="label">
                            <div class="label_2">
                                <div class="indicator"></div>
                                <span class="text">Non</span>
                            </div>
                        </label>
                    </div>
                </div>

            <label for="description">Réponse à l'auteur du ticket :</label>
            <textarea placeholder="Dévellopez" id="ex" name="ex" rows="5" required></textarea>
            
            <button name="submit_ticket_verif" type="submit_ticket">Envoyer le Ticket</button>
    

<?php
if(isset($_POST['submit_ticket_verif'])){
    extract($_POST);
    $sql = "UPDATE tickets SET solved = :solved WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':solved', $solved, PDO::PARAM_STR);
    $stmt->bindValue(':id', $id_ticket, PDO::PARAM_INT);
    $stmt->execute();
    $sql = "SELECT * FROM tickets WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':id', $id_ticket, PDO::PARAM_INT);
    $stmt->execute();
    $row2 = $stmt->fetch();
    $receiver = $row2["user_id"];

    $sql = "INSERT INTO private_messages (sender_id, receiver_id, content, is_read) VALUES (:sender_id, :receiver_id, :content, :is_read)";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':sender_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->bindValue(':receiver_id', $receiver, PDO::PARAM_INT);
    $stmt->bindValue(':content', $ex, PDO::PARAM_STR);
    $stmt->bindValue(':is_read', 'False', PDO::PARAM_STR);
    $stmt->execute();

    
    echo "<p>Ticket bien submit !</p>";
}

?>
        </form>
    </div>
</section>
</section>


</body>
</html>