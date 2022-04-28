<?php
header("Cache-Control: no-cache");
header("Expires: -1");
session_start();
if (!$_SESSION["who"]) {
    header("Location: ./index.php");
} else {
    $connection = new mysqli("localhost", "user", "password", "tetris");
    if ($connection->connect_error) {
        echo $connection->connect_error;
    }
    $user = $_SESSION["who"];
    if(isset($_POST["done"])) {
        $score = $_POST["score"];
        $sql = "INSERT INTO `Scores`(`UserID`, `Score`) VALUES ('$user', '$score');";
        $result = $connection->query($sql)
            or die("Problem with query! " . $connection->error);
        if ($result) {
            header("Location: ./leaderboard.php");
        } else {
            echo "<script>window.alert('Score Failed! Try Again.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./img/tetris.png" type="image/x-icon">
    <style>
        #Tetris {
            width: 300px;
            height: 400px;
            position: relative;
        }

        #Scrren {
            list-style-type: none;
            float: left;
        }

        #Scrren li {
            float: left;
        }

        #Main-scrren {
            background-color: #c7c7c7;
            box-shadow: 5px 5px #000000;
        }

        #Sub-scrren {
            background-color: black;
            margin: 0 0 0 20px;
        }

        #Scrren p {
            margin: 30px 0 0 25px;
        }

        #Game_over {
            position: absolute;
            top: 180px;
            left: 60px;
            display: none;
        }

        #play {
            background-color: white;
            width: 40px;
            height: 20px;
            border: solid 2px gray;
            border-radius: 3px;
            padding-left: 10px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="./logout.php">Home</a></li>
            </ul>
            <ul>
                <li><a href="./tetris.php">Play Tetris</a></li>
                <li><a href="./leaderboard.php">Leaderboard</a></li>
            </ul>
        </nav>
    </header>
    <div class="main">
        <div id="Tetris" style="position: absolute; z-index: 2;">
            <ul id="Scrren">
                <li><canvas width="100" height="200" id="Main-scrren">error</canvas>
                    <img src="./img/tetris-grid-bg.png" alt="tetrisgrid" style="width:34%; position: absolute; top: 4%; left: 13%;"></li>
                <li>
                    <canvas width="50" height="50" id="Sub-scrren">error</canvas>
                    <div id="score"></div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="number" name="score" id="score" placeholder="Enter your Score:" required>
                        <input type="submit" name="done" value="Done">
                    </form>
                    <button id="play">Play</button>
                </li>
            </ul>
            <canvas width="250" height="40" id="Game_over">error</canvas>
        </div>
    </div>
    <div id="score"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/app.js"></script>
</body>

</html>