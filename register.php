<?php
if (isset($_POST['register'])) {
  require_once './config/db.php';

  //$userName = $_POST['userName'];
  //$userEmail = $_POST['userEmail'];
  //$password = $_POST['password'];
  //Sanitize all data
  $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
  $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
  //Has a password
  $passwordHas = password_hash($password, PASSWORD_DEFAULT);

  //verify if the email data is a valid email
  if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
    //Get all information if of the user table only if the email match with the email in the store
    $stmt = $pdo->prepare('SELECT * from users WHERE email = ?');
    $stmt->execute([$userEmail]);
    //get the number of rows
    $totalUsers = $stmt->rowCount();

    //If the totalUsers is more than zero is because the email is now in the store
    if ($totalUsers > 0) {
      //You can insert the data because the emial attribute is ready in use in the db
      //echo "Email already been taken <br>";
      $emailTaken = "Email already been taken <br>";
    } else {
      //if not you can inset the data
      $stmt = $pdo->prepare('INSERT INTO users(name,email,password) VALUES(?,?,?)');
      $stmt->execute([$userName, $userEmail, $passwordHas]);
    }
    //echo $totalUsers . '<br>';
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
          <br>
          <?php if (isset($emailTaken)) { ?>
            <p class="alert alert-danger"><?php echo $emailTaken ?></p>
          <?php } ?>
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