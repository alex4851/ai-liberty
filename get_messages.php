
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('bdd.php');

$result = $bdd->query("SELECT messages.message, messages.timestamp, users.nom 
                       FROM messages 
                       JOIN users ON messages.user_id = users.id 
                       ORDER BY messages.timestamp DESC");

$messages = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $messages[] = $row;
}


if (empty($messages)) {
    error_log("Aucun message trouvé");
} else {
    error_log("Messages trouvés: " . count($messages));
}

echo json_encode($messages);

?>
