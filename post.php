<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
require_once('head.php');
require_once('header.php');

if (isset($_POST['submit'])) {
  $name = mysql_real_escape_string(htmlspecialchars($_POST['name']));
  $email = mysql_real_escape_string(htmlspecialchars($_POST['email']));
  $comment = mysql_real_escape_string(htmlspecialchars($_POST['comment']));
  $post_id = $_GET['id'];

  if (empty($name)) {
    $_SESSION['error_message'] = 'Name is required';
  } elseif (empty($email)) {
    $_SESSION['error_message'] = 'Email is required';
  } elseif (empty($comment)) {
    $_SESSION['error_message'] = 'Enter the comment';
  } elseif (strlen($comment) > 500) {
    $_SESSION['error_message'] = 'Comment is too long. Comment should be not longer than 500 characters';
  } else {


    $insert_comment_query = "INSERT INTO comments (datetime, name, email, comment, status, post_id)
VALUES ('$date_time', '$name', '$email', '$comment', 'OFF', '$post_id')";

    $execute = mysqli_query($connection, $insert_comment_query);


    if ($execute) {
      $_SESSION['success_message'] = 'Comment will be added after approvement. ';
      redirect_to('post.php?id=' . $post_id);
    } else {
      $_SESSION['error_message'] = 'Comment failed to add';
    }
  }
}
?>
<div class="container cat-main">
  <div class="">
    <?php
    echo error_message();
    echo success_message();
    ?>
  </div>
  <div class="row">
    <div class="col-sm-9">
      <div>
        <?php

        $post_id = $_GET['id'];
        $view_query = "SELECT * FROM post WHERE id = '$post_id' ORDER BY datetime DESC";

        $execute = mysqli_query($connection, $view_query);

        $data_rows = mysqli_fetch_array($execute);
        if (!$data_rows['id']) {
          redirect_to('404.php');
        }
        ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="caption">
              <h1 class="cat-title">
                <a href="post.php?id=<?php echo $data_rows['id']; ?>">
                  <?php echo htmlentities($data_rows['title']); ?>
                </a>
              </h1>
            </div>
          </div>
          <div class="panel-body">
            <div class="thumbnail cat-post-image">
              <img class="img-responsive" src="<?php echo $data_rows['image']; ?>" alt="">
            </div>
            <ul class="list-inline">
              <li class="list-inline-item">Categories:
                <?php
                $id = $data_rows['id'];
                //get the category by id of post
                $id = $data_rows['id'];
                $category_query = "SELECT * FROM category_post JOIN category ON category_post.id_category=category.id WHERE category_post.id_post = $id";
                $category_execute = mysqli_query($connection, $category_query);
                while ($category_rows = mysqli_fetch_array($category_execute)) {
                  ?>
                  <a class="btn btn-primary" href="blog.php?cat=<?php echo $category_rows['name']; ?>">
                    <?php
                    $category = $category_rows['name'];
                    echo $category;
                    ?>
                  </a>
                  <?php
                }
                ?>
                <!--            <a-->
                <!--                href="blog.php?cat=--><?php //echo $data_rows['category']; ?><!--">--><?php //echo htmlentities($data_rows['category']); ?>
                <!--            </a>-->
              </li>
              <li class="list-inline-item cat-float-right">
                <em>
                  Published
                  on <?php echo htmlentities($data_rows['datetime']); ?>
                </em>
              </li>
            </ul>
            <p><?php
              $post = $data_rows['post'];
              echo nl2br($post);
              ?>
            </p>

            <div class="">
              <h2>Comments:</h2>
              <form method="post"
                    action="post.php?id=<?php echo $post_id ?>"
                    enctype="multipart/form-data">
                <fieldset>
                  <div class="form-group">
                    <input id="name"
                           class="form-control"
                           type="text" name="name"
                           placeholder="Name">
                  </div>
                  <div class="form-group">
                    <input id="email"
                           class="form-control"
                           type="email" name="email"
                           placeholder="Email">
                  </div>
                  <div class="form-group">
            <textarea class="form-control" name="comment" id="comment"
                      placeholder="Comment"></textarea>
                  </div>
                  <input
                      class="btn btn-primary btn-block"
                      type="submit" name="submit"
                      value="Add comment">
                  <br>
                </fieldset>
              </form>
              <?php
              $post_id = $_GET['id'];
              $view_comments_query = "SELECT * FROM comments WHERE post_id = '$post_id' AND status = 'ON' ORDER BY datetime DESC";
              $execute = mysqli_query($connection, $view_comments_query);
              $flag = false;
              while ($data_rows = mysqli_fetch_array($execute)) {
                ?>
                <div>
                  <?php
                  if ($flag) {
                    echo '<hr>';
                  } else {
                    $flag = true;
                  }
                  ?>
                  <p><b><?php echo $data_rows['name']; ?></b></p>
                  <p><?php echo '<b>Wrote:</b> ' . nl2br($data_rows['comment']); ?></p>
                  <p><?php echo '<b>At:</b> ' . $data_rows['datetime']; ?></p>

                </div>

                <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <?php require_once('panel.php') ?>
    </div>
  </div>
</div>

<?php
require_once('footer.php');
?>
