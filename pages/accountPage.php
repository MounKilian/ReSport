<?php
    session_start();

    include '../includes/loginDB.php';
    $data = getAll();

    $currentUserId = null;
    if ($data && isset($data['user']['id'])) {
        $currentUserId = $data['user']['id'];
    }

    if (!isset($_GET['id'])) {
        echo "Aucun ID fourni.";
        exit;
    }

    $requestedId = intval($_GET['id']); 

    $dataOther = getUserById($requestedId);
    if (!$dataOther) {
        echo "Utilisateur introuvable.";
        exit;
    }

    $user = $data['user'];
    $articles = $data['articles'];
    $invoices = $data['invoices'];

    $userOther = $dataOther['user'];
    $articlesOther = $dataOther['articles'];
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

    <?php if ($currentUserId === $requestedId) { ?>
        <body>    
            <?php include '../templates/header.php'; ?>

            <div class="body">
            <h3>Compte</h3>
            <img src="../images/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Photo de profil" ><br>';
            
            <div class="profile-info">
                <div>Nom d'utilisateur :</div>
                <div><?= htmlspecialchars($user['username']) ?></div>

                <div>Email :</div>
                <div><?= htmlspecialchars($user['email']) ?></div>

                <div>Solde :</div>
                <div>
                    <?= htmlspecialchars($user['balance']) ?> €
                    <a href="paymentPage.php" class="balance-button">Ajouter de l'argent</a>
                </div>
            </div>

            <form method="POST" action="">
                <label>Nouvel email :</label><br>
                <input type="email" name="new_email" placeholder="Laissez vide pour ne pas modifier"><br><br>

                <label>Nouveau mot de passe :</label><br>
                <input type="password" name="new_password" placeholder="Laissez vide pour ne pas modifier"><br><br>

                <button type="submit" name="modifier">Modifier</button>
            </form>

            
            <?php

            if (isset($_POST['modifier']) && isset($_SESSION['name'])) {
                $newEmail = $_POST['new_email'];
                $newPassword = $_POST['new_password'];
                $currentUsername = $_SESSION['name'];

                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=resport;charset=utf8', 'root', '');

                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $sql = "UPDATE user SET email = :newEmail, password = :newPassword WHERE username = :currentUsername";
                    $stmt = $pdo->prepare($sql);

                    $stmt->execute([
                        'newEmail' => $newEmail,
                        'newPassword' => $hashedPassword,
                        'currentUsername' => $currentUsername
                    ]);

                    header("Location: accountPage.php?id=" . $user['id']);
                    exit();
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }

            }
            ?>

            <section class="featured-products">
                <h3>Mes articles</h3>
                <div class="products-grid">
                    <?php
                        foreach ($articles as $article) {
                            echo '<div class="product-card">';
                            echo '<img src="../images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';
                            echo '<p>' . $article['price'] . ' €</p>';
                            echo '<h3>' . $article['name'] . '</h3>';
                            echo '<a href="./detailsPage.php?id=' . $article['id'] . '" class="cta-button">Voir les détails</a>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </section>

            <section class="featured-products">
                <h3>Mes factures</h3>
                <?php foreach ($invoices as $invoice): ?>
                    <div>Date d'achat :</div><div><?= htmlspecialchars($invoice['transaction_date']) ?></div>
                    <div>Montant :</div><div><?= htmlspecialchars($invoice['amount']) ?> €</div>
                    <div>Adresse :</div><div><?= htmlspecialchars($invoice['billing_address']) ?></div>
                    <div>Ville :</div><div><?= htmlspecialchars($invoice['billing_city']) ?></div>
                    <div>Code postal :</div><div><?= htmlspecialchars($invoice['billing_postal_code']) ?></div>
                    <hr>
                <?php endforeach; ?>
            </section>
            </div>
        </body>

    </html>


<?php } else { ?>
    <body>   
        <?php include '../templates/header.php'; ?>
        <div class="body">
        <h3>Compte</h3>
        <img src="../images/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Photo de profil" ><br>';
       
        <div class="profile-info">
                <div>Nom d'utilisateur :</div>
                <div><?= htmlspecialchars($userOther['username']) ?></div>

                <div>Email :</div>
                <div><?= htmlspecialchars($userOther['email']) ?></div>
        </div>

        <section class="featured-products">
            <h3>Les articles de <?= htmlspecialchars($userOther['username']) ?></h3>
            <div class="products-grid">
                <?php
                    foreach ($articlesOther as $articleOther) {
                        echo '<div class="product-card">';
                        echo '<img src="../images/' . $articleOther['image_link'] . '" alt="' . $articleOther['name'] . '">';
                        echo '<p>' . $articleOther['price'] . ' €</p>';
                        echo '<h3>' . $articleOther['name'] . '</h3>';
                        echo '<a href="./detailsPage.php?id=' . $articleOther['id'] . '" class="cta-button">Voir les détails</a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </section>
        </div>
    </body>
<?php } ?>

