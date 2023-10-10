<?php
include 'layouts/header.php';
include 'config/dbConfig.php';

$user_id = $_SESSION['is_admin'];
$Post_id = $_GET['ID'];

function ValidateData($validateData) {
  if (empty($validateData)) {
    return "$validateData is required";
  } 
}

$UpdatePostToDatabase = function ($title, $body, $user_id, $Post_id) use ($conn) {

  $query = "UPDATE Posts SET Title = $title, Body = $body WHERE User_ID = $user_id AND ID=$Post_id";
  mysqli_query($conn, $query);

  if(mysqli_query($conn, $query)) {
        $_SESSION['edit-post-success'] = "Edit Post Successfully";
        header('Location: list-post.php');
        die;
    }
    else
    {
        $_SESSION['edit-post-error'] = "Not Updated";
        header('Location: edit-post.php');
        die;
    }
};

if (isset($_POST['submit'])) {

  $titleErr = $bodyErr = "";
  $title = $_POST['title'];
  $body = $_POST['body'];

  if (!$title) {
    $titleErr = ValidateData($title);
  }

  if (!$body) {
    $bodyErr = ValidateData($body);
  }

  $UpdatePostToDatabase($title, $body, $user_id, $Post_id);
}
?>

<?php if(isset($_SESSION['edit-post-error'])) : ?>
  <h5 class="alert alert-error"><?= $_SESSION['edit-post-error']; unset($_SESSION['edit-post-error']); ?></h5>
<?php endif ?>

<h1 class="d-grid gap-2 col-6 mx-auto align-items-center mt-5">Add Post</h1>

<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data" class="d-grid gap-2 col-6 mx-auto align-items-center mt-5">
  <div class="mb-3 mt-3">
    <input type="text" name="title" class="form-control" id="title" placeholder="Title" aria-labelledby="titleHelpBlock"/>
    <div style="color: red;" id="titleHelpBlock" class="form-text"><?php echo $titleErr;?></div>
  </div>
  <div class="form-group">
    <textarea class="form-control" name="body" id="body" rows="3" placeholder="Body" aria-labelledby="bodyHelpBlock"></textarea>
    <div style="color: red;" id="bodyHelpBlock" class="form-text"><?php echo $bodyErr;?></div>
  </div>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3 mx-auto">
    <button type="submit" name="submit" class="btn btn-primary" id="post">Edit Post</button>
  </div>
</form>

<?php
include 'layouts/footer.php';
?>