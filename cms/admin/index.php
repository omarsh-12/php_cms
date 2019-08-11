<!DOCTYPE html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<html lang="en">
<?php include "../includes/config_db.php"?>
<?php include "includes/header.php";?>
<?php session_start();?>
<?php ob_start();?>
<?php
$role=$_SESSION['user_role'];
if (!isset($role))
{
    header("Location: ../index.php");


}
if ($role !=="admin")
{
    header("Location: ../index.php");
}
?>
<div id="wrapper">

    <!-- Navigation -->
    <?php
function online_users()
{
    global $con;
    $session = session_id();
    $time = time();
    $time_out_second = 30;
    $time_out = time() - $time_out_second;

    $query_user_online = "select *from users_online where session='$session'";
    $send_query = mysqli_query($con, $query_user_online);
    $count = mysqli_num_rows($send_query);
    if ($count == NULL) {
        mysqli_query($con, "insert into users_online(session,time) values('$session','$time')");
    } else {
        mysqli_query($con, "update users_online set time='$time' where session='$session'");
    }
    $users_online_select = mysqli_query($con, "select *from users_online where time > $time_out");
    return $users_online_count = mysqli_num_rows($users_online_select);
}?>
    <?php include 'includes/navigation.php'?>
    <div id="page-wrapper" >

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header text-center">
                        Welcome To Admin
                        <small><a href="profile.php"><?php echo $_SESSION['username'];?></a> </small>

                    </h1>



                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'>
                                        <?php
                                        $posts_query="select * from posts";
                                        $res_query_posts=mysqli_query($con,$posts_query);
                                        $counts_posts=mysqli_num_rows($res_query_posts);
                                        echo $counts_posts;
                                        ?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'>
                                        <?php
                                        $comments_query="select * from comments";
                                        $res_query_comments=mysqli_query($con,$comments_query);
                                        $counts_comments=mysqli_num_rows($res_query_comments);
                                        echo $counts_comments;
                                        ?>
                                    </div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'>
                                        <?php
                                        $users_query="select * from users";
                                        $res_query_users=mysqli_query($con,$users_query);
                                        $counts_users=mysqli_num_rows($res_query_users);
                                        echo $counts_users;
                                        ?>

                                    </div>
                                    <div> Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class='huge'>
                                        <?php
                                        $categories_query="select * from categories";
                                        $res_query_cat=mysqli_query($con,$categories_query);
                                        $counts_categories=mysqli_num_rows($res_query_cat);
                                        echo $counts_categories;
                                        ?>
                                    </div>
                                    <div>Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

      <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([

                    ['data', 'count'],
                    ['posts',<?php echo $counts_posts;?>],
                    ['users', <?php echo $counts_users;?>],
                    ['comments', <?php echo $counts_comments;?>],
                    ['categories', <?php echo $counts_categories;?>]
                ]);

                var options = {
                    chart: {
                        title: 'Cms Blog',
                        subtitle: 'users, posts, and comments, and categories',
                    }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>
        </head>
        <body>
        <div id="columnchart_material" style="width:auto; height: 500px;"></div>
        </body>

    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/footer.php'?>