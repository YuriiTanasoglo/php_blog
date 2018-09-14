<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
confirm_login();
$admin = $_SESSION['name_admin'];
if (isset($_POST['submit'])) {
  $title = mysql_real_escape_string($_POST['title']);
  $post = mysql_real_escape_string($_POST['post']);

  if (empty($title)) {
    $_SESSION['error_message'] = 'Title shouldn\'t be empty';
  } elseif (strlen($title) < 2) {
    $_SESSION['error_message'] = 'Title\'s length shouldn be at least 2 characters';
  } elseif (empty($post)) {
    $_SESSION['error_message'] = 'Post shouldn\'t be empty';
  } elseif (strlen($post) > 10000) {
    $_SESSION['error_message'] = 'Post is too long. Post should be not longer than 10000 characters';
  } else {

//work with path of images
    $path = 'upload';
    $image = $_FILES['image']['name'];
    $extension = strtolower(substr(strrchr($image, '.'), 1));

    do {
      $name = md5(microtime() . rand(0, 9999));
      $file = $path . $name . $extension;
    } while (file_exists($file));

    $target = $path . '/' . $name . '.' . $extension;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
//end work with path of images
//    building first part of query
    $add_post_query = "
INSERT INTO post (datetime, title, author, image, post) 
VALUES ('$date_time', '$title', '$admin', '$target', '$post');
SET @id = LAST_INSERT_ID();
";
    //    adding categories
    $categories = $_POST['categories'];
    $n = count($categories);
    for($i = 0; $i < $n; $i++)
    {
      $add_post_query .= "INSERT INTO category_post (id_category, id_post) VALUES ($categories[$i], @id);";
    }
//    end adding categories
    $add_post_execute = mysqli_multi_query($connection, $add_post_query);

    if ($add_post_execute) {
      $_SESSION['success_message'] = 'Post added successfully';
      redirect_to('add_new_post.php');
    } else {
      echo mysqli_error($connection);
      $_SESSION['error_message'] = 'Post failed to add';
    }
  }
}
?>

<?php require_once('head.php') ?>
<?php require_once('header.php') ?>
  <div class="container-fluid">
    <div class="row">
      <?php require_once('admin_nav.php') ?>
      <div class="col-sm-10 col-xs-10 white">
        <h1>Add new post</h1>
        <div>
          <div class=""><?php
            echo error_message();
            echo success_message();
            ?></div>
          <form method="post"
                action="add_new_post.php"
                enctype="multipart/form-data">
            <fieldset>
              <div class="form-group">
                <input id="title"
                       class="form-control"
                       type="text" name="title"
                       placeholder="Title">
              </div>
              <p>Categories: </p>
              <?php
              $view_query = "SELECT id, name FROM category";
              $execute = mysqli_query($connection, $view_query);
              while ($date_rows = mysqli_fetch_array($execute)) {
                ?>
                <div class="checkbox-inline">
                  <input class="form-check-input"
                         type="checkbox"
                         name="categories[]"
                         value="<?php echo $date_rows['id'] ?>"
                         id="<?php echo $date_rows['id'] ?>"
                      >
                  <label class="form-check-label" for="<?php echo $date_rows['id'] ?>">
                    <?php echo $date_rows['name'] ?>
                  </label>
                </div>
                <?php
              }
              ?>
              <div class="form-group">
                <input id="image"
                       class="form-control"
                       type="file" name="image">
              </div>
              <div class="form-group">
                <textarea class="form-control" name="post" id="post"
                          placeholder="Post"></textarea>
              </div>
              <input
                  class="btn btn-primary btn-block"
                  type="submit" name="submit"
                  value="Add new Post">
              <br>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php require_once('footer.php') ?>