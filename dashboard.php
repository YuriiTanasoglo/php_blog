<?php
require_once('include/db.php');
require_once('include/sessions.php');
require_once('include/functions.php');
confirm_login();
require_once('head.php');
require_once('header.php');
?>
  <div class="container-fluid cat-main">
    <div class="row">
      <?php require_once('admin_nav.php') ?>
      <div class="col-sm-10 col-xs-10 white">
        <h1>Admin dashboard</h1>
        <div class="">
          <?php
          echo error_message();
          echo success_message();
          ?>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <tr>
              <th>№</th>
              <th>Title</th>
              <th>Date & Time</th>
              <th>Author</th>
              <th>Image</th>
              <th>Category</th>
              <th>Comments</th>
              <th>Action</th>
            </tr>
            <?php
            $post_query = "SELECT * FROM post ORDER BY datetime DESC";
            $post_execute = mysqli_query($connection, $post_query);
            $number = 0;
            while ($post_rows = mysqli_fetch_array($post_execute)) {
              $id = $post_rows['id'];
              $number++
              ?>
              <tr>
                <td><?php echo $number ?></td>
                <td><?php echo $post_rows['title'] ?></td>
                <td><?php echo $post_rows['datetime'] ?></td>
                <td><?php echo $post_rows['author'] ?></td>
                <td><img src="<?php echo $post_rows['image'] ?>"
                         alt="" height="40px"></td>
                <td>
                  <?php
                  $category_query = "SELECT * FROM category_post JOIN category ON category_post.id_category=category.id WHERE category_post.id_post = $id";
                  $category_execute = mysqli_query($connection, $category_query);
                  $flag = false;
                  while ($category_rows = mysqli_fetch_array($category_execute)) {
                    ?>
                    <?php
                    if ($flag) {
                      echo '<span>, </span>';
                    } else {
                      $flag = true;
                    }
                    ?>
                    <a href="blog.php?p=1&cat=<?php echo $category_rows['name']; ?>">
                      <?php
                      echo  $category_rows['name'];
                      ?>
                    </a>
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $count_approved_comments_query = "SELECT COUNT(*) FROM comments WHERE post_id = '$id' AND status = 'ON'";
                  $count_approved_comments_execute = mysqli_query($connection, $count_approved_comments_query);
                  $count_approved_comments = mysqli_fetch_array($count_approved_comments_execute);
                  $count_approved_comments = array_shift($count_approved_comments);
                  if ($count_approved_comments) {
                    ?>
                    <span class="label label-success pull-right">
                        <?php echo $count_approved_comments; ?>
                      </span>
                    <?php
                  }
                  ?>
                  <?php
                  $count_unapproved_comments_query = "SELECT COUNT(*) FROM comments WHERE post_id = '$id' AND status = 'OFF'";
                  $count_unapproved_comments_execute = mysqli_query($connection, $count_unapproved_comments_query);
                  $count_unapproved_comments = mysqli_fetch_array($count_unapproved_comments_execute);
                  $count_unapproved_comments = array_shift($count_unapproved_comments);
                  if ($count_unapproved_comments) {
                    ?>
                    <span class="label label-danger pull-left">
                        <?php echo $count_unapproved_comments; ?>
                    </span>
                    <?php
                  }
                  ?>
                </td>
                <td>
                  <a class="btn btn-warning" href="edit_post.php?id=<?php echo $post_rows['id'] ?>">Edit</a>
                  <a class="btn btn-danger" href="delete_post.php?id=<?php echo $post_rows['id'] ?>">Delete</a>
                  <a class="btn btn-primary" href="post.php?id=<?php echo $post_rows['id'] ?>" target="_blank">Preview</a>
                </td>
              </tr>
              <?php
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php require_once('footer.php') ?>