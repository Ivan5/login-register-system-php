<?php
session_start();

if (isset($_POST['login'])) {
  require_once './config/db.php';

  //Sanitize all data
  $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

  $stmt = $pdo->prepare('SELECT * FROM users WHERE email= ? ');
  $stmt->execute([$userEmail]);
  $user = $stmt->fetch();

  if (isset($user)) {
    if (password_verify($password, $user->password)) {
      $_SESSION['userId'] = $user->id;
      header('Location: http://localhost/loginRegister/index.php');
    } else {
      $wrongLogin = 'The login email or password is wrong';
    }
  }
}
?>


<?php require('./inc/header.html'); ?>

<div class="container">
  <div class="card bg-light mb-3">
    <div class="card-header">
      Login
    </div>
    <div class="card-body">
      <form action="login.php" method="POST">
        <div class="form-group">
          <label for="userEmail">Email</label>
          <input type="email" name="userEmail" class="form-control" required>
          <br>
          <?php if (isset($wrongLogin)) { ?>
            <p class="alert alert-danger"><?php echo $wrongLogin ?></p>
          <?php } ?>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button name="login" type="submit" class="btn btn-primary btn-block">Login</button>
      </form>
    </div>
  </div>

</div>

<?php require('./inc/footer.html'); ?>