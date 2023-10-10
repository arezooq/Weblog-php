<?php
session_start();
include 'config/dbConfig.php';

$user_id = $_SESSION['is_admin'];

if (isset($_GET['ID'])) {
    $Post_id = $_GET['ID'];
    $DeletePostToDatabase($Post_id, $user_id);
}

$DeletePostToDatabase = function ($Post_id, $user_id) use ($conn) {
if ($user_id) {
    $query = "DELETE FROM Posts WHERE ID = $Post_id";
    mysqli_query($conn, $query);
  
    if(mysqli_query($conn, $query)) {
          $_SESSION['delete-post-success'] = "Delete Post Successfully";
          header('Location: list-post.php');
          die;
      }
      else
      {
          $_SESSION['delete-post-error'] = "Not Deleted";
          header('Location: list-post.php');
          die;
      }
}
};

?>