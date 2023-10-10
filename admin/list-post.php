<?php
include 'layouts/header.php';

$user_id = $_SESSION['is_admin'];

$postsPerPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $postsPerPage;

$query = "SELECT * FROM `Posts` WHERE `User_ID`='$user_id' LIMIT $page, $offset";
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

<h2>Manage Posts</h2>
<?php if (mysqli_num_rows($posts) > 0) : ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Body</th>
      <th scope="col">Date-Time</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
        while ($row = mysqli_fetch_assoc($posts)) :
    ?>
    <tr>
      <td><?php echo $row['Title'] ?></td>
      <td><?php echo $row['Body'] ?></td>
      <td><?php echo date("M d, Y - H:i", strtotime($row['Date_Time'])) ?></td>
      <td><button type="button" class="btn btn-primary"><a href="edit-post.php?<?php $row['ID'] ?>">Edit</a></button></td>
      <td><button type="button" class="btn btn-warning"><a href="delete-post.php?<?php $row['ID'] ?>"></a>Delete</button></td>
    </tr>
    <?php endwhile ?>
  </tbody>

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