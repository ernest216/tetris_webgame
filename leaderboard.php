<?php
    $connection = new mysqli("localhost", "user", "password", "tetris");
    if ($connection->connect_error) {
        echo $connection->connect_error;
    }
    $sql = "SELECT `Scores`.`ScoreID`, `Users`.`UserName`, `Scores`.`Score` FROM `Scores` INNER JOIN `Users` ON `Scores`.`UserID`=`Users`.`UserID` WHERE `Users`.`Display`=11;";
    $result = $connection->query($sql)
        or die('Problem with query! ' . $connection->error);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./img/tetris.png" type="image/x-icon">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="./">Home</a></li>
            </ul>
            <ul>
                <li><a href="./tetris.php">Play Tetris</a></li>
                <li><a href="./leaderboard.php">Leaderboard</a></li>
            </ul>
        </nav>
    </header>
    <div class="main">
        <table>
            <tr>
                <th>Username</th>
                <th>Score</th>
            </tr>
            <?php
            if ($result->num_rows) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row["UserName"]; ?></td>
                        <td><?php echo $row["Score"]; ?></td>
                    </tr>
            <?php
                }
            }
            $connection->close();
            ?>
        </table>
    </div>
</body>

</html>