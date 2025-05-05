<?php
$firstName = htmlspecialchars($_POST["firstName"]);
$lastName = htmlspecialchars($_POST["lastName"]);
$birthday = htmlspecialchars($_POST["birthday"]);
$ssn = htmlspecialchars($_POST["ssn"]);
$password = htmlspecialchars($_POST["password"]);
$id = htmlspecialchars($_POST["id"]);

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

function updateField($connection, $field, $value, $id) {
    $query = "UPDATE Account SET $field = ? WHERE AccountID = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("si", $value, $id);
    $stmt->execute();
    $stmt->close();
}

// Only update fields if not empty
if (!empty($firstName)) {
    updateField($connection, "FirstName", $firstName, $id);
}
if (!empty($lastName)) {
    updateField($connection, "LastName", $lastName, $id);
}
if (!empty($birthday)) {
    updateField($connection, "Birthday", $birthday, $id);
}
if (!empty($ssn)) {
    updateField($connection, "SSN", $ssn, $id);
}
if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    updateField($connection, "Password", $hashedPassword, $id);
}

$connection->close();
header("Location: admin.php");
exit();
?>
