<!DOCTYPE html>
<html lang="en">
<?php session_start();?>
<?php include "includes/config_db.php" ?>

<?php include 'includes/header.php'?>
<body>

<!-- Navigation -->

<?php include 'includes/navigation.php'?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <!-- First Blog Post -->
            <?php
            if (isset($_GET['show_cat']))
            {
                $cat_id=$_GET['show_cat'];
            $query1="SELECT * FROM posts where post_category_id='$cat_id'";
            $res1=mysqli_query($con,$query1);
            while($row1=mysqli_fetch_assoc($res1)) {
                $post_id=$row1['post_id'];
                $title = $row1['post_title'];
                $post_author=$row1['post_author'];
                $post_date = $row1['post_date'];
                $image_post = $row1['post_image'];
                $post_content = $row1['post_content'];
                ?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <h2>
                    <a href="post.php?show=<?php echo $post_id;?>"><?php  echo $title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on August <?php echo $post_date; ?></p>
                <hr>
                <img  height="400px" width="600px" src="images/<?php echo $image_post ;?>" alt="">
                <hr>
                <p><?php echo $post_content ;?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
                <?php
            }
            }if (mysqli_num_rows($res1)==0)
            {
            {?>

                <div class="alert alert-success">
                    <h1>Not Posts Yet in this Category</h1>
                </div>

               <?php
            }}
            ?>


            <!-- Second Blog Post -->

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'?>

    </div>
    <!-- /.row -->

    <hr>

    <!-- Footer -->
    <?php include "includes/footer.php"?>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>

