<?php

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

?>
