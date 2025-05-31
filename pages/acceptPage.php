<?php
    session_start();

    require_once '../includes/authentificationDB.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/accept.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>ReSport - Accept</title>
</head>

<body>
    <?php include '../templates/header.php'; ?>

    <div class="container">
        <div>Paiement effectué avec succès ! Merci pour votre commande.</div>
        <a href="../index.php"><button>Retourner à l'accueil</button></a>
        <?php
            echo '<a href="accountPage.php?id=' . getIDOfUser($_SESSION['name']) . '"><button>Retourner à ton compte</button></a>';
        ?>
    </div>
</body>
</html>
