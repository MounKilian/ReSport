<header>
    <div class="logo">
        <h1>ReSport</h1>
    </div>
    <nav>
        <ul>
            <li><a href="./pages/sellPage.php">Vendre</a></li>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Produits</a></li>
            <li><a href="#">Catégories</a></li>
            <li><a href="#">Panier</a></li>
            <?php if (isset($_SESSION['name']) && $_SESSION['name'] != '') { ?>
                <li><a href="#">Mon compte</a></li>
            <?php } else { ?>
                <li><a href="./pages/registerPage.php">Connexion</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>
