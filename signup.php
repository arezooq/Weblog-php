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

$UserExistInDatabase = function ($username) use ($conn) {
  $query = "SELECT * FROM `users` WHERE `Username`='$username'";
  $userExist = mysqli_query($conn, $query);

  if(mysqli_num_rows($userExist) > 0){
    $_SESSION['signup-error'] = "User already exists";
    header('Location: signup.php');
    die("User already exists");
  }
};

$InsertDataToDatabase = function ($fullname, $username, $password) use ($conn) {

  $query = "INSERT INTO `users`(`Full_Name`, `Username`,`Password`) VALUES
        ('$fullname','$username','$password')";
  echo $query;
  mysqli_query($conn, $query);

  if(mysqli_query($conn, $query)) {
        $_SESSION['signup-success'] = "Registered Successfully";
        header('Location: signin.php');
        die;
    }
    else
    {
        $_SESSION['signup-error'] = "Not Inserted";
        header('Location: signup.php');
        die;
    }
};

if (isset($_POST['submit'])) {

    $fullnameErr = $usernameErr = $passwordErr = $confirmPasswordErr = $userExistErr = "";
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!$fullname) {
      $fullnameErr = ValidateData($fullname);
    }

    if (!$username) {
      $usernameErr = ValidateData($username);
    }

    if (!$password || $password) {
      $passwordErr = ValidateData($password);
    }

    $UserExistInDatabase($username);
    $InsertDataToDatabase($fullname, $username, $password);
}
?>

<?php if(isset($_SESSION['signup-error'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['signup-error']; unset($_SESSION['signup-error']); ?></h5>
<?php endif ?>

<h1 class="d-grid gap-2 col-6 mx-auto align-items-center mt-5">Sign Up</h1>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data" class="d-grid gap-2 col-6 mx-auto align-items-center mt-5">
  <div class="mb-3 mt-3">
    <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Enter FullName" aria-labelledby="fullnameHelpBlock"/>
    <div style="color: red;" id="fullnameHelpBlock" class="form-text"><?php echo $fullnameErr;?></div>
  </div>
  <div class="mb-3 mt-3">
    <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username" aria-labelledby="usernameHelpBlock"/>
    <div style="color: red;" id="usernameHelpBlock" class="form-text"><?php echo $usernameErr;?></div>
  </div>
  <div class="mb-3 mt-3">
    <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" aria-labelledby="passwordHelpBlock"/>
    <div style="color: red;" id="passwordHelpBlock" class="form-text"><?php echo $passwordErr;?></div>
  </div>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mx-auto">
    <button type="submit" name="submit" class="btn btn-primary" id="register">Signup</button>
    <a class="btn btn-primary" href="signin.php" role="button">Signin</a>
  </div>
</form>

<?php
include 'layouts/footer.php';
?>

