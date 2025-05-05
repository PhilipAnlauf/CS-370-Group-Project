<?Php
    session_start();

    $id = $_SESSION["AccountID"];

    $servername = "localhost";
    $serverUsername = "api_write";
    $serverPassword = "apikey";
    $databaseName = "bank_database";

    $paymentAmount = $_POST["paymentAmount"];

    $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

    $stmt = $connection->prepare("SELECT * FROM Loan WHERE AccountID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if($row = $stmt->get_result()->fetch_assoc())
    {
        $loanID = $row["LoanID"];

        $stmt = $connection->prepare("CALL PayLoan(?,?,?)");
        $stmt->bind_param("iid", $loanID, $id, $paymentAmount);

        try {
            $stmt->execute();
        }
        catch(Exception $e) {
            $connection->close();
            header("Location: user.php");
        }

        $deleteLoan = $connection->prepare("SELECT LoanAmount FROM Loan WHERE AccountID = ?");
        $deleteLoan->bind_param("i", $id);
        $deleteLoan->execute();
        $result = $deleteLoan->get_result();

        if ($loanRow = $result->fetch_assoc()) {
            if ($loanRow["LoanAmount"] <= 0) {
                $deleteLoan->close();

                $deleteStmt = $connection->prepare("DELETE FROM Loan WHERE AccountID = ?");
                $deleteStmt->bind_param("i", $id);
                $deleteStmt->execute();
                $deleteStmt->close();
            } else {
                $deleteLoan->close();
            }
        } else {
            $deleteLoan->close();
        }

    }

    $stmt->close();
    $connection->close();

    header("Location: user.php");
?>