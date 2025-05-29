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

?>