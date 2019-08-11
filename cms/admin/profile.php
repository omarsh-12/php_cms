<!DOCTYPE html>
<html lang="en">
<?php include "../includes/config_db.php"?>
<?php include "includes/header.php";?>
<?php session_start();?>
<?php ob_start();?>
<?php
if (!isset($_SESSION['username']))
{
    header("Location: ../index.php");
}
?>
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
    ?>
    <!-- Navigation -->
    <?php include 'includes/navigation.php'?>
    <div id="page-wrapper" >

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header text-center">
                        Welcome To Admin
                        <small><?php echo $_SESSION['username'];?></small>
                    </h1>


                    <?php

                    if(isset($_POST['update_profile'])){
                        $user_id=$_POST['user_id'];
                        $name=$_POST['username'];
                        $password=$_POST['password'];
                        $email=$_POST['email'];
                        $f_name=$_POST['fname'];
                        $l_name=$_POST['lname'];
                        $image=$_FILES['image']['name'];
                        $image_tmp=$_FILES['image']['tmp_name'];

                        $role=$_POST['role'];
                        move_uploaded_file($image_tmp,"../images/$image");
                        if (empty($image))
                        {
                            $img_query="SELECT * FROM users where user_id='$user_id'";
                            $res_img=mysqli_query($con,$img_query);
                            if ($res_img)
                            {
                                while ($row=mysqli_fetch_assoc($res_img))
                                {
                                    $image=$row['user_image'];

                                }


                            }

                        }
                        $rand_query="SELECT * FROM users ";
                        $res_rand=mysqli_query($con,$rand_query);
                        if ($res_rand)
                        {
                            while ($row=mysqli_fetch_assoc($res_rand))
                            {

                                $randsalt=$row['randsalt'];
                                $db_password=$row['user_password'];

                            }
                                   if ($password !==$db_password)
                                   {

                                       $password=password_hash($password,PASSWORD_BCRYPT,array("cost" =>14));
                                   }

                        }
                     //   $password=crypt($password,$randsalt);

                        $query_update="update users set username ='$name',user_password='$password',user_firstname='$f_name',user_lastname='$l_name',user_email='$email',user_image='$image',randsalt='$randsalt' where user_id='$user_id'  ";
                        $result_update=mysqli_query($con,$query_update);
                        if ($result_update) {
                            header("Location: users.php");
                        }
                        else
                        {?>

                            <div class="alert alert-danger">Fail update user</div>
                            <?php
                        }

                    }

                    ?>
                    <?php
                    if (isset($_SESSION['username'])) {
                        $user_name = $_SESSION['username'];

                        $query_select = "select *from users where username='$user_name'";
                        $query_res = mysqli_query($con, $query_select);
                        if ($query_res) {
                            while ($row = mysqli_fetch_assoc($query_res)) {
                                $user_id = $row['user_id'];
                                $name = $row['username'];
                                $email = $row['user_email'];
                                $f_name = $row['user_firstname'];
                                $l_name = $row['user_lastname'];
                                $role = $row['user_role'];
                                $image=$row['user_image'];
                                $password = $row['user_password'];


                            }}}
                    ?>


                    <div class="container">
                        <div class="col-md-6">

                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo $user_id?>" name="user_id">
                                <div class="form-group">
                                    <label for="title">userName :</label>
                                    <input type="text" value="<?php echo $name; ?>" class="form-control" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="author">password :</label>
                                    <input autocomplete="off" type="password" class="form-control" value="<?php echo $password; ?>"
                                           name="password">
                                </div>
                                <div class="form-group">
                                    <label for="author">email :</label>
                                    <input type="email" value="<?php echo $email; ?>" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="status">FirstName :</label>
                                    <input type="text" name="fname" value="<?php echo $f_name; ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="category">LastName :</label>
                                    <input type="text" name="lname" value="<?php echo $l_name; ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="image">User Image :</label>
                                    <input type="file" name="image">
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Save" name="update_profile">
                                </div>

                            </form>

                        </div>
                        <div class="col-md-4">
                            <h3 class="text-center"><?php echo $name; ?></h3>
                            <img height="300" class="img-circle" width="400" src="../images/<?php echo $image; ?>" alt="">
                        </div>
                    </div>



                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

<?php include 'includes/footer.php'?>