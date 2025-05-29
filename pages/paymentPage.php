<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ReSport - Paiement</title>
</head>
<body>

    <form method="POST" action="">
        <h2>Paiement sécurisé</h2>

        <label>Nom sur la carte :</label><br>
        <input type="text" name="card_name" required><br><br>

        <label>Numéro de carte :</label><br>
        <input type="text" name="card_number" maxlength="16" required><br><br>

        <label>Date d'expiration :</label><br>
        <input type="text" name="expiry_date" placeholder="MM/AA" required><br><br>

        <label>Cryptogramme (CVV) :</label><br>
        <input type="text" name="cvv" maxlength="4" required><br><br>

        <label>Montant à payer (€) :</label><br>
        <input type="number" name="addAmount" value="10.00" step="1.00" required><br><br>

        <button type="submit" name="payer">Payer</button>
    </form>

    <?php
    if (isset($_POST['payer']) && isset($_SESSION['name'])) {
        $addAmount = $_POST['addAmount'];
        $currentUsername = $_SESSION['name'];

        try {
            $pdo = new PDO('mysql:host=localhost;dbname=resport;charset=utf8', 'root', '');

            $sql = "UPDATE user SET balance = balance + :addAmount WHERE username = :currentUsername";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                'addAmount' => $addAmount,
                'currentUsername' => $currentUsername
            ]);

                header("Location: acceptPage.php");
                exit();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
    ?>

</body>
</html>
