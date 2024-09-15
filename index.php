<?php
include("bdd.php");
session_start();
?>
<?php
@$user_id = $_SESSION['id'];
if(isset($_POST['suppr_history'])) {
    $sql = "DELETE FROM search WHERE user_id = :user_id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    header("refresh"); 
}
?>
<?php
##Pour favorite :
        @$user_id = $_SESSION['id'];
        @$ia_id = $_POST['ia_id'];
        if(isset($_POST['add_fav'])){
            //Verif que existe pas deja
            $sql = "SELECT * FROM favorites WHERE ia_id = :ia_id and user_id = :user_id";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(":ia_id", $ia_id , PDO::PARAM_INT);
            $stmt->bindValue(":user_id", $_SESSION['id'], PDO::PARAM_INT);
            $stmt->execute();
            $fav_existe = $stmt->fetch(PDO::FETCH_ASSOC);
            if($fav_existe == ''){

            // Insérer la recherche dans la base de données
            $sql = "INSERT INTO favorites (user_id, ia_id) VALUES (:user_id, :ia_id)";
            $stmt = $bdd->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
            $stmt->execute();
            }
            header("refresh"); 
        }

        if(isset($_POST["remove_fav"])){
            //Supprimer des favoris
            $sql2 = 'DELETE FROM favorites WHERE user_id = :user_id and ia_id = :ia_id';
            $stmt = $bdd->prepare($sql2);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':ia_id', $ia_id, PDO::PARAM_INT);
            $stmt->execute();
            header("refresh"); 
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
    <link rel="website icon" type="png" href="img/logo_head.png">
    <title>AI LIBERTY</title>
</head>

<body <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?> >


<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne" id="active"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
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
                    echo '<div class="ligne"><a href="connexion.php"><img src="img/login.png"><li id="co">Se connecter</li></a></div>';
                    echo "<div class='ligne' id='ligne_inscription'><a href='inscription.php'><img src='img/login.png'><li id='inscription'>S'inscrire</li></a></div>";
                }
            ?>      
        </ul>
    </nav>
</header>



<!--Si connecté :-->

<?php
    if(isset($_SESSION['nom']) and isset($_SESSION['mdp']))
    {      
?>
<div class="reste">
<a href="sharing_space.php"><img id="chat_img" src="img/chat.png"></a>
<a href="user.php"><img id="notif_img" src="img/notif.png"></a>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function checkNewMessages() {
                $.get('check_new_message.php', function (data) {
                    if (data.new_message === true) {
                        // Si un nouveau message est détecté, changer l'image
                        $('#chat_img').attr('src', 'img/chat_unread.png');
                    } else {
                        // Si pas de nouveau message, remettre l'image par défaut
                        $('#chat_img').attr('src', 'img/chat.png');
                    }
                }, 'json').fail(function () {
                    console.error("Erreur lors de la vérification des nouveaux messages.");
                });
            }
            // Vérifier toutes les 5 secondes s'il y a un nouveau message
            setInterval(checkNewMessages, 5000);
        });
    </script>

<section class="mid_section">
    <div class="mid_section_part">
        <div class="contenu">
                <?php if( @$_SESSION['niveau'] == 'undefined'){ ?>
                <h3>Tu n'as pas de niveau, nos propositions ne sont donc pas adaptées au mieux :</h3>
                <form method="post" action="index.php">
                <label for="niveau">Niveau : </label>
                    <select name="niveau" id="niveau" required>
                        <option value="lyceen" >Lycéen</option>
                        <option value="etudient">Entrepreneur</option>
                        <option value="professionnel">Professionnel</option>
                        <option value="content_creator">Créateur de contenu</option>
                    </select> <br />
                <input type="submit" id="submit" value="Confirmer" name="valider_niveau">
                </form>
                
                <?php

                    if(isset($_POST['niveau']) && isset($_SESSION['email'])) {
                        $niveau = $_POST['niveau'];
                        $email_session = $_SESSION['email'];


                        try {
                            $requete = $bdd->prepare("UPDATE users SET niveau = :niveau WHERE email = :email");
                            $requete->bindParam(':niveau', $niveau);
                            $requete->bindParam(':email', $email_session);
                            $requete->execute();
                            $_SESSION['niveau'] = $niveau;


                            echo "Niveau bien changé";
                        } catch(PDOException $e) {
                            echo "Erreur : " . $e->getMessage();
                        }
                    }
                } 
            ?>

            <?php
                if(@$_SESSION['niveau'] !== 'undefined'){ 
                ?>
                <div class="adapte">
                        <h3>IA les plus populaires dans votre catégorie : </h3>
                    
                    
                    <div class="rapide">
                    <?php 
                    $sql = 'SELECT * FROM ia_infos WHERE niveau = :niveau';
                    $stmt = $bdd->prepare($sql);
                    $stmt->bindValue(':niveau', $_SESSION['niveau'], PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                    foreach($result as $row){
                        $sql = "SELECT * FROM ia_infos WHERE id = :ia_id ";
                        $stmt = $bdd->prepare($sql);
                        $stmt->bindValue(":ia_id", $row["id"], PDO::PARAM_STR);
                        $stmt->execute();
                        $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <div class="card_rapide">
                            <div class="first-content">
                                <span><?php echo $row2['nom']; ?></span>
                                <img src="<?php echo $row2['ia_img']; ?>"/>
                            </div>
                            <form action="result.php" method="get" class="second-content">
                                <input type="int" value="<?php echo $row2["id"]; ?>" name="ia_value_id" class="hidden">
                                <button type="submit" name="submit_ia_short">
                                    <span>Infos</span>
                                    <p><?php echo $row2['ia_description_short']; ?></p>
                                </button>
                            </form>
                        </div>
                        <?php } ?>
                </div>
                <?php } ?>



        </div>
    </div>
</section>


<aside class="right_section">
    <div class="contenu">
        <?php 
        if($_SESSION['confirme'] == 0){echo "<h1 style='margin-bottom: 20px; color:red;'>Merci de confirmer votre email à l'aide du message envoyé</h1>";}?>
        <section class="section_favorite">
                        <div class="favorites_header">
                            <h3 class="favorite_texte">Mes favoris :</h3>
                            <a href="recherche.php">
                                <img src="img/search.png">
                            </a>
                        </div>
                        <div class="favorite">
                            <?php
                                    $user_id = $_SESSION['id'];

                                    // Récupérer les favoris de l'utilisateur
                                    $sql = "SELECT ia_id FROM favorites WHERE user_id = :user_id ";
                                    $stmt = $bdd->prepare($sql);
                                    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    // Afficher les résultats
                                    
                                    foreach ($result as $row) {
                                        $sql = "SELECT * FROM ia_infos WHERE id = :ia_id ";
                                        $stmt = $bdd->prepare($sql);
                                        $stmt->bindValue(":ia_id", $row["ia_id"], PDO::PARAM_INT);
                                        $stmt->execute();
                                        $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                            

                                            <div class="card">
                                                <div class="header">
                                                    <span><?php echo $row2["nom"] ?></span>
                                                    <form method="post" action="">
                                                    <input type="int" class="hidden" name="ia_id" value="<?php echo $row["ia_id"] ?>">
                                                        <?php 
                                                        $sql = "SELECT * FROM favorites WHERE ia_id = :ia_id and user_id = :user_id";
                                                        $stmt = $bdd->prepare($sql);
                                                        $stmt->bindValue(":ia_id", $row["ia_id"] , PDO::PARAM_INT);
                                                        $stmt->bindValue(":user_id", $_SESSION['id'], PDO::PARAM_INT);
                                                        $stmt->execute();
                                                        $fav_existe = $stmt->fetch(PDO::FETCH_ASSOC);
                                                        if($fav_existe == ''){ ?>
                                                        <button  id="button_submit" type="submit" name="add_fav"><img src="img/not_favorite.png" alt="Add to Favorites" class="favorite-icon" name="add_fav"></button>
                                                        <?php }
                                                        else{
                                                        ?>
                                                        <button id="button_submit" type="submit" name="remove_fav" ><img src="img/favorite.png" alt="Add to Favorites" class="favorite-icon"></button>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                               <?php if($row2["coup_de_coeur"] == 'oui'){ ?> <p class="info_cdc">Coup de coeur</p> <?php } ?>
                                                <div class="img"><img src="<?php echo $row2["ia_img"] ?>"/></div>
                                                <p class="info"><?php echo $row2["ia_description"] ?></p>
                                                <a href="<?php echo $row2["ia_url"] ?>" class="button_position" target="_blank"><button>Aller sur le site</button></a>
                                               <?php if($row2["affiliation"] == 'oui'){ ?> <p class="info_affiliation">Lien affilié</p> <?php } ?>

                                            </div>
                                        <?php
                                    }
                                ?>      
                    </div>
        </section>
<!--historique-->
        <div class="favorites_header">
            <h3>Chercher une autre IA : </h3>
            <a href="questionnaire.php">
                <img src="img/add_fav.png">
            </a>
        </div>
    <?php 
                   $user_id = $_SESSION['id'];
                    // Récupérer l'historique des recherches de l'utilisateur
                    $sql = "SELECT search_query, search_date FROM search WHERE user_id = :user_id ORDER BY search_date DESC";
                    $stmt = $bdd->prepare($sql);   
                    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC); 
                    if(count($result) > 0){ ?>


                <section class="section_questionnaire">
                   
                        <div class="historique">
                            <div class="header_historique">
                                <h4>Récent :</h4>
                                <form method="post" action="index.php">
                                    <button id="button_submit" type="submit" name="suppr_history"><img id="header_historique_img" src="img/trash.png" alt="trash"></button>
                                </form>
                            </div>
                            
                            <div class="historique_cards">
                                <?php

                                    # Afficher les résultats
                                    
                                    foreach ($result as $row) {
                                        $sql = "SELECT * FROM ia_infos WHERE id = :ia_id ";
                                        $stmt = $bdd->prepare($sql);
                                        $stmt->bindValue(":ia_id", $row["search_query"], PDO::PARAM_INT);
                                        $stmt->execute();
                                        $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                            <div class="card_rapide">
                                                <div class="first-content">
                                                    <span><?php echo $row2['nom']; ?></span>
                                                    <img src="<?php echo $row2['ia_img']; ?>"/>
                                                </div>
                                                <form action="result.php" method="get" class="second-content">
                                                    <input type="int" value="<?php echo $row2["id"]; ?>" name="ia_value_id" class="hidden">
                                                    <button type="submit" name="submit_ia_short">
                                                        <span>Infos</span>
                                                        <p><?php echo $row2['ia_description_short']; ?></p>
                                                    </button>
                                                </form>
                                            </div>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                </section>
                <?php } ?>
    
    </div>

</aside>                

</body>


<?php }

//Si pas connecté :

                else{ ?>




<div class="container"></div>

<div class="pas_co_content">
        <section class="welcomer">
            <div class="name_ai">AI LIBERTY</div>

            <h1>Découvrez les outils IA de pointe qui vous correspondent <br>
            En seulement 5 minutes</h1>
            <div class="acces_quest">
                <div class="button">
                    <a href="questionnaire.php">
                        <button>Accéder gratuitement</button>
                    </a>
                </div>
            </div>
        </section>
        <aside class="image">
            <img src="img/exemple.jpg" alt="image de l'accueil">
        </aside>



<footer>
    <div>
        <a href="mentions-legales.php">Mentions légales</a>
        <a href="politique-confidentialite.php">Politique de confidentialité</a>
        <a href="cgu.php">CGU</a>
        <a href="politique-cookies.php">Politique des cookies</a>
    </div>
    <div>
        <p style="margin: 0; font-size: 14px; color: #6c757d;">&copy; <?php echo date("Y"); ?> AI-LIBERTY - Tous droits réservés</p>
    </div>
</footer>

</div>

</body>
<?php }?>

</html>