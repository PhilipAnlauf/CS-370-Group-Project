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
    <p><strong>Account Balance:</strong> $0.00</p>
  </div>

  <!-- Loan Creation -->
  <div class="section">
    <h3>Create Loan for User</h3>

    <label>User ID</label>
    <input type="text" placeholder="User ID" />

    <label>Loan Amount</label>
    <input type="number" placeholder="Loan Amount" />

    <label>Minimum Due</label>
    <input type="number" placeholder="Minimum Amount Due" />

    <label>Auto Payment Amount</label>
    <input type="number" placeholder="Auto Payment Amount" />

    <label>Auto Payment Status (on/off)</label>
    <input type="text" placeholder="Auto Payment Status" />

    <label>MPU%</label>
    <input type="number" placeholder="MPU%" />

    <label>NDD</label>
    <input type="date" placeholder="NDD" />

    <button type="button">Create Loan</button>
  </div>

  <!-- Money Transfer -->
  <div class="section">
    <h3>Send Money</h3>
    <label>Recipient ID</label>
    <input type="text" placeholder="Recipient ID" />

    <label>Amount</label>
    <input type="number" placeholder="Amount to send" />

    <button type="button">Send Money</button>
  </div>

  <!-- Admin Panel -->
  <div class="section">
    <h3>Admin User Management Panel</h3>

    <!-- User Lookup -->
    <div class="sub-heading">Find Specific User</div>

    <label>User ID</label>
    <input type="text" placeholder="Enter User ID" />

    <label>User Name</label>
    <input type="text" placeholder="Enter User Name" />

    <button type="button">Lookup User</button>

    <!-- Deletion Form -->
    <div class="sub-heading">Delete a User Account</div>

    <label>User ID</label>
    <input type="text" placeholder="Enter user ID to delete" />

    <label>Admin Password</label>
    <input type="password" placeholder="Re-enter your password to confirm" />

    <button type="button">Confirm Deletion</button>

    <!-- Modify User Form -->
    <div class="sub-heading">Change User Details</div>

    <label>Account ID (Target User)</label>
    <input type="text" placeholder="User Account ID to Modify" />

    <label>First Name</label>
    <input type="text" placeholder="First Name" />

    <label>Last Name</label>
    <input type="text" placeholder="Last Name" />

    <label>Birthday</label>
    <input type="date" placeholder="Birthday" />

    <label>SSN</label>
    <input type="text" placeholder="SSN" />

    <label>Password</label>
    <input type="password" placeholder="Set/Update Password" />

    <button type="button">Update User</button>
  </div>

</div>

</body>
</html>
