<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
require_once('head.php');
require_once('header.php');
$admin = 'Yuriy Cat';
if (isset($_POST['submit'])) {
  $admin_name = mysql_real_escape_string($_POST['name']);
  $admin_password = mysql_real_escape_string($_POST['password']);
  if (!empty($admin_name) && !empty($admin_password)) {
    if (strlen($admin_name) < 3) {
      $_SESSION['error_message'] = 'Name shouldn\'t be less than 3 letters';
    } elseif (strlen($admin_name) > 100) {
      $_SESSION['error_message'] = 'Name should\'t be more than 100 letters';
    } elseif (strlen($admin_password) < 6) {
      $_SESSION['error_message'] = 'Password shouldn\'t be less than 6 letters';
    } elseif (strlen($admin_password) > 40) {
      $_SESSION['error_message'] = 'Password shouldn\'t be more than 40 letters';
    } else {
      $login_admin_query = "SELECT * FROM admins WHERE name = '$admin_name'";
      $login_admin_execute = mysqli_query($connection, $login_admin_query);
      if ($login_admin = mysqli_fetch_assoc($login_admin_execute)) {
        if ($login_admin['password'] == $admin_password) {
          $_SESSION['id_admin'] = $login_admin['id'];
          $_SESSION['name_admin'] = $login_admin['name'];
          $_SESSION['success_message'] = 'Welcome, ' . $_SESSION['name_admin'];
          redirect_to('dashboard.php');
        } else {
          $_SESSION['error_message'] = 'Wrong password';
          redirect_to('login.php');
        }
      } else {
        $_SESSION['error_message'] = 'Name doesn\'t exist';
        redirect_to('login.php');
      }
    }
  } else {
    $_SESSION['error_message'] = 'All fields must be filled out';
  }
}
?>
  <div class="cat-login-main container-fluid">
    <div class="row">
      <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 col-xs-offset-2 col-xs-8 white">
        <h1 class="text-center">Welcome</h1>
        <div>
          <div class="">
            <?php
            echo error_message();
            echo success_message();
            ?>
          </div>
          <form method="post"
                action="login.php">
            <fieldset>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon ">
                    <span class="glyphicon glyphicon-user text-primary"></span>
                  </div>
                  <input id="name" class="form-control" type="text" name="name"
                         placeholder="Name">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-addon ">
                    <span class="glyphicon glyphicon-lock text-primary"></span>
                  </div>
                  <input id="password" class="form-control" type="password" name="password"
                         placeholder="Password">
                </div>
              </div>
              <input
                  class="btn btn-info btn-block"
                  type="submit" name="submit"
                  value="Login">
              <br>

            </fieldset>
          </form>
        </div>
      </div>
    </div>
  </div>

<?php require_once('footer.php') ?>