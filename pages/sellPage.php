<?php
    session_start();
    require_once '../includes/articleDB.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target_dir = "../images/";
    
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $imagePath = basename($_FILES["image"]["name"]); 
    
            $result = AddArticles($_POST['name'], $_POST['description'], $_POST['price'], $imagePath);
    
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
</head>
<body>
    <h1>Ajouter une annonce</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Nom de l'article :</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Description :</label><br>
        <textarea id="description" name="description" rows="4" required></textarea><br><br>

        <label for="price">Prix :</label><br>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <label for="image">Lien de l'image :</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <button type="submit">Ajouter l'annonce</button>
    </form>
</body>
</html>