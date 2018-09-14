<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
if (isset($_GET['id'])) {
  $count_admins_query = "SELECT COUNT(*) FROM admins";
  $count_admins_execute = mysqli_query($connection, $count_admins_query);
  $count_admins_rows = mysqli_fetch_assoc($count_admins_execute);
  $admins_count = $count_admins_rows['COUNT(*)'];
  if($admins_count == 1) {
    $_SESSION['error_message'] = 'Should be at least one admin!';
    redirect_to('admins.php');
  } else {
    $id = $_GET['id'];
    $delete_admin_query = "DELETE FROM admins WHERE id = '$id'";

    $delete_admin_execute = mysqli_query($connection, $delete_admin_query);
    if ($delete_admin_execute) {
      $_SESSION['success_message'] = 'Successfully deleted';
      redirect_to('admins.php');
    } else {
      $_SESSION['error_message'] = 'Failed to delete the category!';
      redirect_to('admins.php');
    }
  }
}