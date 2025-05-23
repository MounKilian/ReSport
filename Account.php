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
                <h2>Résultats</h2>
                <table>
                    <tr>
                        <th>username</th>
                        <th>Temps</th>
                    </tr>
                    <?php $data = getNameAndTime();
                    foreach ($data as $row) { ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['password']; ?></td>
                            <td><?php echo $row['email']; ?></td>

                        </tr>
                    <?php } ?>
                </table>
            </section>
        </main>
    </body>