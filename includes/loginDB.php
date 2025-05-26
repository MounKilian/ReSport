<?php
function getNameAndTime()
{
    session_start();

    if (!isset($_SESSION['name'])) {
        return null; // utilisateur non connecté
    }

    $name = $_SESSION['name'];

    try {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );
        $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 1. Récupérer l'utilisateur
        $userStmt = $mysqlClient->prepare('SELECT * FROM `user` WHERE username = :name');
        $userStmt->execute(['name' => $name]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return null;

        $userId = $user['id'];

        // 2. Récupérer les articles de cet utilisateur
        $articlesStmt = $mysqlClient->prepare('SELECT * FROM `article` WHERE author_id = :id');
        $articlesStmt->execute(['id' => $userId]);
        $articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);

        // 3. Récupérer les factures de cet utilisateur
        $invoicesStmt = $mysqlClient->prepare('SELECT * FROM `invoice` WHERE user_id = :id');
        $invoicesStmt->execute(['id' => $userId]);
        $invoices = $invoicesStmt->fetchAll(PDO::FETCH_ASSOC);

        // Retourne un tableau structuré
        return [
            'user' => $user,
            'articles' => $articles,
            'invoices' => $invoices
        ];

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }
}
?>
