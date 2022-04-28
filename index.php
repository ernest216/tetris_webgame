<?php
$connection = new mysqli("localhost", "user", "password", "tetris");
if ($connection->connect_error) {
    echo $connection->connect_error;
}
header("Cache-Control: no-cache");
header("Expires: -1");
if (isset($_POST["login"])) {
    if (empty($_POST["playerUsername"]) || empty($_POST["playerPassword"])) {
        echo "<script>window.alert('Please fill all the fields!');</script>";
    } else {
        $playerUsername = $connection->escape_string($_POST["playerUsername"]);
        $playerPassword = $connection->escape_string($_POST["playerPassword"]);
        $hashedPassword = hash("sha256", $playerPassword);
        $sql = "SELECT * FROM `Users` WHERE `UserName`='$playerUsername' AND `Password`='$hashedPassword';";
        $result = $connection->query($sql)
            or die("Problem with query! " . $connection->error);
        if ($result->num_rows) {
            session_start();
            $user = $result->fetch_assoc();
            $_SESSION["who"]  = $user["UserID"];
            echo "<div style='padding: 56px 24px; margin: 0 auto; position: absolute; top: 30%; left: 25%; z-index: 2; background-color: #c7c7c7; box-shadow: 5px 5px #000000; width: 50%; text-align: center;'>
                <h1>Welcome to Tetris!</h1>
                <button style='padding: 8px 16px; font-size: 18px;'><a href='./tetris.php'>Click here to play</a></button>
            </div>";
        } else {
            echo "<script>window.alert('Login Failed! Try Again.');</script>";
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
    <title>Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="./img/tetris.png" type="image/x-icon">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li class="home"><a href="./">Home</a></li>
            </ul>
            <ul>
                <li class="tetris"><a href="./tetris.php">Play Tetris</a></li>
                <li class="leaderboard"><a href="./leaderboard.php">Leaderboard</a></li>
            </ul>
        </nav>
    </header>
    <div class="main">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div>
                <input type="text" name="playerUsername" id="playerUsername" placeholder="Enter Username">
                <input type="password" name="playerPassword" id="playerPassword" placeholder="Enter Password">
                <input type="submit" name="login" value="Login">
                <p>Don't have a user account? <a href="register.php">Register now!</a></p>
            </div>
        </form>
    </div>
</body>

</html>