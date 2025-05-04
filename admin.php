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
    input[type="email"] {
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

    .sub-label {
      color: #444;
      margin: 3px 0;
    }

    .flex-row {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .user-list {
      max-height: 200px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
      background: #fafafa;
      border-radius: 6px;
      margin-bottom: 20px;
    }

    .user-list-item {
      padding: 5px 0;
      border-bottom: 1px solid #ddd;
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
    <p><strong>Name:</strong></p>
    <p><strong>Account Balance:</strong></p>
  </div>

  <!-- Loan Management (Same as User) -->
  <div class="section">
    <h3>Loan Management</h3>
    <div class="loan-item">
      <div class="sub-label"><strong>Loan Amount:</strong> </div>
      <div class="sub-label"><strong>Minimum Due:</strong> </div>
      <div class="sub-label"><strong>Auto Payment:</strong> </div>
      <div class="sub-label"><strong>Auto Payment On:</strong> </div>
      <div class="sub-label"><strong>MPU%:</strong> </div>
      <div class="sub-label"><strong>NDD:</strong> 2025-07-01</div>

      <label>Custom Payment</label>
      <div class="flex-row">
        <input type="number" placeholder="Enter amount" />
        <button type="button">Submit Payment</button>
      </div>
    </div>
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

    <!-- User List -->
    <div class="sub-heading">All Users</div>
    <div class="user-list">
      <div class="user-list-item">User 001 – John </div>
      <div class="user-list-item">User 002 – Sarah </div>
      <div class="user-list-item">User 003 – Mike </div>
      <!-- More users dynamically here -->
    </div>

    <!-- Deletion Form -->
    <div class="sub-heading">Delete a User Account</div>
    <label>User ID</label>
    <input type="text" placeholder="Enter user ID to delete" />

    <label>Admin Password</label>
    <input type="password" placeholder="Re-enter your password to confirm" />

    <button type="button">Confirm Deletion</button>

    <!-- Creation Form -->
    <div class="sub-heading">Create New User Account</div>
    <label>Full Name</label>
    <input type="text" placeholder="Full Name" />

    <label>Email</label>
    <input type="email" placeholder="Email" />

    <label>Password</label>
    <input type="password" placeholder="Set a password" />

    <button type="button">Create Account</button>
  </div>

</div>

</body>
</html>
