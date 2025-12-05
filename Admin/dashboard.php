<?php
require 'auth_check.php'; // must be at the very top
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; background: #fafafa; }
    header {
      background: #722525;
      color: #fff;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    main {
      padding: 20px;
    }
    a.logout {
      color: #fff;
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <header>
    <div>Admin Panel</div>
    <div>
      Logged in as: <strong><?= htmlspecialchars($_SESSION['admin_username']) ?></strong>
      &nbsp; | &nbsp;
      <a href="logout.php" class="logout">Logout</a>
    </div>
  </header>

  <main>
    <h1>Dashboard</h1>
    <p>Add your admin features here (manage content, images, projects, etc.).</p>
  </main>
</body>
</html>
