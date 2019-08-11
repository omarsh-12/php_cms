<!DOCTYPE html>

<html lang="en">
<?php session_start();?>
<?php
$user_name=$_SESSION['username'];
if (!isset($user_name))
{

    header("Location: ../index.php");

}

?>
<?php include "../includes/config_db.php"?>
<?php  include "includes/select_cat.php"?>
<?php  include "includes/update_category.php";?>
<?php include "includes/delete_cat.php";?>
<?php include 'includes/insert_cat.php';?>
<?php include "includes/header.php";?>
<?php ob_start();?>
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
    <?php include 'includes/navigation.php' ?>
    <div id="page-wrapper">

        <d class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header text-center">
                        Welcome To Admin
                        <small><a href="profile.php"><?php echo $_SESSION['username'];?></a></small>
                    </h1>

                            <div class="col-md-4 "style="margin-top: 20px;">
                                <?php
                                    insert_cat();
                                ?>
                                <form action="categories.php" method="post">
                                    <div class="form-group">
                                        <label for="category">Category</label>
                                        <input type="text" name="title" class="form-control" >
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="insert" value="Add Category" class="btn btn-primary">
                                    </div>
                                </form>
                     <?php
                       update_cat();

                     ?>

                                </div>

                            <div class="col-md-6 ">
                                <h3 class="text-center">Categories</h3>
                                <table class="table table-bordered table-hover" style="margin-left: 120px">
                                    <tr>
                                        <th>ID</th>
                                        <th>Category_title</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                       select_cat();
                                         ?>
                                    <?php
                                    delete_cat();


                                    ?>

                                </table>
                            </div>
                        </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include 'includes/footer.php' ?>
