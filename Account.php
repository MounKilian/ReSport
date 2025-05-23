<?php
include 'includes/loginDB.php';
?>

<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>JO 2024</title>
        <link rel="stylesheet" href="style.css">
    </head>


    <body>
        <main>
            <section>
                <table>
                    <tr>
                        <th>username</th>
                        <th>password</th>
                        <th>email</th>
                        <th>Article</th>
                        <th>Facture</th>
                    </tr>
                    <?php $data = getNameAndTime();
                    foreach ($data as $row) { ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td><?php echo $row['email']; ?></td>

                            <td><?php echo $row['description']; ?></td>

                            <td><?php echo $row['transaction_date']; ?></td>

                        </tr>
                    <?php } ?>
                </table>
                <a href=""><button>Article en Vente</button></a>
                
                <button>Modifier Nom</button>
                <button>Modifier email</button>
            </section>
        </main>
    </body>