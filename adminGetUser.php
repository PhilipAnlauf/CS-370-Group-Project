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
            ", Last name: " . $row["LastName"] . ", Birthday: " . $row["Birthday"] . ", SSN: " . $row["SSN"] . ".\n";

        $transStmt = $connection->prepare("SELECT * FROM UserTransactionHistory WHERE SenderID = ? OR ReceiverID = ?");
        $transStmt->bind_param("ii", $id, $id);
        $transStmt->execute();
        $result = $transStmt->get_result();

        if(mysqli_num_rows($result) > 0)
        {
            while($anotherTempVarYay = mysqli_fetch_assoc($result))
            {
                $_SESSION["AccountDetails"] .= "Transaction ID: " . $anotherTempVarYay["TransactionID"] . ", SenderID: " . $anotherTempVarYay["SenderID"] .
                    ", ReceiverID: " . $anotherTempVarYay["ReceiverID"] . ", Amount: " . $anotherTempVarYay["Amount"] .
                    ", Date: " . $anotherTempVarYay["Date"] . ".\n";
            }
        }

        header("Location: /admin.php");
    }

$connection->close();
$stmt->close();
header("Location: admin.php");
exit();
?>
