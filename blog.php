<?php
include 'layouts/header.php';

if (!$_SESSION["signin-success"]) {
  header('Location: signin.php');
  die;
}

$postsPerPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $postsPerPage;

$query = "SELECT * FROM `Posts` LIMIT $page, $offset";
$posts = mysqli_query($conn, $query);


$totalPostsQuery = "SELECT COUNT(*) as total FROM Posts";
$totalPostsResult = $mysqli->query($totalPostsQuery);
$totalPosts = $totalPostsResult->fetch_assoc()['total'];
$totalPages = ceil($totalPosts / $postsPerPage);
?>

<?php if(isset($_SESSION['edit-post-success'])) : ?>
  <h5 class="alert alert-success"><?= $_SESSION['edit-post-success']; unset($_SESSION['edit-post-success']); ?></h5>
<?php elseif(isset($_SESSION['delete-post-success'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['delete-post-success']; unset($_SESSION['delete-post-success']); ?></h5>
<?php elseif(isset($_SESSION['delete-post-error'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['delete-post-error']; unset($_SESSION['delete-post-error']); ?></h5>
<?php endif ?>

<button type="button" class="btn btn-warning"><a href="logout.php"></a>Logout</button>
<?php if (mysqli_num_rows($posts) > 0) : ?>
<table class="table">
  <tbody>
    <?php 
        while ($row = mysqli_fetch_assoc($posts)) :
    ?>
    <a href="post.php?<?php $row['ID'] ?>">
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

    <?php endwhile ?>

  <nav aria-label="...">
  <ul class="pagination">
    <?php
  for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
    }
    ?>
    </ul>
    </nav>
</table>
<?php else : ?>
    <div class="alert__message error"><?php echo "No posts found" ?></div>
<?php endif ?>

<?php
include 'layouts/footer.php';
?>