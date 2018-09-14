<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
confirm_login();
require_once('head.php');
require_once('header.php');
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
    $id = $_GET['id'];

//start building query to update the post and relative table
    $update_post_query = "
DELETE FROM category_post WHERE id_post = $id;
UPDATE post 
SET datetime = '$date_time', title = '$title', author = '$admin',  post = '$post'";
//work with path of images
    if ($_FILES['image']['name']) {
      $path = 'upload';
      $image = $_FILES['image']['name'];
      $extension = strtolower(substr(strrchr($image, '.'), 1));

      do {
        $name = md5(microtime() . rand(0, 9999));
        $file = $path . $name . $extension;
      } while (file_exists($file));

      $target = $path . '/' . $name . '.' . $extension;
      move_uploaded_file($_FILES['image']['tmp_name'], $target);

//delete old pic
      $view_query = "SELECT image FROM post WHERE id = '$id'";
      $execute = mysqli_query($connection, $view_query);
      $image_data_rows = mysqli_fetch_array($execute);


      unlink($image_data_rows['image']);
      $update_post_query .= ", image = '$target'";
    }
    $update_post_query .= "WHERE id = '$id';";
//end work with path of images
    $categories = $_POST['categories'];
    $n = count($categories);
    for($i = 0; $i < $n; $i++)
    {
      $update_post_query .= "INSERT INTO category_post (id_category, id_post) VALUES ($categories[$i], $id);";
    }
    $update_post_execute = mysqli_multi_query($connection, $update_post_query);
echo $update_post_query;
    if ($update_post_execute) {
      $_SESSION['success_message'] = 'Post updated successfully';
      sleep(1);
      redirect_to('dashboard.php');
//      header('refresh:3; url=edit_post.php?id=' . $id);
    } else {
      $_SESSION['error_message'] = 'Post failed to add';
    }
  }
}
?>


  <div class="container-fluid">
    <div class="row">
      <?php require_once('admin_nav.php') ?>
      <div class="col-sm-10 col-xs-10 white">
        <h1>Edit post</h1>
        <div>
          <div class=""><?php
            echo error_message();
            echo success_message();
            ?></div>
          <?php
          $id = $_GET['id'];
          $view_post_query = "SELECT * FROM post WHERE id = '$id'";
          $execute = mysqli_query($connection, $view_post_query);
          $view_post_date_rows = mysqli_fetch_array($execute)
          ?>
          <form method="post"
                action="edit_post.php?id=<?php echo $id ?>"
                enctype="multipart/form-data">
            <fieldset>
              <div class="form-group">
                <input id="title"
                       class="form-control"
                       type="text" name="title"
                       placeholder="Title"
                       value="<?php echo $view_post_date_rows['title'] ?>"
                >
              </div>
              <p>Categories: </p>
              <?php
              $view_category_query = "SELECT
  id,
  name
FROM category
";
              $view_category_execute = mysqli_query($connection, $view_category_query);
              $active_category_query = "SELECT id_category, id_post FROM category_post WHERE id_post = $id";
              $active_category_execute = mysqli_query($connection, $active_category_query);
//              print_r(mysqli_fetch_array($active_category_execute));
              $active_category_array = array();
              while ($active_category_rows = mysqli_fetch_array($active_category_execute)){
                array_push($active_category_array, $active_category_rows['id_category'] );
              }



              while ($view_category_rows = mysqli_fetch_array($view_category_execute)) {
                ?>
                <div class="checkbox-inline">
                  <input class="form-check-input"
                         type="checkbox"
                         name="categories[]"
                         value="<?php echo $view_category_rows['id'] ?>"
                         id="<?php echo $view_category_rows['id'] ?>"
                      <?php
                      for($i = 0; $i < count($active_category_array); $i++){

                        if($view_category_rows['id'] == $active_category_array[$i]){
                          echo 'checked';
                        }
                      }
                     
                      ?>
                  >
                  <label class="form-check-label" for="<?php echo $view_category_rows['id'] ?>"
                  >
                    <?php echo $view_category_rows['name'] ?>
                  </label>
                </div>
                <?php
              }
              ?>
              <div class="form-group">
                <input id="image"
                       class="form-control"
                       type="file" name="image"
                >
              </div>
              <div class="form-group">
                <textarea class="form-control" name="post" id="post"
                          placeholder="Post"
                ><?php echo $view_post_date_rows['post'] ?></textarea>
              </div>
              <input
                  class="btn btn-primary btn-block"
                  type="submit" name="submit"
                  value="Update">
              <br>
            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php require_once('footer.php') ?>