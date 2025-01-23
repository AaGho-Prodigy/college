<?php include('connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration System</title>
  <link rel="stylesheet" href="registration.css">
</head>
<body>
  <div class="header">
    <h2>Register</h2>
  </div>
  
  <form method="post" action="register_user.php">
    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username" required>
    </div>
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>
    <div class="input-group">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>
    <div class="input-group">
      <label>Confirm Password</label>
      <input type="password" name="confirmpassword" required>
    </div>
    <div class="input-group">
      <button type="submit" name="register">Register</button>
    </div>
  </form>
</body>
</html>
