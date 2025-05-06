<?php
    function updateLoanSession(): void
    {
        $_SESSION["loanNumbers"] = "";
        $id = $_SESSION["AccountID"];

        $connection = new mysqli("localhost", "api_write", "apikey", "bank_database");

        if ($connection->connect_error) {
            return;
        }

        $stmt = $connection->prepare("SELECT * FROM Account WHERE AccountID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($row = $stmt->get_result()->fetch_assoc()) {
            $transStmt = $connection->prepare("SELECT * FROM Loan WHERE AccountID = ?");
            $transStmt->bind_param("i", $id);
            $transStmt->execute();
            $result = $transStmt->get_result();

            if ($result->num_rows > 0) {
                $_SESSION["AccountDetails"] = "Loans:\n";
                while ($loan = $result->fetch_assoc()) {
                    $_SESSION["AccountDetails"] .= "Transaction ID: " . $loan["LoanID"] . ", ";
                }
            }
        }

        $stmt->close();
        $connection->close();
    }

?>