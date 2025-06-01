<?php
    include_once __DIR__ . '/../includes/loginDB.php';
    $user = getName();

    $userId = null;
    $userRole = null;

    if ($user) {
        $userId = $user['id'];
        $userRole = $user['role'];
    } else {
        $userId = null;
    }
?>

<header>
    <div class="logo">
        <a href="../index.php"><h1>ReSport</h1></a>
    </div>
    <nav>
        <ul>
           <li><a href="./sellPage.php">Vendre</a></li>
            <li><a href="#">Produits</a></li>
            <li><a href="#">Catégories</a></li>
            <li><a href="./cartPage.php">Panier</a></li>
            
            <?php if (isset($_SESSION['name']) && $_SESSION['name'] != '') { ?>
                <li><a href="./accountPage.php?id=<?= htmlspecialchars($userId) ?>">Mon compte</a></li>
                
                <?php if ($userRole === 'admin') { ?>
                    <li><a href="./adminPage.php" class="admin-button">Admin</a></li>
                <?php } ?>

                <li>
                    <form action="/ReSport/index.php" method="get" style="display:inline;">
                        <button type="submit" name="logout" value="1" class="cta-button" style="padding: 0.5rem 1rem; font-size: 1rem;">Déconnexion</button>
                    </form>
                </li>
            <?php } else { ?>
                <li><a href="./registerPage.php">Connexion</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>