<?php
include '../includes/loginDB.php';
$data = getNameAndTime();
if (!$data) {
    echo "Utilisateur non connecté.";
    exit;
}
$user = $data['user'];
$articles = $data['articles'];
$invoices = $data['invoices'];
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ReSport - Compte</title>
    </head>
    <body>
        
        <h3>Compte</h3>
        <div>Photo :</div><div><?= htmlspecialchars($user['profile_photo']) ?></div>
        <div>Nom d'utilisateur :</div><div><?= htmlspecialchars($user['username']) ?></div>
        <div>Mot de passe :</div><div><?= htmlspecialchars($user['password']) ?></div>
        <div>Email :</div><div><?= htmlspecialchars($user['email']) ?></div>
        <div>Solde :</div><div><?= htmlspecialchars($user['balance']) ?> €<a href="paymentPage.php"><button>Ajouter de l'argent</button></a></div>

        <form method="POST" action="">
            <label>Nouvel email :</label><br>
            <input type="email" name="new_email" required><br><br>

            <label>Nouveau mot de passe :</label><br>
            <input type="password" name="new_password" required><br><br>

            <button type="submit" name="modifier">Modifier</button>
        </form>

        
        <?php
        session_start();

        if (isset($_POST['modifier']) && isset($_SESSION['name'])) {
            $newEmail = $_POST['new_email'];
            $newPassword = $_POST['new_password'];
            $currentUsername = $_SESSION['name'];

            try {
                $pdo = new PDO('mysql:host=localhost;dbname=resport;charset=utf8', 'root', '');

                $sql = "UPDATE user SET email = :newEmail, password = :newPassword WHERE username = :currentUsername";
                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    'newEmail' => $newEmail,
                    'newPassword' => $newPassword,
                    'currentUsername' => $currentUsername
                ]);

                echo "Email et mot de passe mis à jour avec succès !";

            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        }
        ?>


        <section>
            <h3>Articles :</h3>
            <?php foreach ($articles as $article): ?>
                <div>Nom :</div><div><?= htmlspecialchars($article['name']) ?></div>
                <div></div><div><?= htmlspecialchars($article['image_link']) ?></div>
                <div>Description :</div><div><?= htmlspecialchars($article['description']) ?></div>
                <div>Prix :</div><div><?= htmlspecialchars($article['price']) ?> €</div>
                <div>Date de publication :</div><div><?= htmlspecialchars($article['publish_date']) ?></div>
                <hr>
            <?php endforeach; ?>
        </section>

        <section>
            <h3>Factures :</h3>
            <?php foreach ($invoices as $invoice): ?>
                <div>Date d'achat :</div><div><?= htmlspecialchars($invoice['transaction_date']) ?></div>
                <div>Montant :</div><div><?= htmlspecialchars($invoice['amount']) ?> €</div>
                <div>Adresse :</div><div><?= htmlspecialchars($invoice['billing_address']) ?></div>
                <div>Ville :</div><div><?= htmlspecialchars($invoice['billing_city']) ?></div>
                <div>Code postal :</div><div><?= htmlspecialchars($invoice['billing_postal_code']) ?></div>
                <hr>
            <?php endforeach; ?>
        </section>
    </body>

</html>