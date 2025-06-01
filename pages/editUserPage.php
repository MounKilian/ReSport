<?php
session_start();
require_once '../includes/userDB.php';
require_once '../includes/loginDB.php';


if (!isset($_GET['id'])) {
    echo "ID utilisateur manquant.";
    exit();
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    updateUser($id, $_POST); // une autre fonction à créer
    header("Location: ./editUserPage.php?id=$id&success=1");
    exit();
}

$userFull = getUserById($id);

if (!$userFull || !isset($userFull['user'])) {
    echo "Utilisateur introuvable.";
    exit();
}

$userForForm = $userFull['user'];

$success = isset($_GET['success']) && $_GET['success'] == 1;

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/account.css">
        <link rel="stylesheet" href="../css/header.css">
        <title>ReSport - Compte</title>
    </head>
    <body>
        <?php 
        include '../templates/header.php'; 
        ?>
        <div class="body">
            <h2 style="text-align:center;">Mofifier l'utilisateur <?= htmlspecialchars($userForForm ['username'] ?? '') ?></h2>
            
            <div class="profile-info">
                <form method="POST">
                    <div>Nom d'utilisateur :</div>
                    <input type="text" name="username" value="<?= htmlspecialchars($userForForm ['username'] ?? '') ?>">

                    <div>Email :</div>
                    <input type="email" name="email" value="<?= htmlspecialchars($userForForm ['email'] ?? '') ?>">

                    <div>Role :</div>
                    <select name="role">
                        <option value="client" <?= (isset($userForForm ['role']) && $userForForm ['role'] === 'client') ? 'selected' : '' ?>>Client</option>
                        <option value="admin" <?= (isset($userForForm ['role']) && $userForForm ['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                    </select>
                    

                    <button type="submit">Enregistrer</button>
                </form>
            </div>
        </div>
    </body>
</html>