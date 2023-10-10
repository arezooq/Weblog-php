<?php
include 'layouts/header.php';
include 'config/dbConfig.php';

function ValidateData($validateData) {
  if (empty($validateData)) {
    return "$validateData is required";
  } 
  if ($validateData === $_POST["password"]) {
      if (strlen($validateData) < 8) {
        return 'Password should be at least 8 characters in length';
      }
  }
}

$CheckPassword = function ($username, $password) use ($conn) {
  $query = "SELECT * FROM `users` WHERE `Username`='$username'";
  $userExist = mysqli_query($conn, $query);

  if(mysqli_num_rows($userExist) > 0){
    $row = $userExist->fetch_assoc();
    $_SESSION['signin-success'] = $row['ID'];
    echo "Iiii";
    if ($row['Password'] === $password) {
      if ($row['Roles'] === 'admin') {
        $_SESSION['is_admin'] = $row['ID'];
        $_SESSION['loggedin'] = true;
        header('Location: ./admin/dashboard.php');
      } else {
        $_SESSION['loggedin'] = true;
        header('Location: blog.php');
      }
    } else {
      $_SESSION['signin-error'] = "User or Password does not exists";
      header('Location: signin.php');
      die;
    }
  }
};

if (isset($_POST['submit'])) {

  $usernameErr = $passwordErr = $confirmPasswordErr = $userExistErr = "";
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (!$username) {
    $usernameErr = ValidateData($username);
  }

  if (!$password || $password) {
    $passwordErr = ValidateData($password);
  }

  $CheckPassword($username, $password);

}

?>

<?php if(isset($_SESSION['signup-success'])) : ?>
  <h5 class="alert alert-success"><?= $_SESSION['signup-success']; unset($_SESSION['signup-suuccess']); ?></h5>
<?php elseif(isset($_SESSION['signin-error'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['signin-error']; unset($_SESSION['signin-error']); ?></h5>
<?php endif ?>

<h1 class="d-grid gap-2 col-6 mx-auto align-items-center mt-5">Sign In</h1>

<form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" class="d-grid gap-2 col-6 mx-auto align-items-center mt-5">
  <div class="mb-3 mt-3">
    <input type="text" class="form-control" name="username" id="username" aria-labelledby="usernameHelpBlock" placeholder="Enter Username"/>
    <div style="color: red;" id="usernameHelpBlock" class="form-text"><?php echo $usernameErr;?></div>
  </div>
  <div class="mb-3 mt-3">
    <input type="password" class="form-control" name="password" id="password" aria-labelledby="passwordHelpBlock" placeholder="Enter Password"/>
    <div style="color: red;" id="passwordHelpBlock" class="form-text"><?php echo $passwordErr;?></div>
  </div>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mx-auto">
    <button type="submit" name="submit" class="btn btn-primary" id="signin">
      Sign In
    </button>
    <a class="btn btn-primary" href="signup.php" role="button">Signup</a>
  </div>
</form>

<?php
include 'layouts/footer.php';
?>

