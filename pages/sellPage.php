<?php
    session_start();

    if (!isset($_SESSION['name']) || empty($_SESSION['name'])) {
        header('Location: ./loginPage.php');
        exit;
    }
    require_once '../includes/articleDB.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target_dir = "../images/";
    
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imagePath = basename($_FILES["image"]["name"]); 
    
            $result = AddArticles($_POST['name'], $_POST['description'], $_POST['price'], $imagePath, $_POST['quantity']);
    
            if ($result == true) {
                header('Location: ../index.php');
                exit;
            } else {
                echo "<script>alert('Erreur lors de l\'ajout de l\'article.');</script>";
            }
        } else {
            echo "<script>alert('Erreur lors du téléchargement de l\'image.');</script>";
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
        <h1>Ajouter une annonce</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="name">Nom de l'article :</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="price">Prix :</label>
            <input type="number" id="price" name="price" step="0.01" required>

            <label for="image">Image :</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="quantity">Quantité :</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1">

            <button type="submit">Ajouter l'annonce</button>
        </form>
    </div>
</body>
</html>