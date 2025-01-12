<?php include('connect.php');?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" href="registration.css">
</head>
<body>
  <div class="header">
        <h2>Register</h2>
  </div>
        
  <form method="post" action="connect.php">
        <div class="input-group">
          <label>Username</label>
          <input type="text" name="username" id="username" required>
        </div>
        <div class="input-group">
          <label>Email</label>
          <input type="email" name="email" id="email" required>
        </div>
        <div class="input-group">
          <label>Password</label>
          <input type="password" id="password" name="password" required>
        </div>
        <div class="input-group">
          <label>Confirm password</label>
          <input type="password" id="confirmpassword" name="confirmpassword" required>
        </div>
        <div class="input-group">
          <button type="submit" value="Register">Register</button>
        </div>
  </form>
</body>
</html>
