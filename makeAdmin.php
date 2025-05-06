<?php
    session_start();

    $servername = "localhost";
    $serverUsername = "api_write";
    $serverPassword = "apikey";
    $databaseName = "bank_database";
    $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

    if($connection)
    {
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["masterPassword"]))
        {
            $masterPassword = $_POST["masterPassword"];
            $realPassword = '$2y$10$9FWOABdqYQoUv4yUgjRefOBwFr2weu0nt7zGdNR9Z3n0OI9dlefzi';
            //adminme

            if(password_verify($masterPassword, $realPassword))
            {
                $accountID = $_SESSION["AccountID"];
                $stmt = $connection->prepare("UPDATE Account SET IsAdmin = 1 WHERE AccountID = ? ");
                $stmt->bind_param("i", $accountID);
                $stmt->execute();



                $stuff = $connection->prepare("SELECT * FROM CustomerService WHERE EmployeeID = ?");
                $stuff->bind_param("i", $accountID);  // <-- use the correct variable
                $stuff->execute();
                $stuffResult = $stuff->get_result();

                if(mysqli_num_rows($stuffResult) <= 0)
                {
                    $stmt = $connection->prepare("INSERT INTO CustomerService (EmployeeID, EmployeeTitle) VALUES (?, ?)");
                    $hold = "Junior Teller";
                    $stmt->bind_param("is", $accountID, $hold);
                    $stmt->execute(); // ✅ you must execute before closing
                    $stmt->close();
                }


                header("Location: admin.php");
                exit();
            }
            else
            {
                echo password_hash('adminme', PASSWORD_DEFAULT);
                exit();
            }
        }
    }

    $connection->close();
    header("Location: user.php");
    exit();
?>