<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ReSport - Paiement</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/payment.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <main>
        <form method="POST" action="">
            <h2>Paiement sécurisé</h2>

            <label>Nom sur la carte :</label><br>
            <input type="text" name="card_name" required><br><br>

            <label>Numéro de carte :</label><br>
            <input type="tel" name="card_number" inputmode="numeric" pattern="[0-9]{16}" maxlength="16" required placeholder="16 chiffres" oninput="this.value = this.value.replace(/[^0-9]/g, '')"><br><br>

            <label>Date d'expiration :</label><br>
            <input type="tel" name="expiry_date" inputmode="numeric" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" placeholder="MM/AA" maxlength="5" required oninput="this.value = this.value.replace(/[^0-9\/]/g, '').slice(0, 5)"><br><br>

            <label>Cryptogramme (CVV) :</label><br>
            <input type="tel" name="cvv" inputmode="numeric" pattern="[0-9]{3,4}" maxlength="4" minlength="3" required placeholder="3 ou 4 chiffres" oninput="this.value = this.value.replace(/[^0-9]/g, '')"><br><br>

            <label>Montant à payer (€) :</label><br>
            <input type="number" name="addAmount" value="10.00" min="1" step="1.00" required><br><br>

            <button type="submit" name="payer">Payer</button>
        </form>

        <?php
        require_once '../includes/db.php';

        if (isset($_POST['payer']) && isset($_SESSION['name'])) {
            $addAmount = $_POST['addAmount'];
            $currentUsername = $_SESSION['name'];

            try {
                $pdo = getPDOConnection();

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
    </main>

</body>
</html>
