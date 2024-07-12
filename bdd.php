<?php
include("test.php");
date_default_timezone_set('UTC');
$date = date('l jS \of F Y h:i:s A');
$ia_admin = "false";

try{
    $bdd = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Erreur : ".$e->getMessage();
}
?>