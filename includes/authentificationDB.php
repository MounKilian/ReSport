<?php
    require_once 'db.php';

    function Register($username, $email, $password) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare('SELECT * FROM User WHERE username = ? OR email = ?');
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            return "Nom d'utilisateur ou email déjà utilisé.";
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $mysqlClient->prepare(
            'INSERT INTO User (username, email, password, profile_photo, role) VALUES (?, ?, ?, ?, ?)'
        );
        $success = $stmt->execute([$username, $email, $hashedPassword, 'A4 - 6.png', 'client']);

        if ($success) {
            return true;
        } else {
            return "Erreur lors de l'inscription.";
        }
    }

    function Login($username, $password) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare('SELECT * FROM User WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        } else {
            return false;
        }
    }

    function getIDOfUser($username) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'SELECT id FROM User WHERE username = ?'
        );
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user['id'];
        } else {
            return false;
        }
    }

    function RemoveUserBalance($userId, $amount) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'UPDATE User SET balance = balance - ? WHERE id = ?'
        );
        $stmt->execute([$amount, $userId]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
?>