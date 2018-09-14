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
  $admin_name = mysql_real_escape_string($_POST['name']);
  $password = mysql_real_escape_string($_POST['password']);
  $confirm_password = mysql_real_escape_string($_POST['confirm_password']);
  if (!empty($admin_name) && !empty($password) && !empty($confirm_password)) {
    if (strlen($admin_name) < 3) {
      $_SESSION['error_message'] = 'Name shouldn\'t be less than 3 letters';
    } elseif (strlen($admin_name) > 100) {
      $_SESSION['error_message'] = 'Name should\'t be more than 100 letters';
    } elseif (strlen($password) < 6) {
      $_SESSION['error_message'] = 'Password shouldn\'t be less than 6 letters';
    } elseif (strlen($password) > 40) {
      $_SESSION['error_message'] = 'Password shouldn\'t be more than 40 letters';
    } elseif ($password !== $confirm_password) {
      $_SESSION['error_message'] = 'Password and Confirm Password do not match';
    } else {
      $add_admin_query = "INSERT INTO admins (datetime, name, password, creator) VALUES ('$date_time', '$admin_name', '$password', '$admin')";
      $add_admin_execute = mysqli_query($connection, $add_admin_query);
      if ($add_admin_execute) {
        $_SESSION['success_message'] = 'Successful added new Admin';
        redirect_to('admins.php');
      } else {
        $_SESSION['error_message'] = 'Admin failed to add';
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
        <h1>Manage Admin</h1>
        <div>
          <div class="">
            <?php
            echo error_message();
            echo success_message();
            ?>
          </div>
          <form method="post"
                action="admins.php">
            <fieldset>
              <div class="form-group">
                <input id="name" class="form-control" type="text" name="name"
                       placeholder="Name">
              </div>
              <div class="form-group">
                <input id="password" class="form-control" type="password" name="password"
                       placeholder="Password">
              </div>
              <div class="form-group">
                <input id="confirm_password" class="form-control" type="password" name="confirm_password"
                       placeholder="Repeat Password">
              </div>
              <input
                  class="btn btn-primary btn-block"
                  type="submit" name="submit"
                  value="Add new Admin">
              <br>

            </fieldset>
          </form>
          <div class="table-responsive">
            <table class="table table-striped table-hover">
              <tr>
                <th>№</th>
                <th>Date & Time</th>
                <th>Name</th>
                <th>Creator</th>
                <th>Action</th>
              </tr>
              <?php
              $view_admins_query = "SELECT * FROM admins ORDER BY datetime desc";
              $view_admins_execute = mysqli_query($connection, $view_admins_query);
              $sr_no = 0;
              while ($view_admins_rows = mysqli_fetch_array($view_admins_execute)) {
                $sr_no++;
                ?>
                <tr>
                  <td><?php echo $sr_no ?></td>
                  <td><?php echo $view_admins_rows['datetime'] ?></td>
                  <td><?php echo $view_admins_rows['name'] ?></td>
                  <td><?php echo $view_admins_rows['creator'] ?></td>
                  <td>
                    <a href="delete_admin.php?id=<?php echo $view_admins_rows['id'] ?>">
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