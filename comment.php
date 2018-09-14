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
        <h1>Comment</h1>
        <div class="">
          <?php
          echo error_message();
          echo success_message();
          ?>
        </div>
        <?php
        $comment_id = $_GET['id'];
        $view_comments_query = "SELECT * FROM comments WHERE id = '$comment_id'";
        $execute = mysqli_query($connection, $view_comments_query);
        $data_row = mysqli_fetch_array($execute)
        ?>
        <div>
          <p><b><?php echo $data_row['name']; ?></b></p>
          <p><?php echo '<b>Wrote:</b> ' . $data_row['comment']; ?></p>
          <p><?php echo '<b>At:</b> ' . $data_row['datetime']; ?></p>
        </div>
        <?php if ($data_row['status'] == 'ON') { ?>
          <a href="approve_comment.php?id=<?php echo $comment_id ?>&flag=true">
            <span class="btn btn-warning">Un-approve</span>
          </a>
        <?php } else { ?>
          <a href="approve_comment.php?id=<?php echo $comment_id ?>">
            <span class="btn btn-warning">Approve</span>
          </a>
        <?php } ?>
        <a href="delete_post.php?id=<?php echo $comment_id ?>">
          <span class="btn btn-danger">Delete</span>
        </a>
        <a href="comments.php">
          <span class="btn btn-primary">Back to all comments comments</span>
        </a>
        <a href="delete_post.php?id=<?php echo $comment_id ?>">
          <span class="btn btn-success">Post</span>
        </a>
      </div>
    </div>
  </div>
<?php require_once('footer.php') ?>