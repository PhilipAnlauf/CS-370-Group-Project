<?php
    session_start();

    $firstName = $_SESSION["firstName"];
    $lastName = $_SESSION["lastName"];
    $password = $_SESSION["password"];
    $isAdmin = $_SESSION["isAdmin"];
    $ssn = $_SESSION["ssn"];
    $balance = $_SESSION["balance"];
    $id = $_SESSION["AccountID"];
    $loans = $_SESSION["loanNumbers"];

    include 'userGetLoans.php';
    updateLoanSession();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Account Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f7;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
      color: #2b4f81;
      border-bottom: 1px solid #ccc;
      padding-bottom: 8px;
      margin-bottom: 20px;
    }

    .section {
      margin-bottom: 40px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 6px;
    }

    input[type="text"],
    input[type="password"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 14px;
    }

    button {
      padding: 10px 20px;
      background-color: #2b4f81;
      color: white;
      font-size: 14px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    button:hover {
      background-color: #1f3d63;
    }

    .loan-item {
      background: #f4f8fb;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      border: 1px solid #d9e5f1;
    }

    .loan-item label {
      margin-top: 5px;
    }

    .flex-row {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .flex-row input[type="number"] {
      flex: 1;
    }

    .sub-label {
      color: #444;
      margin: 3px 0;
    }
  </style>
</head>
<body>

<?Php
$servername = "localhost";
$serverUsername = "api_write";
$serverPassword = "apikey";
$databaseName = "bank_database";
$connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);
$balanceStmt = $connection->prepare("SELECT Balance FROM Account WHERE AccountID = ?");
$balanceStmt->bind_param("i", $id);
$balanceStmt->execute();
$balanceResult = $balanceStmt->get_result();

if ($balanceRow = $balanceResult->fetch_assoc()) {
    $_SESSION["balance"] = $balanceRow["Balance"];
}

$balanceStmt->close();

$temp = $connection->prepare("SELECT * FROM Loan WHERE AccountID = ?");
$temp->bind_param("i", $id);
$temp->execute();
$tempResult = $temp->get_result()->fetch_assoc();

if ($tempResult["NextDueDate"] < date("Y-m-d")) {
    $tempResult["LoanAmount"] += $tempResult["LoanAmount"]*($tempResult["MissedPaymentUpcharge"]/100);
    $tempResult["NextDueDate"] = date("Y-m-d", strtotime("+30 days"));

    $updateLoanStmt = $connection->prepare("UPDATE Loan SET LoanAmount = ?, NextDueDate = ? WHERE AccountID = ?");
    $updateLoanStmt->bind_param("dsi", $tempResult["LoanAmount"], $tempResult["NextDueDate"], $id);
    $updateLoanStmt->execute();
    $updateLoanStmt->close();
}

$connection->close();

?>

<div class="container">

  <h2>User Dashboard</h2>

  <!-- Display user info -->
  <div class="section">
      <h3>Account Overview</h3>
      <p><strong>Name: <?php echo $firstName . " " . $lastName?></strong> </p>
      <p><strong>Account Balance: <?php echo "$" . $_SESSION["balance"]?></strong> </p>
      <p><strong>User ID: <?php echo $id?></strong> </p>
  </div>

  <!-- Self account deletion -->
  <div class="section">
    <h3>Delete Account</h3>
      <form action="/userDeletion.php" method="POST">
        <label for="delete-id">Enter Your ID</label>
        <input type="text" id="delete-id" placeholder="User ID" name="delete-id" />

        <label for="delete-password">Enter Your Password</label>
        <input type="password" id="delete-password" placeholder="Password" name="delete-password"/>

        <button type="submit">Confirm Account Deletion</button>
      </form>
  </div>

  <!-- Loan section -->
    <?Php
        $servername = "localhost";
        $serverUsername = "api_write";
        $serverPassword = "apikey";
        $databaseName = "bank_database";

        $connection = mysqli_connect($servername, $serverUsername, $serverPassword, $databaseName);

        $stmt = $connection->prepare("SELECT * FROM Loan WHERE AccountID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="loan-item">';
                echo '<div class="sub-label"><strong>Loan Amount:</strong> $' . $row["LoanAmount"] . '</div>';
                echo '<div class="sub-label"><strong>Upcharge Percentage:</strong> ' . $row["MissedPaymentUpcharge"] . '%</div>';
                echo '<div class="sub-label"><strong>Due Date:</strong> ' . $row["NextDueDate"] . '</div>';

                echo '<label for="custom-payment">Make a Custom Payment</label>';
                echo '<form action="/payLoan.php" method="POST">';

                echo '<input type="hidden" name="loanId" value="' . $row['LoanID'] . '">';
                echo '<div class="flex-row">';
                echo '<input type="number" placeholder="Enter amount" name="paymentAmount"/>';
                echo '<button type="submit">Submit Payment</button>';
                echo '</div>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "<p>No loans found.</p>";
        }
    ?>

  <!-- Money Transfer Section -->
  <div class="section">
    <h3>Send Money</h3>
        <form action="/transferFunds.php" method="POST">
            <label for="transfer-id">Recipient ID</label>
            <input type="text" id="transfer-id" placeholder="Recipient ID" name="transfer-id" />

            <label for="transfer-amount">Amount</label>
            <input type="number" id="transfer-amount" placeholder="Amount to send" name="transfer-amount" />

            <button type="submit">Send Money</button>
        </form>
  </div>


    <!-- Upgrading to admin -->
    <div class="section">
        <h3>Become Admin</h3>
        <form action="/makeAdmin.php" method="POST">
            <label for="Master password">Master Password</label>
            <input type="password" id="Master password"  name="masterPassword" />

            <button type="submit">Become Admin</button>
        </form>
    </div>

</div>

</body>
</html>
