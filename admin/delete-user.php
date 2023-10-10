<?php
session_start();
include 'config/dbConfig.php';

$admin_id = $_SESSION['is_admin'];
$user_logged = $_SESSION['loggedin'];

if (isset($_GET['ID'])) {
    $user_id = $_GET['ID'];
    $DeleteUserToDatabase($Post_id, $user_id, $user_logged);
}

$DeleteUserToDatabase = function ($admin_id, $user_id, $user_logged) use ($conn) {
if ($admin_id && $user_logged) {
    $query = "DELETE FROM users WHERE ID = $user_id";
    mysqli_query($conn, $query);
  
    if(mysqli_query($conn, $query)) {
          $_SESSION['delete-user-success'] = "Delete User Successfully";
          header('Location: list-user.php');
          die;
      }
      else
      {
          $_SESSION['delete-user-error'] = "Not Deleted";
          header('Location: list-user.php');
          die;
      }
}
};

?>