<?php
session_start();

if (isset($_SESSION['userId'])) {
  require_once './config/db.php';

  $userId = $_SESSION['userId'];

  if (isset($_POST['edit'])) {
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
    $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
    $stmt = $pdo->prepare('UPDATE users SET name = ?, emial = ? WHERE id = ?');
    $stmt->execute([$userName, $userEmail, $userId]);
  }

  $stmt = $pdo->prepare('SELECT * from users WHERE id = ?');
  $stmt->execute([$userId]);

  $user = $stmt->fetch();
}

?>

<?php require('./inc/header.html'); ?>

<div class="container">
  <div class="card bg-light mb-3">
    <div class="card-header">
      Update your Details
    </div>
    <div class="card-body">
      <form action="profile.php" method="POST">
        <div class="form-group">
          <label for="userName">Username</label>
          <input type="text" name="userName" class="form-control" value="<?php echo $user->name ?>">
        </div>
        <div class="form-group">
          <label for="userEmail">Email</label>
          <input type="email" name="userEmail" class="form-control" value="<?php echo $user->email ?>">
          <br>
          <?php if (isset($emailTaken)) { ?>
            <p class="alert alert-danger"><?php echo $emailTaken ?></p>
          <?php } ?>
        </div>
        <button name="edit" type="submit" class="btn btn-warning btn-block">Update Details</button>
      </form>
    </div>
  </div>

</div>

<?php require('./inc/footer.html'); ?>