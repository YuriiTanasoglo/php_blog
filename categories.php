<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
require_once('head.php');
require_once('header.php');
$admin = $_SESSION['name_admin'];
if (isset($_POST['submit'])) {
  $category = mysql_real_escape_string($_POST['category']);
  if (!empty($category)) {
    if (strlen($category) < 3) {
      $_SESSION['error_message'] = 'Should be more than 2 letters';
    } elseif (strlen($category) > 40) {
      $_SESSION['error_message'] = 'Should be not more than 40 letters';
    } else {
      $query = "INSERT INTO category (datetime, name, creator) VALUES ('$date_time', '$category', '$admin')";
      $execute = mysqli_query($connection, $query);
      if ($execute) {
        $_SESSION['success_message'] = 'Successful added new category';
        redirect_to('categories.php');
      } else {
        $_SESSION['error_message'] = 'Category failed to add';
      }

    }
  } else {
    $_SESSION['error_message'] = 'All fields must be filled out';
  }
}
?>
  <div class="container-fluid">
    <div class="row">
      <?php require_once('admin_nav.php') ?>
      <div class="col-sm-10 col-xs-10 white">
        <h1>Manage Categories</h1>
        <div>
          <div class="">
            <?php
            echo error_message();
            echo success_message();
            ?>
          </div>
          <form method="post"
                action="categories.php">
            <fieldset>
              <div class="form-group">
                <input id="category"
                       class="form-control"
                       type="text" name="category"
                       placeholder="Category Name">
              </div>
              <input
                  class="btn btn-primary btn-block"
                  type="submit" name="submit"
                  value="Add new Category">
              <br>

            </fieldset>
          </form>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>№</th>
                <th>Date & Time</th>
                <th>Category Name</th>
                <th>Creator</th>
                <th>Action</th>
              </tr>
              <?php
              $view_query = "SELECT * FROM category ORDER BY datetime desc";
              $execute = mysqli_query($connection, $view_query);
              $sr_no = 0;
              while ($date_rows = mysqli_fetch_array($execute)) {
                $sr_no++;
                ?>
                <tr>
                  <td><?php echo $sr_no ?></td>
                  <td><?php echo $date_rows['datetime'] ?></td>
                  <td>
                    <a href="blog.php?p=1&cat=<?php echo $date_rows['name']; ?>">
                      <?php
                      echo  $date_rows['name'];
                      ?>
                    </a>
                  <td><?php echo $date_rows['creator'] ?></td>
                  <td>
                    <a href="delete_category.php?id=<?php echo $date_rows['id'] ?>">
                      <span class="btn btn-danger">Delete</span>
                    </a>
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
  </div>

<?php require_once('footer.php') ?>