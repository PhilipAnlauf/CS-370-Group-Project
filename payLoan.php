<?Php
    session_start();

    $id = $_SESSION["AccountID"];
    $loanID = $_POST["loanId"];
    $paymentAmount = $_POST["paymentAmount"];

    $servername = "localhost";
    $serverUsername = "api_write";
    $serverPassword = "apikey";
    $databaseName = "bank_database";

    $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

    $stmt = $connection->prepare("CALL PayLoan(?,?,?)");
    $stmt->bind_param("iid", $loanID, $id, $paymentAmount);

    try
    {
        $stmt->execute();
    }
    catch(Exception $e)
    {
        $connection->close();
        header("Location: /user.php");
        exit();
    }

    $deleteLoan = $connection->prepare("SELECT LoanAmount FROM Loan WHERE LoanID = ?");
    $deleteLoan->bind_param("i", $loanID);
    $deleteLoan->execute();
    $result = $deleteLoan->get_result();

    if ($loanRow = $result->fetch_assoc()) {
        if ($loanRow["LoanAmount"] <= 0) {
            $deleteLoan->close();
            $deleteStmt = $connection->prepare("DELETE FROM Loan WHERE LoanID = ?");
            $deleteStmt->bind_param("i", $loanID);
            $deleteStmt->execute();
            $deleteStmt->close();
        } else {
            $deleteLoan->close();
        }
    } else {
        $deleteLoan->close();
    }

    $stmt->close();
    $connection->close();

    header("Location: user.php");
?>