<?php
    function AddToCart($articleId) {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

        if (!isset($_SESSION['name'])) {
            return false;
        }

        $userId = getIDOfUser($_SESSION['name']);
        $stmt = $mysqlClient->prepare(
            'INSERT INTO Cart (user_id, article_id) VALUES (?, ?)'
        );

        $success = $stmt->execute([$userId, $articleId]);
        
        if ($success) {
            return true;
        } else {
            return false;
        }

        $mysqlClient = null;
    }

    function GetCart() {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

        if (!isset($_SESSION['name'])) {
            return [];
        }

        $userId = getIDOfUser($_SESSION['name']);
        $stmt = $mysqlClient->prepare(
            'SELECT * FROM Cart WHERE user_id = ?'
        );
        $stmt->execute([$userId]);
        
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $cartItems;
    }
?>