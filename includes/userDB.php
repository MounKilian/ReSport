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

        $stmt = $pdo->prepare("UPDATE user SET username = :username, email = :email, role = :role WHERE id = :id");

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

function deleteUserAndAssociatedData($userId) {
    $pdo = getPDOConnection();

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT id FROM Article WHERE author_id = ?");
        $stmt->execute([$userId]);
        $articles = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($articles)) {
            $in = implode(',', array_fill(0, count($articles), '?'));
            $stmt = $pdo->prepare("DELETE FROM Stock WHERE article_id IN ($in)");
            $stmt->execute($articles);
        }

        $stmt = $pdo->prepare("DELETE FROM Article WHERE author_id = ?");
        $stmt->execute([$userId]);

        $stmt = $pdo->prepare("DELETE FROM Cart WHERE user_id = ?");
        $stmt->execute([$userId]);

        $stmt = $pdo->prepare("DELETE FROM Invoice WHERE user_id = ?");
        $stmt->execute([$userId]);

        $stmt = $pdo->prepare("DELETE FROM User WHERE id = ?");
        $stmt->execute([$userId]);

        $pdo->commit();
        return true;

    } catch (Exception $e) {
        $pdo->rollBack();
        error_log("Erreur suppression utilisateur : " . $e->getMessage());
        return false;
    }
}





?>
