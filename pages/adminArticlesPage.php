<?php
session_start();
require_once '../includes/loginDB.php';
require_once '../includes/articleDB.php';

if (!isset($_SESSION['name'])) {
    header("Location: ./loginPage.php");
    exit();
}

$user = getName();
if (!$user || $user['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}

$articles = GetArticles(); 
?>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
<script>
    alert("L'article a bien été supprimé.");
</script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Articles</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/admin.css">


</head>
<body>
    <?php include '../templates/header.php'; ?>

    <h2 style="text-align:center;">Gestion des Articles</h2>
            <div class="admin-actions" style="display: flex; gap: 1rem; padding: 1rem;">
                <a href="./adminUsersPage.php" class="cta-button" style="padding: 0.5rem 1rem; font-size: 1rem; background-color: #007bff; color: white; border-radius: 5px; text-decoration: none;">
                    Gérer les Utilisateurs
                </a>
            </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix (€)</th>
                <th>Date de publication</th>
                <th>ID Auteur</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= htmlspecialchars($article['id']) ?></td>
                    <td><?= htmlspecialchars($article['name']) ?></td>
                    <td><?= htmlspecialchars($article['description']) ?></td>
                    <td><?= htmlspecialchars($article['price']) ?></td>
                    <td><?= htmlspecialchars($article['publish_date']) ?></td>
                    <td><?= htmlspecialchars($article['author_name']) ?></td>
                    <td>
                        <?php if (!empty($article['image_link'])): ?>
                            <img src="../images/<?= htmlspecialchars($article['image_link']) ?>" alt="img">
                        <?php else: ?>
                            Aucun visuel
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn edit-btn" href="./editPage.php?id=<?= $article['id'] ?>">Modifier</a>
                        <a class="btn delete-btn" href="./deleteArticle.php?id=<?= $article['id'] ?>" onclick="return confirm('Supprimer cet article ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
