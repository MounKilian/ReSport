<?php
    
    function GetStock($articleId) {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

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