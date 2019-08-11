<!DOCTYPE html>
<html lang="en">
<?php session_start();?>
<?php ob_start();?>
<?php include "../includes/config_db.php"?>
<?php include "includes/header.php";?>

    <div id="wrapper">
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

        <!-- Navigation -->
<?php include 'includes/navigation.php'?>

        <div id="page-wrapper" >

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header text-center">
                            Welcome To Admin
                            <small><a href="profile.php"><?php echo $_SESSION['username'];?></a></small>
                        </h1>
                        <?php include 'view_all_comments.php'?>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

   <?php include 'includes/footer.php'?>