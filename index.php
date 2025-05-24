<?php
    session_start();
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
    //$_SESSION['name'] = '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReSport - Accueil</title>
    <link rel="stylesheet" href="css/accueil.css">
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
        <div class="products-grid">
            <div class="product-card">
                <h3>Ballon de football Adidas</h3>
                <p>25€</p>
                <a href="#">Voir</a>
            </div>
            <div class="product-card">
                <h3>Raquette Babolat</h3>
                <p>45€</p>
                <a href="#">Voir</a>
            </div>
            <div class="product-card">
                <h3>Gants de boxe Everlast</h3>
                <p>30€</p>
                <a href="#">Voir</a>
            </div>
        </div>
    </section>

    <?php include 'templates/footer.php'; ?>
</body>
</html>