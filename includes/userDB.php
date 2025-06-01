<?php
    require_once 'db.php';

function getAllUsers()
{
    try {
        $mysqlClient = getPDOConnection();
        $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $mysqlClient->query('SELECT * FROM user');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $users;

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}


function updateUser($id, $data) {
    try {
        $pdo = getPDOConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // On prépare la requête de mise à jour
        $stmt = $pdo->prepare("UPDATE user SET username = :username, email = :email, role = :role WHERE id = :id");

        // On exécute avec les données reçues (penser à sécuriser les données en amont si besoin)
        $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':id' => $id
        ]);

        return true;

    } catch (PDOException $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
        return false;
    }
}

function deleteUserById($id) {
    try {
        $pdo = getPDOConnection();
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = :id");
        $stmt->execute(['id' => $id]);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}



?>
