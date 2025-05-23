<?php
    session_start();
    //$_SESSION['name'] = '';

    require_once './includes/articleDB.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReSport - Accueil</title>
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <section class="hero">
        <h2>Catégorie</h2>
        <p>Achète ou vends des articles de sport d'occasion en toute confiance.</p>
        <a href="#" class="cta-button">Catégories</a>
    </section>

    <section class="featured-products">
        <h2>Derniers articles publiés</h2>
        <div class="product-list">
            <?php
                $articles = GetArticles();
                foreach ($articles as $article) {
                    echo '<div class="product-item">';
                    echo '<img src="images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';
                    echo '<p>Prix: ' . $article['price'] . ' €</p>';
                    echo '<h3>' . $article['name'] . '</h3>';
                    echo '<a href="./pages/detailsPage.php?id='. $article['id'] . '" class="cta-button">Voir les détails</a>';
                    echo '</div>';
                }
            ?>
    </section>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
