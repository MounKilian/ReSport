<?php
    session_start();

    require_once '../includes/loginDB.php';
    require_once '../includes/authentificationDB.php';
    require_once '../includes/invoiceDB.php';
    require_once '../includes/cartDB.php';

    $user = getUserById(getIDOfUser($_SESSION['name']));

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payer'])) {
        $address = $_POST['billing_address'] ?? '';
        $city = $_POST['billing_city'] ?? '';
        $postalCode = $_POST['billing_postal_code'] ?? '';
        AddInvoice(getIDOfUser($_SESSION['name']), GetTotalPrice(), $address, $city, $postalCode);
        RemoveUserBalance(getIDOfUser($_SESSION['name']), GetTotalPrice());
        RemoveCart();
        header("Location: acceptPage.php");
    }
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
            <h2>Adresse de facturation</h2>

            <label>Adresse de facturation:</label><br>
            <input type="text" name="billing_address" required><br><br>

            <label>Ville :</label><br>
            <input type="text" name="billing_city" required><br><br>

            <label>Code Postal :</label><br>
            <input type="text" name="billing_postal_code" required><br><br>

            <label>Total de la commande (€) :</label>
            <?php
                echo '<label>' . GetTotalPrice() . ' €</label><br><br>';
                echo '<label>Solde actuel :</label>';
                echo '<label>' . $user['balance'] . ' €</label><br><br>';
                echo '<label> Solde après paiement :</label>';
                echo '<label>' . ($user['balance'] - GetTotalPrice()) . ' €</label><br><br>';
            ?>

            <button type="submit" name="payer">Payer</button>
        </form>
    </main>
</body>
</html>
