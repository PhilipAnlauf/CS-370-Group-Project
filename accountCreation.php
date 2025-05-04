<html lang="en">
<body>

<?php
$firstName = htmlspecialchars($_POST["firstName"]);
$lastName = htmlspecialchars($_POST["lastName"]);
$birthday = htmlspecialchars($_POST["birthday"]);
$ssn = htmlspecialchars($_POST["ssn"]);
$password = htmlspecialchars($_POST["password"]);

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

//Server connection info
$servername = "localhost";
$serverUsername = "api_write";
$serverPassword = "apikey";
$databaseName = "bank_database";

$connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

if(mysqli_connect_errno())
{
    echo "Connection failed: " . $connection->connect_error;
}
else
{
    $statement = $connection->prepare("CALL CreateAccount(?, ?, ?, ?, ?, ?)");
    $isAdmin = 0;
    $defaultBalance = 50.0;
    $statement->bind_param("ssssis", $firstName, $lastName, $birthday, $ssn, $isAdmin, $hashedPassword);
    $statement->execute();

    $statement->close();
    $connection->close();

    header("location: landing.html");
}


?>

</body>
</html>