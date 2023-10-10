<?php
include 'layouts/header.php';
include 'config/dbConfig.php';

$admin_id = $_SESSION['is_admin'];
$user_id = $_GET['ID'];
$user_logged = $_SESSION['loggedin'];

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
  

$UpdateUserToDatabase = function ($fullname, $username, $password, $admin_id, $user_id, $user_logged, $role) use ($conn) {
  if ($admin_id && $user_logged) {
      $query = "UPDATE users SET Full_Name = $fullname, Username = $username, Password = $password, Roles = $role WHERE ID = $user_id";
      mysqli_query($conn, $query);
    
      if(mysqli_query($conn, $query)) {
            $_SESSION['edit-user-success'] = "Edit User Successfully";
            header('Location: list-user.php');
            die;
        }
        else
        {
            $_SESSION['edit-user-error'] = "Not Updated";
            header('Location: edit-user.php');
            die;
        }
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

    $UpdateDataToDatabase($fullname, $username, $password);
}
?>

<?php if(isset($_SESSION['edit-user-error'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['edit-user-error']; unset($_SESSION['edit-user-error']); ?></h5>
<?php endif ?>

<h1 class="d-grid gap-2 col-6 mx-auto align-items-center mt-5">Edit User</h1>

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
    <button type="submit" name="submit" class="btn btn-primary" id="edit">Edit User</button>
  </div>
</form>

<?php
include 'layouts/footer.php';
?>