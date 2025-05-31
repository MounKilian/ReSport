<?php
    session_start();
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }

    require_once './includes/articleDB.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReSport - Accueil</title>
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <?php include 'templates/headerIndex.php'; ?>

    <section class="hero">
        <h2>Catégorie</h2>
        <p>Achète ou vends des articles de sport d'occasion en toute confiance.</p>
        <a href="#" class="cta-button">Catégories</a>
    </section>

    <section class="featured-products">
        <h2>Derniers articles publiés</h2>
        <div class="products-grid">
            <?php
                $articles = GetArticles();
                foreach ($articles as $article) {
                    echo '<div class="product-card">';
                    echo '<img src="images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';
                    echo '<p>' . $article['price'] . ' €</p>';
                    echo '<h3>' . $article['name'] . '</h3>';
                    echo '<a href="./pages/detailsPage.php?id=' . $article['id'] . '" class="cta-button">Voir les détails</a>';
                    echo '</div>';
                }
            ?>
        </div>
    </section>

    <?php include 'templates/footer.php'; ?>
</body>
</html>