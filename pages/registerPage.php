<?php
    session_start();
    require_once '../includes/authentificationDB.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = Register(
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
        );
        $_SESSION['name'] = $_POST['username'];
        header('Location: ../index.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ReSport - Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="register">
        <h2>Créer un compte</h2>

        <form action="" method="POST">
            <label for="username">Nom d'utilisateur</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Adresse email</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Mot de passe</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <label for="confirm_password">Confirmer le mot de passe</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <button type="submit">S'inscrire</button>
        </form>
    </section>
</body>
</html>