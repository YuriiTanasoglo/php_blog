<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
if (isset($_GET['id'])) {

  $id = $_GET['id'];
  $delete_comment_query = "DELETE FROM comments WHERE id='$id'";
  $execute = mysqli_query($connection, $delete_comment_query);
  if ($execute) {
    $_SESSION['success_message'] = 'Successfully deleted';
    redirect_to('comments.php');
  } else {
    $_SESSION['error_message'] = 'Failed to delete the comment!';
    redirect_to('comments.php');
  }

}