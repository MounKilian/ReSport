<?php
    session_start();
      if (!isset($_SESSION['name']) || empty($_SESSION['name'])) {
        header('Location: ./loginPage.php');
        exit;
    }
    require_once '../includes/articleDB.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $result = AddArticles( $_POST['name'], $_POST['description'], $_POST['price'], $_POST['image']);

        if ($result == true) {
            header('Location: ../index.php');
        } else if ($result == false) {
            echo "<script>alert('Erreur lors de l\'ajout de l\'article.');</script>";
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
</head>
<body>
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

        <button type="submit">Ajouter l'annonce</button>
    </form>
</body>
</html>