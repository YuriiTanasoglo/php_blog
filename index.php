<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
require_once('head.php');
require_once('header.php');
?>
<div class="container cat-main">
  <div class="row">
    <div class="col-sm-9">

      <?php
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $view_query = "SELECT * FROM post WHERE datetime 
LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%' ORDER BY datetime DESC";
      } else {
        $view_query = "SELECT * FROM post ORDER BY datetime DESC";
      }
      $execute = mysqli_query($connection, $view_query);
      while ($data_rows = mysqli_fetch_array($execute)) {
        ?>
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="caption">
              <h1 class="cat-title">
                <a href="post.php?id=<?php echo $data_rows['id']; ?>">
                  <?php echo htmlentities($data_rows['title']); ?>
                </a>
              </h1>
            </div>
          </div>
          <div class="panel-body">
            <div class="thumbnail cat-post-image">
              <img class="img-responsive"
                   src="<?php echo $data_rows['image']; ?>" alt="">
            </div>
            <ul class="list-inline">
              <li class="list-inline-item">Categories:
                <a href="#">
                  <?php
                  //                get the category by id of post
                  $id = $data_rows['id'];
                  $category_query = "SELECT *
FROM category_post
  JOIN category ON category_post.id_category = category.id
WHERE category_post.id_post = $id";
                  $category_execute = mysqli_query($connection, $category_query);
                  while ($category_rows = mysqli_fetch_array($category_execute)) {
                    ?>
                    <a class="btn btn-primary"
                       href="blog.php?p=0&cat=<?php echo $category_rows['name']; ?>">
                      <?php
                      $category = $category_rows['name'];
                      echo $category;
                      ?>
                    </a>
                    <?php
                  }
                  ?>
                </a>
              </li>
              <li class="list-inline-item pull-right">
                <em>
                  Published
                  on <?php echo htmlentities($data_rows['datetime']); ?>
                </em>
              </li>
            </ul>
            <p><?php
              $post = $data_rows['post'];
              if (strlen($post) > 150) {
                $post = substr($post, 0, 150) . '...';
              }
              echo $post;
              ?>
            </p>
            <a class="btn btn-primary btn-sm" role="button" href="post.php?id<?php echo $data_rows['id']; ?>">
              Read more
            </a>
          </div>


        </div>
        <?php
      }
      ?>
    </div>

    <div class="col-sm-3">
      <?php require_once('panel.php') ?>
    </div>
  </div>
</div>

<?php
require_once('footer.php');
?>
</body>
</html>

