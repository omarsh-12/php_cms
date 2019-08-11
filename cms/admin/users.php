<!DOCTYPE html>
<html lang="en">
<?php include "../includes/config_db.php"?>
<?php include "includes/header.php";?>
<?php session_start();?>
<?php ob_start();?>
<?php $login_username=$_SESSION['username'];
       $login_user_email=$_SESSION['user_email'];
       $login_user_role=$_SESSION['user_role'];
       $login_user_password=$_SESSION['password'];
       $login_user_image=$_SESSION['user_image'];


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
}
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
                            <small><a href="profile.php"><?php echo $_SESSION['username'];?></a></small>
                        </h1>
<?php
if (isset($_GET['source'])) {
  $source=$_GET['source'];
}
else
{
  $source='';
}
switch ($source) {
  case 'add_user':
    include "add_user.php";
    break;
  case 'edit_user':
    include "edit_user.php";
    break;
    case 'user_profile':
        include 'includes/profile_user.php';
        break;
  default:
 ?>
     <table class="table">
                   <thead>
                       <tr>
                           <th>Id</th>
                           <th>UserName</th>
                           <th>Email</th>
                           <th>Image</th>
                           <th>Role</th>
                           <th>Action</th>
                           
                       </tr>
                   </thead>

              <?php
             $select_users="SELECT * FROM users";
             $users_result=mysqli_query($con,$select_users);
             if ($users_result) {
               while ($row=mysqli_fetch_assoc($users_result)) {
                 $id=$row['user_id'];
                 $name=$row['username'];
                 $email=$row['user_email'];
                 $Image=$row['user_image'];
                 $role=$row['user_role'];
                 ?>
                <tr>
  
                 <td><?php echo $id;?></td>
                 <td><?php echo $name;?></td>
                 <td><?php echo $email;?></td>
                 <td><?php if ($Image !==NULL) { ?>
                         <img height="40" width="70px" class="img-res" src="../images/<?php echo $Image; ?>">
                         <?php

                     }
                     else
                     {?>
                         <img src="https://via.placeholder.com/70X50">
                        <?php
                     }
                     ?>
                       </td>
                 <td><?php echo $role;?></td>
                <td><a href="users.php?source=edit_user&&edit=<?php echo $id;?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="users.php?delete=<?php echo $id;?>" class="btn btn-danger btn-sm">Delete</a>
               <?php if ($role=="editor"){
                   ?>
                   <a href="users.php?make_admin=<?php echo $id;?>" class="btn btn-success btn-sm">Make Admin</a>

                   <?php
               }
               else if ($role=="admin")
               {?>

                   <a href="users.php?make_editor=<?php echo $id;?>" class="btn btn-primary btn-sm">Make Editor</a>
                  <?php
               }

               ?>


                </td>

                </tr>

                 <?php

             }}
              ?>    
              
</table>
<?php
    break;
}


?>
   <?php
   if (isset($_GET['delete']))
   {
       $user_id=$_GET['delete'];
       $user_delete="delete from users where user_id='$user_id'";
       $delete_query=mysqli_query($con,$user_delete);
       header("Location: users.php");


   }

   ?>
<?php
if (isset($_GET['make_editor']))
{
    $user_id=$_GET['make_editor'];
    $user_make_editor="update users SET user_role='editor' where user_id='$user_id'";
    $make_query=mysqli_query($con,$user_make_editor);
    header("Location: users.php");


                        }

                        ?>

   <?php
   if (isset($_GET['make_admin']))
   {
       $user_id=$_GET['make_admin'];
       $user_make_admin="update users SET user_role='admin' where user_id='$user_id'";
       $make_query=mysqli_query($con,$user_make_admin);
       header("Location: users.php");


   }








   ?>


                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

   <?php include 'includes/footer.php'?>