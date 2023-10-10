<?php
include 'layouts/header.php';

if (!$_SESSION["signin-success"]) {
  header('Location: signin.php');
  die;
}
$post_id = $_GET['ID'];
$query = "SELECT * FROM `Posts` WHERE ID=$post_id";
$posts = mysqli_query($conn, $query);
?>

<table class="table">
  <tbody>
    <?php 
    $row = mysqli_fetch_assoc($posts);
    ?>
    <div class="row">
    <div class="col-6 col-md-4 items">
      Title: <?php echo $row['Title'] ?>
      Body: <?php echo $row['Body'] ?>
      data-time: <?php echo date("M d, Y - H:i", strtotime($post['Date_Time'])) ?>
    </div>
    <?php
      $id = $row['User_ID'];
      $query = "SELECT * FROM `users` WHERE `ID`='$id'";
      $users = mysqli_query($conn, $query);
      $user = mysqli_fetch_assoc($users)
    ?>
    <div class="user-info">
          FullName: <?php echo $user['Full_Name'] ?>
    </div>
    </div>
    </a>
</table>

<?php
include 'layouts/footer.php';
?>