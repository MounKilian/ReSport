<?php
session_start();
require_once '../includes/cartDB.php';
require_once '../includes/articleDB.php';
require_once '../includes/stockDB.php';
require_once '../includes/loginDB.php';
require_once '../includes/authentificationDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['article_id']) && isset($_POST['action'])) {
        $articleId = $_POST['article_id'];
        $action = $_POST['action'];

        switch ($action) {
            case 'increase':
                if (GetStock($articleId) <= 0) {
                    echo "<script>alert('Stock épuisé pour cet article.');</script>";
                    return;
                }
                $quantity = $_POST['quantity'] + 1;
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
            if (UpdateCart($articleId, $quantity, $action)) {
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
    <title>ReSport - Panier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/cart.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
<?php include '../templates/header.php'; ?>

<section class="featured-products">
    <?php
    $cart = GetCart();
    $articlesAlreadyInCart = [];

    if (isset($_SESSION['name'])) {
        $user = getUserById(getIDOfUser($_SESSION['name']));
    } else {
        echo '<h2>Veuillez vous connecter pour voir votre panier.</h2>';
        echo '<p><a href="./loginPage.php">Se connecter</a></p>';
        exit;
    }

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
        if (!$article || in_array($article['id'], $articlesAlreadyInCart)) continue;

        echo '<div class="product-item">';
        echo '<img src="../images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';

        echo '<div class="product-info">';
        echo '<h3>' . $article['name'] . '</h3>';
        echo '<p>Prix : ' . $article['price'] . ' €</p>';
        echo '<p>Stock disponible : ' . GetStock($article['id']) . '</p>';

        echo '<div class="quantity-controls">';
        echo '<form method="POST">';
        echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
        echo '<input type="hidden" name="quantity" value="' . $quantity . '">';
        echo '<input type="hidden" name="action" value="decrease">';
        echo '<button type="submit" class="update-button">-</button>';
        echo '</form>';

        echo '<label>' . $quantity . '</label>';

        echo '<form method="POST">';
        echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
        echo '<input type="hidden" name="quantity" value="' . $quantity . '">';
        echo '<input type="hidden" name="action" value="increase">';
        echo '<button type="submit" class="update-button">+</button>';
        echo '</form>';
        echo '</div>'; 

        echo '<form method="POST">';
        echo '<input type="hidden" name="article_id" value="' . $article['id'] . '">';
        echo '<input type="hidden" name="action" value="remove">';
        echo '<button type="submit" class="remove-button">Supprimer</button>';
        echo '</form>';

        echo '</div>'; 
        echo '</div>'; 

        $articlesAlreadyInCart[] = $article['id'];
    }

    echo '<div class="summary">';
    echo '<p>Total : ' . GetTotalPrice() . ' €</p>';
    echo '<p>Votre solde : ' . $user['user']['balance'] . ' €</p>';
    echo '</div>';

    echo '<form action="./checkoutPage.php" method="POST">';
    $disabled = ($user['user']['balance'] < GetTotalPrice()) ? 'disabled' : '';
    $buttonText = ($disabled) ? 'Passer la commande (Solde insuffisant)' : 'Passer la commande';
    echo '<button type="submit" class="checkout-button" ' . $disabled . '>' . $buttonText . '</button>';
    echo '</form>';
    ?>
</section>
</body>
</html>
