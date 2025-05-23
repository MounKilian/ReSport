<?php
    require_once '../includes/authentificationDB.php';

    function AddArticles($name, $description, $price, $image) {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

        $stmt = $mysqlClient->prepare(
            'INSERT INTO Article (name, description, price, publish_date, author_id, image_link) VALUES (?, ?, ?, ?, ? , ?)'
        );
        //mettre la bonne date
        $stmt->execute([$name, $description, $price, date('Y-m-d H:i:s'), getIDOfUser($_SESSION['name']), $image]);

        $stmt = $mysqlClient->prepare(
            'SELECT * FROM Article WHERE name = ? AND description = ? AND price = ? AND image_link = ?'
        );

        $stmt->execute([$name, $description, $price, $image]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($article) {
            return true;
        } else {
            return false;
        }

        $mysqlClient = null;
    }
?>