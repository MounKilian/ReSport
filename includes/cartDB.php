<?php
    require_once 'db.php';
    require_once 'stockDB.php';
    
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

            RemoveStock($articleId);

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

    function GetQuantityInCart($articleId) {
        $mysqlClient = getPDOConnection();

        if (!isset($_SESSION['name'])) {
            return 0;
        }

        $userId = getIDOfUser($_SESSION['name']);
        $stmt = $mysqlClient->prepare(
            'SELECT COUNT(*) as quantity FROM Cart WHERE user_id = ? AND article_id = ?'
        );
        $stmt->execute([$userId, $articleId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['quantity'];
    }

    function GetTotalPrice() {
        $mysqlClient = getPDOConnection();

        if (!isset($_SESSION['name'])) {
            return 0;
        }

        $userId = getIDOfUser($_SESSION['name']);
        $stmt = $mysqlClient->prepare(
            'SELECT SUM(a.price) as total FROM Cart c JOIN Article a ON c.article_id = a.id WHERE c.user_id = ?'
        );
        $stmt->execute([$userId]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total'] ?? 0;
    }

    function UpdateCart($articleId, $quantity, $type) {
        $mysqlClient = getPDOConnection();

        if (!isset($_SESSION['name'])) {
            return false;
        }

        $userId = getIDOfUser($_SESSION['name']);
        
        $stmt = $mysqlClient->prepare(
            'DELETE FROM Cart WHERE user_id = ? AND article_id = ?'
        );
        $stmt->execute([$userId, $articleId]);

        if ($type == "increase") {
            RemoveStock($articleId);
        } else if ($type == "decrease") {
            AddStock($articleId, 1);
        }

        for ($i = 0; $i < $quantity; $i++) {
            $stmt = $mysqlClient->prepare(
                'INSERT INTO Cart (user_id, article_id) VALUES (?, ?)'
            );
            $success = $stmt->execute([$userId, $articleId]);

            if (!$success) {
                return false;
            }
        }

        return true;
    }

    function RemoveFromCart($articleId) {
        AddStock($articleId, GetQuantityInCart($articleId));

        $mysqlClient = getPDOConnection();

        if (!isset($_SESSION['name'])) {
            return false;
        }

        $userId = getIDOfUser($_SESSION['name']);
        $stmt = $mysqlClient->prepare(
            'DELETE FROM Cart WHERE user_id = ? AND article_id = ?'
        );
        $success = $stmt->execute([$userId, $articleId]);

        return $success;
    }
?>