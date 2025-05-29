<?php
    session_start();
    require_once '../includes/cartDB.php';
    require_once '../includes/articleDB.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cart.css">
    <title>ReSport - Panier</title>
</head>

<body>
    <section class="featured-products">
        <?php
            $cart = GetCart();
            foreach ($cart as $item) {
                $article = GetArticleById($item['article_id']);
                if ($article) {
                    echo '<div class="product-item">';
                    echo '<img src="../images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';
                    echo '<p>Prix: ' . $article['price'] . ' €</p>';
                    echo '<h3>' . $article['name'] . '</h3>';
                }
            }
        ?>
    </section>
</body>