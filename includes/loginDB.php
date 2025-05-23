<?php
    function getNameAndTime()
    {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=jo;charset=utf8',
            'root',
            ''
        );

        $query = $mysqlClient->query('SELECT * FROM jo.`user`;');
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $mysqlClient = null;
        
        return $data;
    }

?>