<?php
    session_start();

    include_once '../includes/loginDB.php';
    include_once '../includes/authentificationDB.php';

    if (!isset($_SESSION['name'])) {
        header("Location: ./loginPage.php");
        exit();
    }

    $data = getAll();

    $currentUserId = null;
    if ($data && isset($data['user']['id'])) {
        $currentUserId = $data['user']['id'];
    }

    if (!isset($_GET['id'])) {
        echo "Aucun ID fourni.";
        exit;
    }

    $requestedId = intval($_GET['id']); 

    $dataOther = getUserById($requestedId);
    if (!$dataOther) {
        echo "Utilisateur introuvable.";
        exit;
    }

    $user = $data['user'];
    $articles = $data['articles'];
    $invoices = $data['invoices'];

    $userOther = $dataOther['user'];
    $articlesOther = $dataOther['articles'];
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/account.css">
        <link rel="stylesheet" href="../css/header.css">
        <title>ReSport - Compte</title>
    </head>

    <?php if ($currentUserId === $requestedId) { ?>
        <body>    
            <?php include '../templates/header.php'; ?>

            <div class="body">
            <h3>Compte</h3>
            <?php
                if (!empty($user['profile_photo'])) {
                    echo '<img src="../images/' . htmlspecialchars($user['profile_photo']) . '" alt="Photo de profil" style="width:150px;height:150px;border-radius:50%;object-fit:cover;"><br>';
                } else {
                    echo '<p>Aucune photo de profil.</p>';
                }
            ?>            
            <div class="profile-info">
                <div>Nom d'utilisateur :</div>
                <div><?= htmlspecialchars($user['username']) ?></div>

                <div>Email :</div>
                <div><?= htmlspecialchars($user['email']) ?></div>

                <div>Solde :</div>
                <div>
                    <?= htmlspecialchars($user['balance']) ?> €
                    <a href="paymentPage.php" class="balance-button">Ajouter de l'argent</a>
                </div>
            </div>

            <form method="POST" action="" enctype="multipart/form-data">
                <label>Photo de profil :</label><br>
                <input type="file" name="profile_picture" accept="image/*"><br><br>

                <label>Nouvel email :</label><br>
                <input type="email" name="new_email" placeholder="Laissez vide pour ne pas modifier"><br><br>

                <label>Nouveau mot de passe :</label><br>
                <input type="password" name="new_password" placeholder="Laissez vide pour ne pas modifier"><br><br>

                <button type="submit" name="modifier">Modifier</button>

                <?php

                if (isset($_POST['modifier']) && isset($_SESSION['name'])) {
                    $newEmail = trim($_POST['new_email']);
                    $newPassword = trim($_POST['new_password']);
                    $currentUsername = trim($_SESSION['name']);

                    $error = null;
                    $success = null;
                    $params = [];
                    $sql = "UPDATE user SET ";

                    if (!empty($newPassword)) {
                        if (!passwordIsValid($newPassword)) {
                            $error = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
                        } else {
                            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            $sql .= "password = :newPassword, ";
                            $params['newPassword'] = $hashedPassword;
                        }
                    }

                    if (!empty($newEmail)) {
                        $sql .= "email = :newEmail, ";
                        $params['newEmail'] = $newEmail;
                    }

                    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
                        $fileName = $_FILES['profile_picture']['name'];
                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                        if (in_array($fileExtension, $allowedExtensions)) {
                            $newFileName = uniqid('pp_', true) . '.' . $fileExtension;
                            $uploadDir = '../images/';
                            $destPath = $uploadDir . $newFileName;

                            if (move_uploaded_file($fileTmpPath, $destPath)) {
                                $imageInfo = getimagesize($destPath);
                                if ($imageInfo === false) {
                                    unlink($destPath);
                                    $error = "Le fichier n'est pas une image valide.";
                                }

                                $sql .= "profile_photo = :profilePicture, ";
                                $params['profilePicture'] = $newFileName;
                            } else {
                                $error = "Erreur lors de l'upload de l'image.";
                            }
                        } else {
                            $error = "Format d'image non autorisé. Seuls JPG, PNG et GIF sont acceptés.";
                        }
                    }
                  

                    if (!$error && !empty($params)) {
                        $sql = rtrim($sql, ", ");
                        $sql .= " WHERE username = :currentUsername";
                        $params['currentUsername'] = $currentUsername;

                        try {
                            $pdo = getPDOConnection();
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute($params);
                            $success = "Informations mises à jour avec succès.";
                            // header("Location: accountPage.php?id=" . $user['id']);

                            // Redirection après modification
                            // header("Location: accountPage.php?id=" . $$user['id']);
                            
                        } catch (PDOException $e) {
                            $error = "Erreur : " . $e->getMessage();
                        }
                    } elseif (!$error) {
                        $error = "Aucune modification effectuée.";
                    }
                    
                    if ($error) {
                        echo "<p style='color: red;'>$error</p>";
                    } elseif ($success) {
                        echo "<p style='color: green;'>$success</p>";
                        header("Location: accountPage.php?id=" . $user['id']);
                        exit();
                    }
                    
                }

                ?>
            </form>

            
            

            <section class="featured-products">
                <h3>Mes articles</h3>
                <div class="products-grid">
                    <?php
                        foreach ($articles as $article) {
                            echo '<div class="product-card">';
                            echo '<img src="../images/' . $article['image_link'] . '" alt="' . $article['name'] . '">';
                            echo '<p>' . $article['price'] . ' €</p>';
                            echo '<h3>' . $article['name'] . '</h3>';
                            echo '<a href="./detailsPage.php?id=' . $article['id'] . '" class="cta-button">Voir les détails</a>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </section>

            <section class="invoice-section">
                <h3>Mes factures</h3>
                <div class="invoice-cards">
                    <?php foreach ($invoices as $invoice): ?>
                        <div class="invoice-card">
                            <div><span>Date d'achat :</span><?= htmlspecialchars($invoice['transaction_date']) ?></div>
                            <div><span>Montant :</span><?= htmlspecialchars($invoice['amount']) ?> €</div>
                            <div><span>Adresse :</span><?= htmlspecialchars($invoice['billing_address']) ?></div>
                            <div><span>Ville :</span><?= htmlspecialchars($invoice['billing_city']) ?></div>
                            <div><span>Code postal :</span><?= htmlspecialchars($invoice['billing_postal_code']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            </div>
        </body>

    </html>


<?php } else { ?>
    <body>   
        <?php include '../templates/header.php'; ?>
        <div class="body">
        <h3>Compte</h3>
        <?php
            if (!empty($userOther['profile_photo'])) {
                echo '<img src="../images/' . htmlspecialchars($userOther['profile_photo']) . '" alt="Photo de profil" style="width:150px;height:150px;border-radius:50%;object-fit:cover;"><br>';
            } else {
                echo '<p>Aucune photo de profil.</p>';
            }
        ?>
       
        <div class="profile-info">
                <div>Nom d'utilisateur :</div>
                <div><?= htmlspecialchars($userOther['username']) ?></div>

                <div>Email :</div>
                <div><?= htmlspecialchars($userOther['email']) ?></div>
        </div>

        <section class="featured-products">
            <h3>Les articles de <?= htmlspecialchars($userOther['username']) ?></h3>
            <div class="products-grid">
                <?php
                    foreach ($articlesOther as $articleOther) {
                        echo '<div class="product-card">';
                        echo '<img src="../images/' . $articleOther['image_link'] . '" alt="' . $articleOther['name'] . '">';
                        echo '<p>' . $articleOther['price'] . ' €</p>';
                        echo '<h3>' . $articleOther['name'] . '</h3>';
                        echo '<a href="./detailsPage.php?id=' . $articleOther['id'] . '" class="cta-button">Voir les détails</a>';
                        echo '</div>';
                    }
                ?>
            </div>
        </section>
        </div>
    </body>
<?php } ?>

