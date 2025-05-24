<?php
    session_start();
    require_once '../includes/authentificationDB.php';
    function passwordIsValid($password) {
        if (
            strlen($password) < 8 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password) ||
            !preg_match('/[\W_]/', $password)
        ) {
            return false;
        }
        return true;
    }

    $error = null; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['password'] !== $_POST['confirm_password']) {
            $error = "Les mots de passe ne correspondent pas.";
        }

        elseif (!passwordIsValid($_POST['password'])) {
            $error = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
        else {
            $result = Register($_POST['username'], $_POST['email'], $_POST['password']);

            if ($result === true) {
                $_SESSION['name'] = $_POST['username'];
                header('Location: ../index.php');
                exit;
            } else {
                $error = $result; 
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ReSport - Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/auth.css">
</head>
<body>
    <section class="register">
        <h2>Créer un compte</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="username">Nom d'utilisateur</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="email">Adresse email</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Mot de passe</label><br>
            <input type="password" id="password" name="password" required><br>
            <small>Au moins 8 caractères, une majuscule, une minuscule, un chiffre, un caractère spécial.</small><br><br>

            <label for="confirm_password">Confirmer le mot de passe</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br><br>

            <button type="submit">S'inscrire</button>
        </form>

        <p>Déjà un compte ? <a href="./loginPage.php">Connectez-vous</a></p>
    </section>
</body>
</html>