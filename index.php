<?php
    session_start();
    $_SESSION['name'] = 'Kilian';
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
        <h2>Revend tes équipements sportifs facilement</h2>
        <p>Achète ou vends des articles de sport d'occasion en toute confiance.</p>
        <a href="#" class="cta-button">Découvrir les produits</a>
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
