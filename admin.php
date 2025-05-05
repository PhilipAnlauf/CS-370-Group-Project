<?php
    session_start();
    $adminBalance = $_SESSION["balance"];


    $_SESSION["getID"] = "";
    $firstName = $_SESSION["firstName"];
    $lastName = $_SESSION["lastName"];
    $password = $_SESSION["password"];
    $isAdmin = $_SESSION["isAdmin"];
    $ssn = $_SESSION["ssn"];
    $balance = $_SESSION["balance"];
    $id = $_SESSION["AccountID"];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Account Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f7;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    h2, h3 {
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
    input[type="number"],
    input[type="email"],
    input[type="date"] {
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

    .sub-heading {
      margin-top: 25px;
      font-size: 16px;
      color: #2b4f81;
    }
  </style>
</head>
<body>

<div class="container">

  <h2>Admin Dashboard</h2>

  <!-- Account Info -->
  <div class="section">
    <h3>Admin Account Overview</h3>
    <p><strong>Name:</strong> Admin User</p>
    <p><strong>Account Balance:</strong> <?Php echo "$" . $_SESSION["balance"]; ?></p>
  </div>

  <!-- Loan Creation -->
  <div class="section">
    <h3>Create Loan for User</h3>
      <form action="/createLoan.php" method="POST">
          <label>User ID</label>
          <input type="text" placeholder="User ID" name="userID"/>

          <label>Loan Amount</label>
          <input type="number" placeholder="Loan Amount" name="loanAmount"/>

          <label>Upcharge Percentage%</label>
          <input type="number" placeholder="MPU%" name="missedPayUpch"/>

          <label>Due Date:</label>
          <input type="date" placeholder="NDD" name="nextDueDate" />

          <button type="submit">Create Loan</button>
      </form>
  </div>

  <!-- Money Transfer -->
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

  <!-- Admin Panel -->
  <div class="section">
    <form action="/adminGetUser.php" method="POST">
        <h3>Admin User Management Panel</h3>

        <!-- User Lookup -->
        <div class="sub-heading">Find Specific User</div>

        <label>User ID</label>
        <input type="text" placeholder="Enter User ID" name="userID" />

        <label>(Account Details) <?php echo $_SESSION["AccountDetails"] ?></label>

        <button type="submit">Lookup User</button>
    </form>

    <!-- Deletion Form -->
      <div class="sub-heading">Delete a User Account</div>
      <form action="/adminDeleteUser.php" method="POST">
          <label>User ID</label>
          <input type="text" placeholder="Enter user ID to delete" name="delete-id"/>

          <input type="hidden" name="delete-password" value="adminOverride"/>
          <button type="submit">Confirm Deletion</button>
      </form>
    <!-- Modify User Form -->
    <div class="sub-heading">Change User Details</div>
      <form action="/accountModification.php" method="POST">
            <label>Account ID (Target User)</label>
            <input type="text" placeholder="User Account ID to Modify" name="id" />

            <label>First Name</label>
            <input type="text" placeholder="First Name" name="firstName"/>

            <label>Last Name</label>
            <input type="text" placeholder="Last Name" name="lastName"/>

            <label>Birthday</label>
            <input type="date" placeholder="Birthday" name="birthday"/>

            <label>SSN</label>
            <input type="text" placeholder="SSN" name="ssn" />

            <label>Password</label>
            <input type="password" placeholder="Set/Update Password" name="password"/>

            <button type="submit">Update User</button>
      </form>
  </div>

</div>

</body>
</html>
