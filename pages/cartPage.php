<?php
    session_start();
    require_once '../includes/cartDB.php';
    require_once '../includes/articleDB.php';
    require_once '../includes/stockDB.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['article_id']) && isset($_POST['action'])) {
            $articleId = $_POST['article_id'];
            $action = $_POST['action'];
    
            switch ($action) {
                case 'increase':
                    $quantity = min($_POST['quantity'] + 1, GetStock($articleId));
                    break;
    
                case 'decrease':
                    $quantity = max(1, $_POST['quantity'] - 1); 
                    break;
    
                case 'remove':
                    if (RemoveFromCart($articleId)) {
                        header('Location: ./cartPage.php');
                        exit;
                    } else {
                        echo "<script>alert('Erreur lors de la suppression du panier.');</script>";
                    }
                    return;
            }
    
            if ($action === 'increase' || $action === 'decrease') {
                if (UpdateCart($articleId, $quantity)) {
                    header('Location: ./cartPage.php');
                    exit;
                } else {
                    echo "<script>alert('Erreur lors de la mise à jour du panier.');</script>";
                }
            }
        }
    }
  
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/header.css">
    <title>ReSport - Panier</title>
</head>

<body>
    <?php include '../templates/header.php'; ?>

    <section class="featured-products">
        <?php
            $cart = GetCart();
            $artciclesAlreadyInCart = [];
            if (empty($cart)) {
                echo '<h2>Votre panier est vide.</h2>';
                echo '<p><a href="../index.php">Retour à l\'accueil</a></p>';
                exit;
            } else {
                echo '<h2>Articles dans votre panier</h2>';
            }
            foreach ($cart as $item) {
                $article = GetArticleById($item['article_id']);
                $quantity = GetQuantityInCart($item['article_id']);
                if ($article) {
                    foreach ($artciclesAlreadyInCart as $articlesInCart) {
                        if ($articlesInCart == $article['id']) {
                            continue 2; 
                        }
                    }
                    echo '<div class="product-item">';
                    echo '<img src="../images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';
                    echo '<p>Prix: ' . $article['price'] . ' €</p>';
                    echo '<h3>' . $article['name'] . '</h3>';
                    echo '<br>';

                    echo '<form action="" method="POST" style="display:inline;">';
                    echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
                    echo '<input type="hidden" name="quantity" value="' . $quantity . '">';
                    echo '<input type="hidden" name="action" value="decrease">';
                    echo '<button type="submit" class="update-button">-</button>';
                    echo '</form>';

                    echo '<label>' . $quantity . '</label>';

                    echo '<form action="" method="POST" style="display:inline;">';
                    echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
                    echo '<input type="hidden" name="quantity" value="' . $quantity . '">';
                    echo '<input type="hidden" name="action" value="increase">';
                    echo '<button type="submit" class="update-button">+</button>';
                    echo '</form>';
                    
                    echo '<p>Stock disponible: ' . GetStock($article['id']) . '</p>';

                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
                    echo '<input type="hidden" name="action" value="remove">';
                    echo '<button type="submit" class="remove-button">Supprimer</button>';
                    echo '</form>';

                    echo '</div>';

                }
                array_push($artciclesAlreadyInCart, $article['id']);
            }
            echo '<p> Total: ' . GetTotalPrice() . ' €</p>';
            echo '<form action="../pages/checkoutPage.php" method="POST">';
            echo '<button type="submit" class="checkout-button">Passer la commande</button>';
        ?>
    </section>
</body>