<?php
session_start();
require_once '../includes/loginDB.php';
require_once '../includes/userDB.php'; // Crée un fichier userDB.php si besoin

// Vérifie si l'utilisateur est admin
if (!isset($_SESSION['name'])) {
    header("Location: ./loginPage.php");
    exit();
}

$user = getName();
if (!$user || $user['role'] !== 'admin') {
    echo "Accès refusé.";
    exit();
}

$users = getAllUsers(); // Fonction à créer dans userDB.php
?>
<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
<script>
    alert("L'utilisateur a bien été supprimé.");
</script>
<?php endif; ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Utilisateurs</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/account.css">
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>
    <?php include '../templates/header.php'; ?>

    <h2 style="text-align:center;">Gestion des Utilisateurs</h2>

    <div class="admin-actions" style="display: flex; gap: 1rem; padding: 1rem;">
        <a href="./adminArticlesPage.php" class="cta-button" style="padding: 0.5rem 1rem; font-size: 1rem; background-color: #28a745; color: white; border-radius: 5px; text-decoration: none;">
            Gérer les Articles
        </a>
    </div>
    
    <?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
        <p style="color: green; text-align: center;">Utilisateur supprimé avec succès.</p>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom d'utilisateur</th>
                <th>Email</th>
                <th>Solde (€)</th>
                <th>Photo de profil</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['id']) ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= htmlspecialchars($u['balance']) ?> €</td>
                    <td>
                        <?php if (!empty($u['profile_photo'])): ?>
                            <img src="../images/<?= htmlspecialchars($u['profile_photo']) ?>" alt="Photo">
                        <?php else: ?>
                            Aucune photo
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($u['role']) ?></td>
                    <td>
                        <a class="btn edit-btn" href="./editUserPage.php?id=<?= $u['id'] ?>">Modifier</a>
                        <a class="btn delete-btn" href="./deleteUser.php?id=<?= $u['id'] ?>" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
