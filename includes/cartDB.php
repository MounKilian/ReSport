<?php
    require_once 'db.php';
    
    function AddToCart($articleId, $quantity) {
        $mysqlClient = getPDOConnection();

        if (!isset($_SESSION['name'])) {
            return false;
        }

        $stmt = $mysqlClient->prepare(
            'SELECT * FROM Article WHERE id = ?'
        );
        $stmt->execute([$articleId]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        for ($i = 0; $i < $quantity; $i++) {
            $userId = getIDOfUser($_SESSION['name']);
            $stmt = $mysqlClient->prepare(
                'INSERT INTO Cart (user_id, article_id) VALUES (?, ?)'
            );

            $success = $stmt->execute([$userId, $articleId]);

            if (!$success) {
                return false;
            }
        }

        $mysqlClient = null;

        return true;  
    }

    function GetCart() {
        $mysqlClient = getPDOConnection();

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