<script type="text/javascript">
    $(document).ready(function(){
        var page = "<?php echo basename($_SERVER['PHP_SELF'])?>";
        console.log(page);
        $(".cat-nav a[href='"+page+"']").parent().addClass('active');
    });
</script>
<div class="navbar navbar-default navbar-fixed-top">
  <div class=".container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed"
              data-toggle="collapse"
              data-target="#collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="blog.php">
        <img class="cat-blog" src="images/circle-blog.png" alt="brand"
             width="35">
      </a>
    </div>
    <div class="collapse navbar-collapse" id="collapse">
      <ul class="cat-nav nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Contact us</a></li>
        <li><a href="#">Features</a></li>
      </ul>

      <form action="blog.php" class="navbar-form navbar-right">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search"
                 name="search">
          <input type="hidden" class="form-control" placeholder="Search" value="1"
                 name="p">
        </div>
        <button class="btn btn-default">Go</button>
      </form>
    </div>
  </div>
</div>