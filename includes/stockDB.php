<?php
    require_once 'db.php';
    
    function GetStock($articleId) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare('SELECT * FROM Stock WHERE article_id = ?');
        $stmt->execute([$articleId]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            return $article['quantity'];
        } else {
            return 0; 
        }
    }

    function quantityValid($articleId, $quantity) {
        $stock = GetStock($articleId);
        if ($stock >= $quantity) {
            return true;
        } else {
            return false;
        }
    }

    function RemoveStock($articleId) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare('UPDATE Stock SET quantity = quantity - 1 WHERE article_id = ?');
        $stmt->execute([$articleId]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function AddStock($articleId, $quantity) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare('UPDATE Stock SET quantity = quantity + ? WHERE article_id = ?');
        $stmt->execute([$quantity, $articleId]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
?>