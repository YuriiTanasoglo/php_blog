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
        <h1>Comments</h1>
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
              <th>Name</th>
              <th>Date</th>
              <th>Comment</th>
              <th>Reviewer</th>
              <th>Actions</th>
            </tr>
            <tr>
              <th colspan="6">Un-approved comments:</th>
            </tr>
            <?php
            $get_comments_query = "SELECT * FROM comments WHERE status = 'OFF' ORDER BY datetime DESC";
            $execute = mysqli_query($connection, $get_comments_query);
            $number = 0;
            while ($data_rows = mysqli_fetch_array($execute)) {
              $number++;
              ?>
              <tr>
                <td><?php echo $number ?></td>
                <td><?php echo $data_rows['name'] ?></td>
                <td><?php echo $data_rows['datetime'] ?></td>
                <td><?php echo mb_strimwidth($data_rows['comment'], 0, 50, "..."); ?></td>
                <td><?php echo $data_rows['approved_by'] ?></td>

                <td>
                  <a class="btn btn-warning" href="approve_comment.php?id=<?php echo $data_rows['id'] ?>">Approve</a>
                  <a class="btn btn-danger" href="delete_comment.php?id=<?php echo $data_rows['id'] ?>">Delete</a>
                  <a class="btn btn-primary" href="comment.php?id=<?php echo $data_rows['id'] ?>">Details</a>
                  <a class="btn btn-success" href="post.php?id=<?php echo $data_rows['post_id'] ?>">Post</a>
                </td>
              </tr>

              <?php
            }
            ?>
            <tr>
              <th colspan="6">Approved comments:</th>
            </tr>
            <?php
            $get_comments_query = "SELECT * FROM comments WHERE status = 'ON' ORDER BY datetime DESC";
            $execute = mysqli_query($connection, $get_comments_query);
            $number = 0;
            while ($data_rows = mysqli_fetch_array($execute)) {
              $number++;
              ?>
              <tr>
                <td><?php echo $number ?></td>
                <td><?php echo $data_rows['name'] ?></td>
                <td><?php echo $data_rows['datetime'] ?></td>
                <td><?php echo mb_strimwidth($data_rows['comment'], 0, 50, "..."); ?></td>
                <td><?php echo $data_rows['approved_by'] ?></td>
                <td>
                  <a class="btn btn-warning" href="approve_comment.php?id=<?php echo $data_rows['id'] ?>&flag=true">Un-approve</a>
                  <a class="btn btn-danger" href="delete_comment.php?id=<?php echo $data_rows['id'] ?>">Delete</a>
                  <a class="btn btn-primary" href="comment.php?id=<?php echo $data_rows['id'] ?>">Details</a>
                  <a class="btn btn-success" href="post.php?id=<?php echo $data_rows['post_id'] ?>">Post</a>
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