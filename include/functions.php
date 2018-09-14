<?php
function redirect_to($new_location) {
  header('Location:'.$new_location);
  exit;
}
function confirm_login() {
  if(!$_SESSION['id_admin']) {
    $_SESSION['error_message'] = 'Login required!';
    redirect_to('login.php');
  }
}