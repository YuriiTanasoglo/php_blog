<?php
require_once('include/db.php');
require_once('include/data_time.php');
require_once('include/sessions.php');
require_once('include/functions.php');
require_once('head.php');
require_once('header.php');
?>
<div class="container cat-main">
  <div class="blog header">
    <h1>The complete responsive CMS blog</h1>
    <p class="lead">The complete blog using PHP by Yuriy Cat</p>
  </div>
  <div class="row">
    <div class="col-sm-8">
      <?php
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $view_query = "SELECT * FROM post WHERE datetime 
LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%' ORDER BY datetime DESC";
      } else {
        $view_query = "SELECT * FROM post ORDER BY datetime DESC";
      }
      $execute = mysql_query($view_query);
      while ($data_rows = mysql_fetch_array($execute)) {
        ?>
        <div class="caption">

          <h1 class="cat-title">
            <a href="post.php?id=<?php echo $data_rows['id']; ?>">
              <?php echo htmlentities($data_rows['title']); ?>
            </a>
          </h1>

        </div>
        <div class="thumbnail cat-post-image">
          <img class="img-responsive"
               src="<?php echo $data_rows['image']; ?>" alt="">
        </div>
        <ul class="list-inline">
          <li class="list-inline-item">Category: <a
                href="#"><?php echo htmlentities($data_rows['category']); ?>
            </a></li>
          <li class="list-inline-item navbar-right">
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


        <?php
      }
      ?>
    </div>
    <div class="col-sm-offset-1 col-sm-3">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        Accusantium cupiditate excepturi
        impedit ipsam libero odio tempora? Amet cum facilis laborum
        libero magnam maxime numquam
        officiis soluta temporibus voluptatibus! Dolorum.</p>
    </div>
  </div>
</div>

<?php
require_once('footer.php');
?>
</body>
</html>

