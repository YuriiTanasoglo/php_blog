<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
if(isset($_GET['id'])){
  $admin = $_SESSION['name_admin'];
  if($_GET['flag']) {
    $id = $_GET['id'];
    $approve_comment_query = "UPDATE comments SET status='OFF', approved_by = '$admin' WHERE id='$id'";
    $execute = mysqli_query($connection, $approve_comment_query);
    if($execute) {
      $_SESSION['success_message'] = 'Successfully un-approved';
      redirect_to('comments.php');
    } else {
      $_SESSION['error_message'] = 'Failed to un-approved the comment!';
      redirect_to('comments.php');
    }
  } else {
    $id = $_GET['id'];
    $approve_comment_query = "UPDATE comments SET status='ON', approved_by = '$admin' WHERE id='$id'";
    $execute = mysqli_query($connection, $approve_comment_query);
    if($execute) {
      $_SESSION['success_message'] = 'Successfully approved';
      redirect_to('comments.php');
    } else {
      $_SESSION['error_message'] = 'Failed to approve the comment!';
      redirect_to('comments.php');
    }
  }
}