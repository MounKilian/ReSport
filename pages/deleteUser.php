<?php
session_start();
require_once '../includes/loginDB.php';
require_once '../includes/userDB.php';

if (!isset($_SESSION['name'])) {
    header("Location: ./loginPage.php");
    exit();
}

$user = getName();
if (!$user || $user['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID utilisateur invalide.";
    exit();
}

$userId = (int) $_GET['id'];

$success = deleteUserAndAssociatedData($userId); 

if ($success) {
    header("Location: ./adminUsersPage.php?deleted=1");
    exit();
} else {
    echo "Erreur lors de la suppression de l'utilisateur.";
}
