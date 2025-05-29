<?php
    session_start();
    require_once '../includes/cartDB.php';
    require_once '../includes/articleDB.php';
    require_once '../includes/stockDB.php';
    require_once '../includes/loginDB.php';

    $data = getAll();

    $currentUserId = null;
    if ($data && isset($data['user']['id'])) {
        $currentUserId = $data['user']['id'];
    }

    $error = null; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (quantityValid($_POST['article_id'] , $_POST['quantity']) == false) {
            $error = "Pas assez d'articles."; 
        } else { 
            $result = AddToCart($_POST['article_id'], $_POST['quantity']);
    
            if ($result === true) {
                header('Location: ../index.php');
                exit;
            } else {
                $error = "Erreur lors de l'ajout au panier."; 
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/details.css">
    <title>ReSport - Detail Article</title>
</head>

<body>
    <section class="featured-products">
        <h2>Détails de l'article</h2>

        <?php if ($error): ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>

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

                    $pseudoVendeur = GetUsernameWithAuthorId($article['author_id']);

                    if ($currentUserId == $article['author_id']) {
                        echo '<p>Vendeur: <a href="accountPage.php?id=' . $article['author_id'] . '">' . $pseudoVendeur . ' (vous)</a></p>';
                    } else {
                        echo '<p>Vendeur: <a href="accountPage.php?id=' . $article['author_id'] . '">' . $pseudoVendeur . '</a></p>';
                    }
                    // echo '<p>Vendeur: <a href="accountPage.php">' . GetUsernameWithAuthorId($article['author_id']) . '</a></p>';
        
                    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                        echo '<form action="" method="POST">';
                        echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
                        echo '<p>Quantité: <input type="number" name="quantity" value="1" min="1"></p>';

                        echo '<p>Stock disponible: ' . GetStock($article['id']) . '</p>';

                        echo '<button type="submit">Ajouter au panier</button>';
                        echo '</form>';
                    } else {
                        echo '<p><a href="./loginPage.php">Connectez-vous</a> pour ajouter cet article au panier.</p>';
                    }
                    echo '</div>';
                }
            }
        ?>
    </section>
</body>