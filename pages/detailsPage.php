<?php
    session_start();
    require_once '../includes/cartDB.php';
    require_once '../includes/articleDB.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = AddToCart($_POST['article_id']);

        if ($result === true) {
            header('Location: ../index.php');
            exit;
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect."; 
        }
    }
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
        
                    if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
                        echo '<form action="" method="POST">';
                        echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
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