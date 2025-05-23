<?php
    session_start();
    require_once '../includes/articleDB.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReSport - Detail Article</title>
</head>

<body>
    <section class="featured-products">
        <?php
            $articles = GetArticles();
            foreach ($articles as $article) {
                if ($article['id'] == $_GET['id']) {
                    echo '<div class="product-item">';
                    echo '<img src="../images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';
                    echo '<p>Prix: ' . $article['price'] . ' €</p>';
                    echo '<h3>' . $article['name'] . '</h3>';
                    echo '<p>' . $article['description'] . '</p>';
                    echo '<p>Date: ' . $article['publish_date'] . '</p>';
                    echo '<p>Vendeur: ' . GetUsernameWithAuthorId($article['author_id']) . '</p>';
                    echo '</div>';
                }
            }
        ?>
    </section>
</body>