<?php
include 'layouts/header.php';

$user_id = $_SESSION['is_admin'];

$usersPerPage = 10;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $usersPerPage;

$query = "SELECT * FROM `users` WHERE `ID`='$user_id' LIMIT $page, $offset";
$users = mysqli_query($conn, $query);


$totalUsersQuery = "SELECT COUNT(*) as total FROM users";
$totalUsersResult = $mysqli->query($totalUsersQuery);
$totalUsers = $totalUsersResult->fetch_assoc()['total'];
$totalPages = ceil($totalUsers / $usersPerPage);
?>

<?php if(isset($_SESSION['edit-user-success'])) : ?>
  <h5 class="alert alert-success"><?= $_SESSION['edit-user-success']; unset($_SESSION['edit-user-success']); ?></h5>
<?php elseif(isset($_SESSION['delete-user-success'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['delete-user-success']; unset($_SESSION['delete-user-success']); ?></h5>
<?php elseif(isset($_SESSION['delete-user-error'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['delete-user-error']; unset($_SESSION['delete-user-error']); ?></h5>
<?php endif ?>

<h2>List Users</h2>
<?php if (mysqli_num_rows($users) > 0) : ?>
<table class="table">
  <thead>
    <tr>
      <th scope="col">FullName</th>
      <th scope="col">Username</th>
      <th scope="col">Edit</th>
      <th scope="col">Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
        while ($row = mysqli_fetch_assoc($users)) :
    ?>
    <tr>
      <td><?php echo $row['Full_Name'] ?></td>
      <td><?php echo $row['Username'] ?></td>
      <td><button type="button" class="btn btn-primary"><a href="edit-user.php?<?php $row['ID'] ?>">Edit</a></button></td>
      <td><button type="button" class="btn btn-warning"><a href="delete-user.php?<?php $row['ID'] ?>"></a>Delete</button></td>
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
    <div class="alert__message error"><?php echo "No users found" ?></div>
<?php endif ?>

<?php
include 'layouts/footer.php';
?>