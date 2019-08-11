<!DOCTYPE html>
<html lang="en">
<?php session_start();?>
<?php ob_start();?>
<?php include "includes/config_db.php";?>
<?php if (!isset($_SESSION['user_role']))
{


    header("Location: index.php?please='please make login Before show and write comment and share the post'");




}

?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Post - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-post.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<?php include "includes/navigation.php"?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Post Content Column -->
        <div class="col-lg-8">

            <!-- Blog Post -->
            <?php
            if (isset($_GET['show'])) {
                $post_id=$_GET['show'];
                $post_author=$_GET['post_author'];
                $selct_post = "select * from posts where post_author='$post_author'";
                $res_select=mysqli_query($con,$selct_post);
                if ($res_select)
                {
                    while ($row=mysqli_fetch_assoc($res_select)) {
                        $post_id1 = $row['post_id'];
                        $title = $row['post_title'];
                        $date = $row['post_date'];
                        $author = $row['post_author'];
                        $image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_view = $row['post_views_count'];
                        ?>


                        <h1><?php echo $title; ?></h1>

                        <!-- Author -->
                        <p class="lead">
                            by <a href="#"><?php echo $author; ?></a>
                        </p>

                        <hr>

                        <!-- Date/Time -->
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $date; ?></p>

                        <hr>

                        <!-- Preview Image -->
                        <img class="img-responsive" src="images/<?php echo $image; ?>" alt="">

                        <hr>

                        <!-- Post Content -->
                        <p> <?php echo $post_content; ?></p>

                        <hr>
                        <small>
                            view count <i style="color: green;"><?php echo $post_view; ?></i>
                        </small>
                        <hr>
                        <!-- Blog Comments -->

                        <!-- Comments Form -->
                        <div class="well">
                            <h4>Leave a Comment:</h4>
                            <form role="form" method="post">
                                <input type="hidden" name="post_id" value="<?php echo $post_id1; ?>">
                                <div class="form-group">
                                    <label for="author">Author :</label>
                                    <input type="text" class="form-control" name="author">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email : </label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="content">Content :</label>
                                    <textarea class="form-control" name="content" rows="3"></textarea>
                                </div>
                                <button type="submit" name="insert" class="btn btn-primary">Post Comment</button>
                            </form>
                        </div>
                        <?php
                        $comment_query="SELECT * from comments where comment_post_id='$post_id1' AND comment_status='approve' ORDER BY comment_date ASC";
                        $res_comments=mysqli_query($con,$comment_query);
                        if ($res_comments)
                        {
                            while ($row=mysqli_fetch_assoc($res_comments)) {
                                $id = $row['comment_id'];
                                $post_comm = $row['comment_post_id'];
                                $author = $row['comment_author'];
                                $email = $row['comment_email'];
                                $content = $row['comment_content'];
                                $stat = $row['comment_status'];

                                        ?>


                                        <div class="media">

                                            <a class="pull-left" href="#">
                                                <img class="media-object" height="40" width="40"
                                                     src="./images/<?php echo $image; ?>" alt="">
                                            </a>
                                            <div class="media-body">
                                                <h4 class="media-heading"><?php echo $author; ?>
                                                    <small><?php echo $date; ?></small>
                                                </h4>
                                                <?php echo $content; ?>
                                            </div>
                                        </div>


                                        <?php
                                    }

                            }

                        ?>


                        <?php
                    }
                        if (isset($_POST['insert']))
                        {
                            $content=$_POST['content'];
                            $author=$_POST['author'];
                            $email=$_POST['email'];
                            $status="approve";
                            $date=Date('m-d-y');
                            $post_comm_id=$_POST['post_id'];
                            if (!empty($content) && !empty($author) && !empty($email)) {
                                $comm_query = "insert into comments(comment_author,comment_email,comment_post_id,comment_content,comment_status,comment_date) values ('$author','$email','$post_comm_id','$content','$status',now())";
                                $post_query = "UPDATE posts SET post_comment_count= post_comment_count+1 WHERE post_id='$post_comm_id'";
                                $post_query_result = mysqli_query($con, $post_query);
                                $comm_res = mysqli_query($con, $comm_query);
                                if ($comm_res)
                                {?>

                                    <div class="alert alert-success">success insert</div>
                                    <?php

                                }
                                else {
                                    ?>
                                    <div class="alert alert-danger">Fail insert</div>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>

                                <div class="alert alert-danger">the field should is not empty</div>
                                <?php
                            }

                        }


                        ?>
                        <hr>

                        <!-- Posted Comments -->

                        <!-- Comment -->




                        <?php

                    }
                }




            ?>
            <!-- Title -->



            <!-- Comment -->


        </div>

        <!-- Blog Sidebar Widgets Column -->

        <?php include "includes/sidebar.php"?>
        <!-- /.row -->

        <hr><br>
        <?php include "includes/footer.php"?>
    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
