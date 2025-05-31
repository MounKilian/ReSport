<?php
    require_once 'articleDB.php';
    require_once 'db.php';

    function getAll()
    {
        if (!isset($_SESSION['name'])) {
            return null; 
        }

        $name = $_SESSION['name'];

        try {
            $mysqlClient = getPDOConnection();
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
            $mysqlClient = getPDOConnection();
            $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $userStmt = $mysqlClient->prepare('SELECT * FROM `user` WHERE id = :id');
            $userStmt->execute(['id' => $id]);
            $user = $userStmt->fetch(PDO::FETCH_ASSOC);
            if (!$user) return null;

            $articlesStmt = $mysqlClient->prepare('SELECT * FROM `article` WHERE author_id = :id');
            $articlesStmt->execute(['id' => $id]);
            $articles = $articlesStmt->fetchAll(PDO::FETCH_ASSOC);

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

        $pdo = getPDOConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        return $user; 
    }
?>
