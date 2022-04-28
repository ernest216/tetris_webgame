<?php
$connection = new mysqli("localhost", "user", "password", "tetris");
if ($connection->connect_error) {
    echo $connection->connect_error;
}
if (isset($_POST["register"])) {
    if (empty($_POST["playerFirstName"]) || empty($_POST["playerLastName"]) || empty($_POST["playerUsername"]) || empty($_POST["playerPassword"]) || empty($_POST["playerConfirmPassword"]) || empty($_POST["playerscore"])) {
        echo "<script>window.alert('Please fill all the fields!');</script>";
    } else {
        $playerFirstName = $connection->escape_string($_POST["playerFirstName"]);
        $playerLastName = $connection->escape_string($_POST["playerLastName"]);
        $playerUsername = $connection->escape_string($_POST["playerUsername"]);
        $playerPassword = $connection->escape_string($_POST["playerPassword"]);
        $playerConfirmPassword = $connection->escape_string($_POST["playerConfirmPassword"]);
        $playerscore = $connection->escape_string($_POST["playerscore"]);
        $hashedPassword = hash("sha256", $playerPassword);
        $sql = "INSERT INTO `Users`(`UserName`, `FirstName`, `LastName`, `Password`, `Display`) VALUES ('$playerUsername', '$playerFirstName', '$playerLastName', '$hashedPassword', '$playerscore');";
        $result = $connection->query($sql)
            or die("Problem with query! " . $connection->error);
        if ($result) {
            header("Location: ./index.php");
        } else {
            echo "<script>window.alert('Register Failed! Try Again.');</script>";
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
    <title>Register</title>
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
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div>
                <input type="text" name="playerFirstName" id="playerFirstName" placeholder="Enter First Name">
                <input type="text" name="playerLastName" id="playerLastName" placeholder="Enter Last Name">
                <input type="text" name="playerUsername" id="playerUsername" placeholder="Enter Username">
                <input type="password" name="playerPassword" id="playerPassword" placeholder="Enter Password">
                <input type="password" name="playerConfirmPassword" id="playerConfirmPassword" placeholder="Confirm Password">
                <br>
                <label for="displayScore">Display Scores on Leaderboard</label>
                <label for="scoreYes">
                    <input type="radio" name="playerscore" id="scoreYes" value="11">
                    Yes
                </label>
                <label for="scoreNo">
                    <input type="radio" name="playerscore" id="scoreNo" value="10">
                    No
                </label>
                <input type="submit" name="register" value="Register">
                <p>Already a user account? <a href="index.php">Login now!</a></p>
            </div>
        </form>
    </div>
</body>

</html>