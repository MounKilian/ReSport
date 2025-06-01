<?php
    session_start();

    if (!isset($_SESSION['name']) || empty($_SESSION['name'])) {
        header('Location: ./loginPage.php');
        exit;
    }

    require_once '../includes/articleDB.php';
    require_once '../includes/stockDB.php';

    $articleId = $_GET['id'];
    $article = GetArticleById($articleId);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
        $target_dir = "../images/";
        $imagePath = $article['image_link'];

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == UPLOAD_ERR_OK) {
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $imagePath = basename($_FILES["image"]["name"]);
            } else {
                echo "<script>alert('Erreur lors du téléchargement de l\'image.');</script>";
            }
        }

        $result = UpdateArticle($articleId, $_POST['name'], $_POST['description'], $_POST['price'], $imagePath, $_POST['quantity']);

        if ($result == true) {
            header('Location: ../index.php');
            exit;
        } else {
            echo "<script>alert('Erreur lors de la modification de l\'article.');</script>";
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
        $result = DeleteArticle($articleId);

        if ($result == true) {
            header('Location: ../index.php');
            exit;
        } else {
            echo "<script>alert('Erreur lors de la suppression de l\'article.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une annonce</title>
    <link rel="stylesheet" href="../css/annonce.css">
    <link rel="stylesheet" href="../css/header.css"> 
</head>
<body>
    <?php include '../templates/header.php'; ?>

    <div class="body">
        <h1>Modifier l'annonce</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Nom de l'article :</label>
            <input type="text" id="name" name="name" value=<?= htmlspecialchars($article["name"]) ?> required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($article["description"]) ?></textarea>

            <label for="price">Prix :</label>
            <input type="number" id="price" name="price" step="0.01" value=<?= htmlspecialchars($article["price"]) ?> required>

            <label for="image">Image actuelle :</label>
            <img src="../images/<?= htmlspecialchars($article['image_link']) ?>" alt="Image de l'article" width="150">
            <input type="file" id="image" name="image" accept="image/*">


            <label for="quantity">Quantité :</label>
            <input type="number" id="quantity" name="quantity" value=<?= htmlspecialchars(GetStock($article['id'])) ?> min="1">

            <button type="submit" name="modifier">Modifier l'annonce</button>
            <button type="submit" name="supprimer">Supprimer l'annonce</button>
        </form>
    </div>
</body>
</html>