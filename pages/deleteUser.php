<?php
require_once '../includes/userDB.php';

if (!isset($_GET['id'])) {
    echo "ID utilisateur manquant.";
    exit();
}

$id = $_GET['id'];
deleteUserById($id); // à créer

header("Location: ./userPage.php");
exit();
