<?php
    function Register($username, $email, $password) {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

        $stmt = $mysqlClient->prepare(
            'INSERT INTO User (username, email, password, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$username, $email, $password, 'user']);
        $stmt = $mysqlClient->prepare(
            'SELECT * FROM User WHERE username = ? AND password = ?'
        );
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return true;
        } else {
            return false;
        }
    }

    function Login($username, $password) {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

        $stmt = $mysqlClient->prepare(
            'SELECT * FROM User WHERE username = ? AND password = ?'
        );
        $stmt->execute([$username, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['name'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        } else {
            return false;
        }

        $mysqlClient = null;

        return true;
    }

    function getIDOfUser($username) {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

        $stmt = $mysqlClient->prepare(
            'SELECT id FROM User WHERE username = ?'
        );
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user['id'];
        } else {
            return false;
        }
    }

?>