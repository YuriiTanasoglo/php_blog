<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');

$id = $_GET['id'];

//delete pic
$view_query = "SELECT image FROM post WHERE id = '$id'";
$execute = mysqli_query($connection, $view_query);
$image_data_rows = mysqli_fetch_array($execute);
unlink($image_data_rows['image']);
//end of delete pic

$query = "DELETE FROM post WHERE id='$id'";
$execute = mysqli_query($connection, $query);

if ($execute) {
  $_SESSION['success_message'] = 'Post updated successfully';
} else {
  $_SESSION['error_message'] = 'Post failed to add';
}
redirect_to('dashboard.php');

?>