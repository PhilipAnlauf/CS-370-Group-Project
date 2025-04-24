<html lang="en">
<body>

<?php
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    echo "Your given info: $username!<br>";
    echo "                 $password<br>";

    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT); add later

    //Server connection info
    $servername = "localhost";
    $serverUsername = "new_admin";
    $serverPassword = "your_secure_password";
    $databaseName = "test_db";

    $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

    if(mysqli_connect_errno())
    {
        echo "Connection failed: " . $connection->connect_error;
    }
    else
    {
        $statement = $connection->prepare("SELECT * FROM testUsers WHERE username = '$username'");
        $statement->execute();
        $results = $statement->get_result();


        echo "Database connection test:<br>";
        while ($row = $results->fetch_assoc()) {
            echo "Username: " . $row['username'] . " - Password: " . $row['password'] . "<br>";
        }

        $statement->close();
        $connection->close();
    }


?>

</body>
</html>