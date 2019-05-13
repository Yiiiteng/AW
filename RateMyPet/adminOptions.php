<?php
    require_once __DIR__.'/include/config.php';
    require_once __DIR__.'/include/adminSetup.php';
    if ($_SESSION["user"]->rol() != "admin") {
        header('Location: error.php'); // If anyone tries to enter this page and is not an admin
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <?php 
        require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>Admin Options</h1>
        <?php
            if (!$mods) { // Moderators
                echo '<h2>There are currently no moderators!</h2>';
            } else { // Print a table with all the moderators
                echo '<h2>Rate My Pet Moderators</h2>';
                echo '<table id="mods">';
                    echo '<tr>
                        <th>User</th>
                        <th>Revoke Permissions</th>
                    </tr>';
                    while ($row = $mods->fetch_assoc()) {
                        $user = Usuario::buscaUsuarioId($row['id']);
                        echo '<tr>
                            <td><a href="ownerProfile.php?id='.$user->id().'">'.$user->username().'</a></td>
                            <td>
                                <form action="include/manageMods.php" method="POST">
                                    <input type="hidden" value="'.$user->id().'" name="id">
                                    <input type="hidden" value="revoke" name="action">
                                    <button type="submit" name="revoke" value="your_value" class="btn-link">Revoke</button>
                                </form>
                            </td>
                        </tr>';
                    }
                echo '</table>';
            }
        ?>
    </div>
    <?php 
        require('include/comun/footer.php');
    ?>
</body>
</html>