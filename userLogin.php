<html lang="en">
<body>

<?php
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    echo "Your given info: <br>Username: $username<br>Password: $password <br>";//Hashed password: $hashedPassword<br>";

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

        if(mysqli_num_rows($results) > 0)
        {
            $data = $results->fetch_assoc();

            if (password_verify($password, $data['password'])) {
                echo "Login successful:<br>";
                echo "Username: ". $data['username'] . ", Password: " . $password . "<br>";
            }
            else
            {
                echo "Login unsuccessful, please input correct credentials or create an account.<br>";
            }
        }
        else
        {
            echo "Login unsuccessful, please input correct credentials or create an account.<br>";
        }
        
        
        $statement->close();
        $connection->close();
    }


?>

</body>
</html>