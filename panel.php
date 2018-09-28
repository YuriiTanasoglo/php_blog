<div class="panel  panel-default">
  <div class="panel-heading">
    <h2 class="panel-title">Categories</h2>
  </div>
  <div class="panel-body">

    <?php
    $categories_view_query = "SELECT name FROM category";
    $categories_view_execute = mysqli_query($connection, $categories_view_query);
    while ($data_rows = mysqli_fetch_array($categories_view_execute)) {
      ?>
      <a href="<?php echo 'blog.php?cat=' . $data_rows['name'] . '&p=1' ?>">
        <?php echo $data_rows['name'] ?><br>
      </a>
      <?php
    }
    ?>

  </div>
  <div class="panel-footer">

  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h2 class="panel-title">Recent Posts</h2>
  </div>
  <div class="panel-body">
    <?php
    $limit_count = 5;
    $posts_view_query = "SELECT title, id FROM post ORDER BY datetime DESC LIMIT 0, $limit_count";
    $posts_view_execute = mysqli_query($connection, $posts_view_query);
    while ($posts_data_rows = mysqli_fetch_array($posts_view_execute)) {
      ?>
      <a href="<?php echo 'blog.php?id=' . $posts_data_rows['id']?>">
        <?php echo $posts_data_rows['title'] ?><br>
      </a>
      <?php
    }
    ?>
  </div>
  <div class="panel-footer">

  </div>
</div>