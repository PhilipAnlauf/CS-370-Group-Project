global$loanAmountIN;
<html lang="en">
<body>

<?php
$userIDIN = htmlspecialchars($_POST["userID"]);
$baseLoan = htmlspecialchars($_POST["loanAmount"]);
$missedPayUpchIN = htmlspecialchars($_POST["missedPayUpch"]);
$nextDueDateIN = htmlspecialchars($_POST["nextDueDate"]);
$loanAmountIN = $baseLoan+$baseLoan*($missedPayUpchIN/100);

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
    $statement = $connection->prepare("INSERT INTO Loan (AccountID, LoanAmount, MissedPaymentUpcharge, NextDueDate) VALUES (?, ?, ?, ?)");
    $statement->bind_param("idds", $userIDIN, $loanAmountIN, $missedPayUpchIN, $nextDueDateIN);
    $statement->execute();

    $statement = $connection->prepare("UPDATE Account SET Balance = Balance + ? WHERE AccountID = ?");
    $statement->bind_param("di", $baseLoan, $userIDIN);
    $statement->execute();

    $statement->close();
    $connection->close();

    header("location: admin.php");
}


?>

</body>
</html>