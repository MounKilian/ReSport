<?php
    session_start();
    // Redirection si non connecté ou pas admin
    if (!isset($_SESSION['name'])) {
        header("Location: ./loginPage.php");
        exit();
    }

    // include '../includes/loginDB.php';
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
        <?php include '../templates/header.php'; ?>
        <div class="admin-actions" style="display: flex; gap: 1rem; padding: 1rem;">
            <a href="./adminUsersPage.php" class="cta-button" style="padding: 0.5rem 1rem; font-size: 1rem; background-color: #007bff; color: white; border-radius: 5px; text-decoration: none;">
                Gérer les Utilisateurs
            </a>
            <a href="./adminArticlesPage.php" class="cta-button" style="padding: 0.5rem 1rem; font-size: 1rem; background-color: #28a745; color: white; border-radius: 5px; text-decoration: none;">
                Gérer les Articles
            </a>
        </div>



    </body>
</html>