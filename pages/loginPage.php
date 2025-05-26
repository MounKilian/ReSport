<?php
    session_start();
    require_once '../includes/authentificationDB.php';

    $error = null; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = Login($_POST['username'], $_POST['password']);

        if ($result === true) {
            $_SESSION['name'] = $_POST['username'];
            header('Location: ../index.php');
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect."; 
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ReSport - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/auth.css">
<body>
    <section class="register">
        <h2>Se Connecter</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="username">Nom d'utilisateur</label><br>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Mot de passe</label><br>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Se connecter</button>
        </form>

        <p>Pas encore de compte ? <a href="./registerPage.php">Inscrivez-vous</a></p>
    </section>
</body>
</html>