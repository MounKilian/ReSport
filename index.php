<?php
    $mysqlClient = new PDO(
        'mysql:host=localhost;dbname=jo;charset=utf8',
        'root',
        ''
    );

    $query = $mysqlClient->query('SELECT * FROM jo.`100`;');
    $query->execute();

    $data = $query->fetchAll(PDO::FETCH_ASSOC);

    $mysqlClient = null;
    $dbh = null;