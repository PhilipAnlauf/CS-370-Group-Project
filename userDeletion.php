<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();

    $firstName = $_SESSION["firstName"];

    // Server connection info
    $servername = "localhost";
    $serverUsername = "api_write";
    $serverPassword = "apikey";
    $databaseName = "bank_database";

    $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

    if (mysqli_connect_errno()) {
        echo "Connection failed: " . $connection->connect_error;
    } else {
        $id = htmlspecialchars($_POST["delete-id"]);
        $password = htmlspecialchars($_POST["delete-password"]);

        $statement = $connection->prepare("SELECT * FROM Account WHERE FirstName = ?");
        $statement->bind_param("s", $firstName); // Bind as string for FirstName
        $statement->execute();
        $results = $statement->get_result();

        if (mysqli_num_rows($results) > 0) {
            $data = $results->fetch_assoc();

            // Password verification
            if (password_verify($password, $data['Password'])) {
                // Deletion of transaction records related to the account
                $statement = $connection->prepare("DELETE FROM Transaction WHERE SenderID = ? OR ReceiverID = ?");
                $statement->bind_param("ii", $id, $id); // Bind as integers for SenderID and ReceiverID
                $statement->execute();

                // Delete the account
                $statement = $connection->prepare("DELETE FROM Account WHERE AccountID = ?");
                $statement->bind_param("i", $id); // Bind as integer for AccountID
                $statement->execute();

                header("Location: landing.html");
            } else {
                header("Location: user.php");
            }
        }

        $statement->close();
        $connection->close();
    }
}
?>
