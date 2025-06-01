<?php
    require_once 'authentificationDB.php';
    require_once 'db.php';

    function AddArticles($name, $description, $price, $image, $quantity) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'INSERT INTO Article (name, description, price, publish_date, author_id, image_link) VALUES (?, ?, ?, ?, ? , ?)'
        );
        $stmt->execute([$name, $description, $price, date('Y-m-d H:i:s') , getIDOfUser($_SESSION['name']), $image]);

        $stmt = $mysqlClient->prepare(
            'SELECT * FROM Article WHERE name = ? AND description = ? AND price = ? AND image_link = ?'
        );

        $stmt->execute([$name, $description, $price, $image]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $mysqlClient->prepare(
            'INSERT INTO Stock (article_id, quantity) VALUES (?, ?)'
        );
        $stmt->execute([$article['id'], $quantity]);

        if ($article) {
            return true;
        } else {
            return false;
        }

        $mysqlClient = null;
    }

    function GetArticles() {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'SELECT * FROM Article ORDER BY publish_date DESC'
        );
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $articles;
    }

    function GetArticleById($id) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'SELECT * FROM Article WHERE id = ?'
        );
        $stmt->execute([$id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);

        return $article;
    }

    function GetUsernameWithAuthorId($author_id) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'SELECT username FROM User WHERE id = ?'
        );
        $stmt->execute([$author_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user['username'];
    }

    function UpdateArticle($id, $name, $description, $price, $image, $quantity) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'UPDATE Article SET name = ?, description = ?, price = ?, image_link = ? WHERE id = ?'
        );
        $stmt->execute([$name, $description, $price, $image, $id]);

        $stmt = $mysqlClient->prepare(
            'SELECT quantity FROM Stock WHERE article_id = ?'
        );
        $stmt->execute([$id]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentQuantity = $stock['quantity'];
        if ($currentQuantity != $quantity) {
            $stmt = $mysqlClient->prepare(
                'UPDATE Stock SET quantity = ? WHERE article_id = ?'
            );
            $stmt->execute([$quantity, $id]);
        }

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function DeleteArticle($id) {
        $mysqlClient = getPDOConnection();

        $stmt = $mysqlClient->prepare(
            'DELETE FROM Article WHERE id = ?'
        );
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
?>