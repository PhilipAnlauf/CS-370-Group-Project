<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$senderID = $_SESSION['AccountID'];
$receiverID = $_POST["transfer-id"];
$amount = $_POST["transfer-amount"];
$id = $_SESSION['AccountID'];

// Enable exception mode
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = new mysqli("localhost", "api_write", "apikey", "bank_database");
    $connection->set_charset("utf8mb4");

    $statement = $connection->prepare("CALL TransferFunds(?, ?, ?)");
    $statement->bind_param("iid", $senderID, $receiverID, $amount);
    $statement->execute();

    // Update session with new balance
    $newBalanceQuery = $connection->prepare("SELECT Balance FROM Account WHERE AccountID = ?");
    $newBalanceQuery->bind_param("i", $senderID);
    $newBalanceQuery->execute();
    $newBalanceResult = $newBalanceQuery->get_result();

    $temp = $connection->prepare("SELECT * FROM Account WHERE AccountID = ?");
    $temp->bind_param("i", $id);
    $temp->execute();
    $tempResult = $temp->get_result()->fetch_assoc();

    if ($row = $newBalanceResult->fetch_assoc()) {
        $_SESSION['balance'] = $row['Balance'];
    }

    $newBalanceQuery->close();
    $statement->close();
    $connection->close();

    if($tempResult["IsAdmin"] === 0){
        header("Location: user.php");
    }
    else{
        header("Location: admin.php");
    }
    exit();

} catch (mysqli_sql_exception $e) {
    // Store error message in session to show on user.php
    $_SESSION['transfer_error'] = $e->getMessage();

    if (isset($statement)) $statement->close();
    if (isset($connection)) $connection->close();

    header("Location: user.php");
    exit();
}
