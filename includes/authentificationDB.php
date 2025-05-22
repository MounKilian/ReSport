<?php
    function Register($username, $email, $password) {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=resport;charset=utf8',
            'root',
            ''
        );

        $stmt = $mysqlClient->prepare(
            'INSERT INTO User (username, password, email, role) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$username, $password, $email, 'user']);

        $mysqlClient = null;
    }

?>