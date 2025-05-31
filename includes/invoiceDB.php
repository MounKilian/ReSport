<?php   
require_once 'db.php';

function AddInvoice($userId, $totalPrice, $billingAddress, $billingCity, $billingPostalCode) {
    $mysqlClient = getPDOConnection();

    $stmt = $mysqlClient->prepare(
        'INSERT INTO Invoice (user_id, transaction_date, amount, billing_address, billing_city, billing_postal_code) VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$userId, date('Y-m-d H:i:s'), $totalPrice, $billingAddress, $billingCity, $billingPostalCode]);

    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }

    $mysqlClient = null;
}
?>