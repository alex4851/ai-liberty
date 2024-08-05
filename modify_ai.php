<?php
session_start();
if(isset($_SESSION['email']) and isset($_SESSION['mdp']) and $_SESSION['ia_admin']=='true')
{
  include("bdd.php");
  $suite = 'cacher';
  if(isset($_POST['modifier_ia'])){
    
    extract($_POST);
    
    $date = date('l jS \of F Y h:i:s A');
    $requete = $bdd->prepare("UPDATE ia_infos SET nom = :nom, ia_url = :ia_url, prix = :prix, iatype = :iatype, specialite = :specialite, ia_description = :ia_description, affiliation = :affiliation, coup_de_coeur = :coup_de_coeur, ajout = :ajout, ia_description_short = :ia_description_short, ia_img = :ia_img, niveau = :niveau WHERE id = :id");
    $requete->execute(
        array(
            "nom" => $nom,
            "ia_url" => $ia_url,
            "prix" => intval($prix_demande),
            "iatype" => $iatype_demande,
            "specialite" => $spe_demande,
            "ia_description" => $ia_description,
            "affiliation" => $affiliation,
            "coup_de_coeur" => $coup_de_coeur,
            "ajout" => $date,
            "ia_description_short" => $ia_description_short,
            "ia_img" => $ia_img,
            "niveau" => $niveau,
            "id" => $ia_id,
        )
    );
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
<body <?php if(!isset($_SESSION['nom'])){echo 'class="body_pas_co"';} ?> >

<header <?php if(isset($_SESSION['nom'])){echo 'class="connecte"';}else{echo 'class="pas-co"';}?> id="complet">
    <nav class="nav">
        <a href="index.php"><h1><img class="logo" src="img/logo.png"></h1></a>
        <ul class="nav-bar">
            <div class="ligne"><a href="index.php"><img src="img/home.png"><li>Accueil</li></a></div>
            <div class="ligne"><a href="more.php"><img src="img/news.png"><li>Nouveautées</li></a></div>
            <?php 
            if(isset
            ($_SESSION['ia_admin'])){
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


<div class="modify_ia_tout">
<a href="ia.php"><button>Retour</button></a>


<?php $montrer = "oui"; if( @$montrer == "oui"){?>

<section class="recherche_ia">

    <h1>Recherchez l'IA que vous souhaitez modifier : </h1>
<?php
@$name_ia = $_GET['name_ia'];
$afficher = "non";
if(isset($_GET['rechercher'])){
    $words = explode(" ",trim($name_ia));
    for($i=0; $i<count($words);$i++)
        $kw[$i]="nom like '%".$words[$i]."%'";
        $res = $bdd->prepare("SELECT * FROM ia_infos WHERE ".implode(" or ", $kw));
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute();
        $tab = $res->fetchAll();
        $afficher = "oui";
}
?>


<main class="recherche">
        <form method="get" action="">
            <input type="text" value='<?php echo $name_ia; ?>' name="name_ia" placeholder="Rechercher de l'IA" class="search_bar">
            <input type="submit" name="rechercher" value="Rechercher" class="recherche_button">
        </form>
    </main>

    <?php 
        if($afficher == "oui"){ ?>
        <div class="result">
            <h3><?=count($tab)." ".(count($tab)>1?"résultats trouvés":"résultat trouvé") ?></h3>
            <div class='cards_result'>
                <?php for($i=0; $i<count($tab);$i++){ 
                     ?>
            
                    <div class="card" id="recherche_card">
                                               <div class="header">
                                                   <span><?php echo $tab[$i]["nom"] ?></span> 
                                            
                                               </div>
                                               <div class="img"><img src="<?php echo $tab[$i]["ia_img"] ?>"/></div>
                                               <p class="info"><?php echo $tab[$i]["ia_description"] ?></p>
                                               <div class="share">
                                                   <p>Prix :  <?php echo $tab[$i]["prix"]; ?>€</p>
                                               </div>
                                               <form method="post" action=""><input type="int" value="<?php echo $tab[$i]["id"]; ?>" name="ia_to_modify_id" class="hidden"><button name="modifier" >Modifier</button></form>
                    </div>


                <?php } ?>
            </div>
        </div>
    <?php }
?>
</section>
<?php } if(isset($_POST['modifier'])){  
    $montrer = "non";
    $ia_modify = $_POST["ia_to_modify_id"];

    $sql = "SELECT * FROM ia_infos WHERE id = :id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindValue(":id", $ia_modify, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<section class="new_ia">
<form  method="post" action="" id="new_ia">
            <h2>Modifier <?php echo $result["nom"]; ?> à la base de donnée</h2>
            
            <label for="nom">Nom de l'IA :</label>
            <input type="text" value="<?php echo $result["nom"]; ?>" placeholder="Entrez nom IA ..." id="nom" name="nom" required> <br/>

            <label for="prix_demande">ID de l'IA :</label>
            <input type="number" value="<?php echo $result["id"]; ?>" class="range"  name="ia_id" placeholder="0" step="1" min="0" max="100" required><br/>

            <label for="ia_url">URL de l'IA :</label>
            <input type="text" value="<?php echo $result["ia_url"]; ?>" placeholder="Entrez url de l'IA ..." id="ia_url" name="ia_url" required> <br/>
            
            <label for="prix_demande">Prix de l'IA :</label>
            <input type="number" value="<?php echo $result["prix"]; ?>" class="range"  name="prix_demande" placeholder="0" step="1" min="0" max="100" required><br/>
            
            <label for="iatype_demande">Type : </label>
            <input type="text" value="<?php echo $result["iatype"]; ?>" name="iatype_demande" id="iatype_demande"> <br />

            <label for="spe_demande">Specialite :</label>
            <input type="text" name="spe_demande" id="spe_demande" value="<?php echo $result["specialite"]; ?>"> <br />

            <label for="niveau">Niveau :</label>
            <input type="text" value="<?php echo $result["niveau"]; ?>" name="niveau" id="niveau" required><br/>

            <label for="affiliation">Affiliation : </label>
            <input type="text" name="affiliation" id="affiliation" value="<?php echo $result["affiliation"]; ?>"><br />
            
            <label for="coup_de_coeur">Coup de coeur : </label>
            <input type="text" value="<?php echo $result["coup_de_coeur"]; ?>" name="coup_de_coeur" id="coup_de_coeur"><br/>


            <label for="ia_description">Description :</label>
            <textarea type="text" placeholder="Entrez une description ..." id="ia_description" name="ia_description" required><?php echo $result["ia_description"]; ?></textarea> <br />

            <label for="ia_description">Description courte :</label>
            <textarea type="text" placeholder="Entrez la description courte ..." id="ia_description_short" name="ia_description_short" required><?php echo $result["ia_description_short"]; ?></textarea> <br />
            
            <label for="ia_description">URL image :</label>
            <input type="text" placeholder="Entrez l'url de l'image de l'IA ..." id="ia_img" name="ia_img" value="<?php echo $result["ia_img"]; ?>" required><br />

            <input type="submit" value="Modifier <?php echo $result["nom"]; ?>" name="modifier_ia" class="modifier_ia">
</form>

<?php
}   
?>
</section>
</div>

</body>
</html>







