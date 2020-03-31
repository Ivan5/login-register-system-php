<?php
if (isset($_POST['register'])) {
  require_once './config/db.php';

  //$userName = $_POST['userName'];
  //$userEmail = $_POST['userEmail'];
  //$password = $_POST['password'];
  $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
  $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    echo $userEmail . " " . $userName . " " . $password . " ";
  }

  //echo $userName . ' ' . $userEmail . ' ' . $password;
}
?>

<?php require('./inc/header.html'); ?>

<div class="container">
  <div class="card bg-light mb-3">
    <div class="card-header">
      Register
    </div>
    <div class="card-body">
      <form action="register.php" method="POST">
        <div class="form-group">
          <label for="userName">Username</label>
          <input type="text" name="userName" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="userEmail">Email</label>
          <input type="email" name="userEmail" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button name="register" type="submit" class="btn btn-primary btn-block">Register</button>
      </form>
    </div>
  </div>

</div>

<?php require('./inc/footer.html'); ?>