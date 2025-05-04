<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Server connection info
        $servername = "localhost";
        $serverUsername = "api_read";
        $serverPassword = "apikey";
        $databaseName = "bank_database";

        $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

        if (mysqli_connect_errno()) {
            echo "Connection failed: " . $connection->connect_error;
        } else {
            $firstName = htmlspecialchars($_POST["firstName"]);
            $password = htmlspecialchars($_POST["password"]);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $statement = $connection->prepare("SELECT * FROM Account WHERE FirstName = '$firstName'");
            $statement->execute();
            $results = $statement->get_result();

            if (mysqli_num_rows($results) > 0)
            {
                $data = $results->fetch_assoc();

                //Password verification
                if (password_verify($password, $data['Password']) && $firstName == $data['FirstName']) {
                    //Declaration of session variables if password correct
                    session_start();

                    echo "Login Successful!";

                    $_SESSION["firstName"] = $firstName;
                    $_SESSION["lastName"] = $data["LastName"];
                    $_SESSION["password"] = $password;
                    $_SESSION["isAdmin"] = $data["IsAdmin"];
                    $_SESSION["ssn"] = $data["SSN"];
                    $_SESSION["balance"] = $data["Balance"];
                    $_SESSION["AccountID"] = $data["AccountID"];

                    if ($_SESSION["isAdmin"] == 0) {
                        header("location: user.php");
                    } else {
                        header("location: admin.php");
                    }
                }
                else
                {
                    header("Location: landing.html");
                }
            }
            else
            {
                header("location: landing.html");
            }

            $statement->close();
            $connection->close();

        }
    }
