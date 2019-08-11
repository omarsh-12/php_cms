<!DOCTYPE html>
<html lang="en">
<?php include "includes/config_db.php" ?>
<?php session_start();?>
<?php ob_start();?>
<?php include 'includes/header.php'?>
<body>

    <!-- Navigation -->

    <?php include 'includes/navigation.php'?>
    <!-- Page Content -->
    <div class="container">
        <?php if (isset($_GET['please']))
        {$please=$_GET['please'];
            ?>
            <div class="alert alert-danger"><?php echo $please;?></div>
            <?php
            header("refresh:4; url=index.php",TRUE,307);
        }else
        {
            $please='';
        }

        ?>
        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <!-- First Blog Post -->
<?php
$per_page=2;
if (isset($_GET['page']))
{
    $page=$_GET['page'];

}
else
{
    $page="";
}
if ($page== "" || $page== 1)
{
    $page1=0;
}
else
{
    $page1=($page*$per_page)-$per_page;
}
?>




                <?php
                $query_post="SELECT * FROM posts";
                $res1_count=mysqli_query($con,$query_post);
               $count=mysqli_num_rows($res1_count);

              $count= ceil($count/$per_page);
               ?>

<?php
                $query1="SELECT * FROM posts WHERE post_status='published' LIMIT $page1,$per_page";
                $res1=mysqli_query($con,$query1);
                while($row1=mysqli_fetch_assoc($res1)) {
                    $post_id=$row1['post_id'];
                    $title = $row1['post_title'];
                    $post_author=$row1['post_author'];
                    $post_date = $row1['post_date'];
                    $image_post = $row1['post_image'];
                    $post_content = $row1['post_content'];
                    $post_status=$row1['post_status'];
                    
               
                    ?>
                    

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>
                    <h2>
                        <a href="post.php?show=<?php echo $post_id;?>"><?php  echo $title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="posts_author.php?post_author=<?php echo $post_author;?>&&show=<?php echo $post_id;?>"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on August <?php echo $post_date; ?></p>
                    <hr>
                    <a href="post.php?show=<?php echo $post_id;?>">
                    <img  height="400px" width="600px" src="images/<?php echo $image_post ;?>" alt="">
                    </a>
                        <hr>
                    <p><?php echo $post_content ;?></p>
                    <a class="btn btn-primary" href="post.php?show=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                    <?php
                }
                ?>


               

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <?php
                        if ($page >1)
                        {?>
                            <a href="index.php?page=<?php echo  $page-1;?>">&larr; Older</a>

                        <?php
                        }
                        ?>
                    </li>
                    <li class="next">
                        <?php
                        if ($page < $count)
                        {?>
                            <a href="index.php?page=<?php echo $page+1;?>">Newer &rarr;</a>

                           <?php
                        }

                      ?>

                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php'?>

        </div>
        <!-- /.row -->

        <hr>
<ul class="pager">
 <?php for ($i=1; $i<=$count; $i++)
     {
         if ($i==$page) {
             echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
         }
         else
         {
             echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
         }

     }?>

</ul>
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
