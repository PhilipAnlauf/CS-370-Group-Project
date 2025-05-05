<?php
session_start();
$_SESSION["AccountDetails"] = "";
$id = htmlspecialchars($_POST["userID"]);

// Server connection info
$servername = "localhost";
$serverUsername = "api_write";
$serverPassword = "apikey";
$databaseName = "bank_database";

$connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

if (mysqli_connect_errno()) {
    echo "Connection failed: " . $connection->connect_error;
    exit();
}

    $stmt = $connection->prepare("SELECT * FROM Account WHERE AccountID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if($row = $stmt->get_result()->fetch_assoc())
    {
        $_SESSION["AccountDetails"] = "ID: " . $row["AccountID"] . ", First name: " . $row["FirstName"] .
            ", Last name: " . $row["LastName"] . ", Birthday: " . $row["Birthday"] . ", SSN: " . $row["SSN"] . ".";
        header("Location: /admin.php");
    }

$connection->close();
$stmt->close();
header("Location: admin.php");
exit();
?>
