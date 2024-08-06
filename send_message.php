
<?php
session_start();
include('bdd.php');

if (isset($_POST['message_content'])) {
    $user_id = $_SESSION['id'];
    $message = $_POST['message_content'];

    $stmt = $bdd->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $message, PDO::PARAM_STR);
    $stmt->execute();
}
?>