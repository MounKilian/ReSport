<?php
    function getNameAndTime()
    {
        $mysqlClient = new PDO(
            'mysql:host=localhost;dbname=jo;charset=utf8',
            'root',
            ''
        );

        $query = $mysqlClient->query('
        SELECT u.*, a.*,i. *
        FROM jo.`user` u
        JOIN jo.`article` a ON u.id = a.author_id
        JOIN jo.`invoice` i ON u.id = i.user_id
        ');
        
        $query->execute();

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        $mysqlClient = null;
        
        return $data;
    }

?>