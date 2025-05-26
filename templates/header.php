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
            <li><a href="./pages/cartPage.php">Panier</a></li>
            <?php if (isset($_SESSION['name']) && $_SESSION['name'] != '') { ?>
                <li><a href="./pages/accountPage.php">Mon compte</a></li>
                <li>
                    <form action="/ReSport/index.php" method="get" style="display:inline;">
                        <button type="submit" name="logout" value="1" class="cta-button" style="padding: 0.5rem 1rem; font-size: 1rem;">Déconnexion</button>
                    </form>
                </li>
            <?php } else { ?>
                <li><a href="./pages/registerPage.php">Connexion</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>