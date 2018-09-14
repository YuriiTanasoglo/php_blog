<script type="text/javascript">
    $(document).ready(function () {
        var page = "<?php echo basename($_SERVER['PHP_SELF'])?>";
        $(".cat-admin-nav a[href='" + page + "']").parent().addClass('active');
    });

</script>

<div class="col-sm-2 col-xs-2">
  <ul class="cat-admin-nav side_menu nav nav-pills nav-stacked">
    <li>
      <a class="cat-nav-a text-xs-center" href="dashboard.php">
        <span class="glyphicon glyphicon-th"></span>
        <span class="hidden-xs">Dashboard</span>
      </a>
    </li>
    <li>
      <a class="cat-nav-a text-xs-center" href="add_new_post.php">
        <span class="glyphicon glyphicon-list-alt"></span>
        <span class="hidden-xs">Add new post</span>
      </a>
    </li>
    <li>
      <a class="cat-nav-a text-xs-center" href="categories.php">
        <span class="glyphicon glyphicon-tags"></span>
        <span class="hidden-xs">Categories</span>

      </a>
    </li>
    <li>
      <a class="cat-nav-a text-xs-center" href="admins.php">
        <span class="glyphicon glyphicon-user"></span>
        <span class="hidden-xs">Manage admin</span>
      </a>
    </li>
    <li>
      <a class="cat-nav-a text-xs-center" href="comments.php">
        <span class="glyphicon glyphicon-comment"></span>
        <span class="hidden-xs">
          Comments
          <?php
          $count_total_unapproved_comments_query = "SELECT COUNT(*) FROM comments WHERE status = 'OFF'";
          $count_total_unapproved_comments_execute = mysqli_query($connection, $count_total_unapproved_comments_query);
          $count_total_unapproved_comments = mysqli_fetch_array($count_total_unapproved_comments_execute);
          $count_total_unapproved_comments = array_shift($count_total_unapproved_comments);
          if ($count_total_unapproved_comments) {
            ?>
            <span class="label label-warning">
              <?php echo $count_total_unapproved_comments; ?>
            </span>
            <?php
          }
          ?>
        </span>
      </a></li>
    <li>
      <a class="cat-nav-a text-xs-center" href="#">
        <span class="glyphicon glyphicon-equalizer"></span>
        <span class="hidden-xs">Live blog</span>
      </a></li>
    <li>
      <a class="cat-nav-a text-xs-center" href="logout.php">
        <span class="glyphicon glyphicon-log-out"></span>
        <span class="hidden-xs">Logout</span>
      </a></li>
  </ul>
</div>