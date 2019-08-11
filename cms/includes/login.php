<?php
include "config_db.php";
session_start();
?>

<?php
if (isset($_POST['login']))
{
    $name=mysqli_real_escape_string($con,$_POST['name']);
    $pass=mysqli_real_escape_string($con,$_POST['password']);
    $query="select *from users where username='$name'";
    $query_result=mysqli_query($con,$query);
   if (!$query_result)
   {
       die("error".mysqli_error($query_result));
   }
   else
   {
       while($row=mysqli_fetch_assoc($query_result))
       {
           $user_id=$row['user_id'];
           $user_name=$row['username'];
           $user_email=$row['user_email'];
           $user_role=$row['user_role'];
           $db_password=$row['user_password'];
           $db_image=$row['user_image'];
       }
      // $pass=crypt($pass,$db_password);
   }
/*if ($name !==$user_name && $pass!==$db_password) {


    header("Location: ../index.php?Login=fail_login");

}
else if ($name !==$user_name || $pass!==$db_password)
    {

    header("Location: ../index.php?Login=fail_login");
}
else
if ($name ===$user_name && $pass===$db_password)
*/
if (!password_verify($pass,$db_password))
    {
        header("Location: ../index.php?Login=fail_login");
    }
else if (password_verify($pass,$db_password))
{
$_SESSION['username']=$user_name;
$_SESSION['user_email']=$user_email;
$_SESSION['user_role']=$user_role;
$_SESSION['user_image']=$db_image;
$_SESSION['password']=$db_password;
    header("Location: ../admin");
}
else
{header("Location: ../index.php");

}
}