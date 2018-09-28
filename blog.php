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
      $num_of_posts = 5;
      $page = isset($_GET['p']) ? $_GET['p'] : '';
      $start = $page * $num_of_posts - $num_of_posts;
      if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $view_query = "SELECT
  SQL_CALC_FOUND_ROWS
  post.id,
  post.datetime,
  post.title,
  post.author,
  post.image,
  post.post
FROM post
  JOIN category_post
  ON post.id = category_post.id_post
  JOIN category
  ON category_post.id_category = category.id
WHERE post.post LIKE '%$search%'
      OR post.title LIKE '%$search%'
      OR category.name LIKE '%$search%'
ORDER BY post.datetime DESC
LIMIT $start, $num_of_posts;
";
        $count_by = 'search';
      } else if (isset($_GET['cat'])) {
        $cat = $_GET['cat'];
        $view_query = "SELECT
  SQL_CALC_FOUND_ROWS
  post.id,
  post.datetime,
  post.title,
  post.author,
  post.image,
  post.post
FROM post
  JOIN category_post ON post.id = category_post.id_post
  JOIN category ON category_post.id_category = category.id
WHERE category.name = '$cat'
ORDER BY post.datetime DESC
LIMIT $start, $num_of_posts
";
        $count_by = 'cat';
      } else {
        $view_query = "SELECT
SQL_CALC_FOUND_ROWS
*
FROM post
ORDER BY datetime DESC
LIMIT $start, $num_of_posts
";
        $count_by = '';
      }
      $default_link = 'blog.php?' . ($count_by ? $count_by . '=' . $_GET[$count_by] : '') . '&p=1';
      if (!$page) {
        redirect_to($default_link);
      }
      $execute = mysqli_query($connection, $view_query);
      $post_count_query = "SELECT FOUND_ROWS()";
      $post_count_execute = mysqli_query($connection, $post_count_query);
      $post_count_row = mysqli_fetch_array($post_count_execute);
      $post_count = $post_count_row['FOUND_ROWS()'];
      $page_count = ceil($post_count / $num_of_posts);
      if ($page > $page_count) {
        echo "Nothing was found!";
      } elseif ($page < 1) {
        redirect_to($default_link);
      }
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
              <img class="img-responsive" src="<?php echo $data_rows['image']; ?>" alt="">
            </div>
            <ul class="list-inline">
              <li class="list-inline-item">Categories:
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
              echo nl2br($post);
              ?>
            </p>
            <a class="btn btn-primary btn-sm" role="button"
               href="post.php?id=<?php echo $data_rows['id']; ?>">
              Read more
            </a>
          </div>
        </div>
        <?php
      }
      ?>
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <?php if ($_GET['p'] > 1) { ?>
            <li class="page-item">
              <a class="page-link" href="blog.php?<?php echo $count_by ? $count_by . '=' . $_GET[$count_by] : '' ?>&p=<?php echo $page - 1 ?>">&laquo;</a>
            </li>
            <?php
          }

          for ($i = 1; $i <= $page_count; $i++) {
            ?>
            <li class="page-item <?php if ($_GET['p'] == $i) {
              echo 'active';
            } ?>">
              <a class="page-link" href="blog.php?<?php echo $count_by ? $count_by . '=' . $_GET[$count_by] : '' ?>&p=<?php echo $i ?>">
                <?php echo $i ?>
              </a>
            </li>
            <?php
          }
          ?>
          <?php if ($_GET['p'] < $page_count) { ?>
            <li class="page-item">
              <a class="page-link" href="blog.php?<?php echo $count_by ? $count_by . '=' . $_GET[$count_by] : '' ?>&p=<?php echo $page + 1 ?>">&raquo;</a>
            </li>
            <?php
          }
          ?>
        </ul>
      </nav>
    </div>
    <div class="col-sm-3">
      <?php require_once('panel.php') ?>
    </div>
  </div>
</div>

<?php
require_once('footer.php');
?>
