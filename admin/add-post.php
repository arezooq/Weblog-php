<?php
include 'layouts/header.php';
include 'config/dbConfig.php';

$user_id = $_SESSION['is_admin'];

function ValidateData($validateData) {
  if (empty($validateData)) {
    return "$validateData is required";
  } 
}

$InsertPostToDatabase = function ($title, $body, $user_id) use ($conn) {

  $query = "INSERT INTO `Posts`(`Title`, `Body`,`User_ID`) VALUES
        ('$title','$body','$user_id')";
  echo $query;
  mysqli_query($conn, $query);

  if(mysqli_query($conn, $query)) {
        $_SESSION['add-post-success'] = "Add Post Successfully";
        header('Location: dashboard.php');
        die;
    }
    else
    {
        $_SESSION['add-post-error'] = "Not Inserted";
        header('Location: add-post.php');
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

  $InsertPostToDatabase($title, $body, $user_id);
}
?>

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
    <button type="submit" name="submit" class="btn btn-primary" id="post">Add Post</button>
  </div>
</form>

<?php
include 'layouts/footer.php';
?>