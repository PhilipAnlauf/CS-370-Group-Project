<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $firstName = $_SESSION["firstName"];
    $isAdmin = isset($_SESSION["isAdmin"]) ? $_SESSION["isAdmin"] : false;

    // Server connection info
    $servername = "localhost";
    $serverUsername = "api_write";
    $serverPassword = "apikey";
    $databaseName = "bank_database";

    $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

    if (mysqli_connect_errno()) {
        echo "Connection failed: " . mysqli_connect_error();
        exit();
    }

    $id = htmlspecialchars($_POST["delete-id"]);
    $password = htmlspecialchars($_POST["delete-password"]);

    $statement = $connection->prepare("SELECT * FROM Account WHERE AccountID = ?");
    $statement->bind_param("s", $id);
    $statement->execute();
    $results = $statement->get_result();

    if ($results && $results->num_rows > 0) {
        $data = $results->fetch_assoc();

        // Allow if password is valid OR if admin is logged in
        if (password_verify($password, $data['Password']) || $isAdmin === true) {
            // Delete transactions
            $deleteTransactions = $connection->prepare("DELETE FROM Transaction WHERE SenderID = ? OR ReceiverID = ?");
            $deleteTransactions->bind_param("ii", $id, $id);
            $deleteTransactions->execute();
            $deleteTransactions->close();

            // Delete account
            $deleteAccount = $connection->prepare("DELETE FROM Account WHERE AccountID = ?");
            $deleteAccount->bind_param("i", $id);
            $deleteAccount->execute();
            $deleteAccount->close();

            $statement->close();
            $connection->close();

            header("Location: /landing.html");
            exit();

        }
        else
        {
            $statement->close();
            $connection->close();
            header("Location: user.php");
            exit();
        }
    }

    $statement->close();
    $connection->close();

}
?>
