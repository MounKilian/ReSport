<?php
function getAll()
{

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

        $userStmt = $mysqlClient->prepare('SELECT * FROM `user` WHERE username = :name');
        $userStmt->execute(['name' => $name]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) return null;

        $userId = $user['id'];

        $articlesStmt = $mysqlClient->prepare('SELECT * FROM `article` WHERE author_id = :id');
        $articlesStmt->execute(['id' => $userId]);
        $articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);

        $invoicesStmt = $mysqlClient->prepare('SELECT * FROM `invoice` WHERE user_id = :id');
        $invoicesStmt->execute(['id' => $userId]);
        $invoices = $invoicesStmt->fetchAll(PDO::FETCH_ASSOC);

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

function getUserById($id) {
    try {
        $mysqlClient = new PDO('mysql:host=localhost;dbname=resport;charset=utf8', 'root', '');
        $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 1. Utilisateur
        $userStmt = $mysqlClient->prepare('SELECT * FROM `user` WHERE id = :id');
        $userStmt->execute(['id' => $id]);
        $user = $userStmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) return null;

        // 2. Articles
        $articlesStmt = $mysqlClient->prepare('SELECT * FROM `article` WHERE author_id = :id');
        $articlesStmt->execute(['id' => $id]);
        $articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);

        // 3. Invoices (facultatif si ce n'est pas le compte connecté)
        $invoicesStmt = $mysqlClient->prepare('SELECT * FROM `invoice` WHERE user_id = :id');
        $invoicesStmt->execute(['id' => $id]);
        $invoices = $invoicesStmt->fetchAll(PDO::FETCH_ASSOC);

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

function getName() {

    // Connexion à la BDD
    $pdo = new PDO('mysql:host=localhost;dbname=resport;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialisation
    $userId = null;
    $user = null;

    if (isset($_SESSION['name'])) {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE username = :username');
        $stmt->execute(['username' => $_SESSION['name']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $userId = $user['id'];
        }
    }

    return $user; // Retourne toutes les infos utilisateur (dont id)
}


?>
