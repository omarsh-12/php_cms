<?php  include "includes/config_db.php"; ?>
<?php  include "includes/header.php"; ?>


<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>

<?php
if (isset($_POST['create_user'])) {
    $user_name = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['useremail']);
    $password = mysqli_real_escape_string($con, $_POST['userpassword']);
    $conpass = mysqli_real_escape_string($con, $_POST['user_con_password']);

    $select_rand = "select *from users";
    $rand_query = mysqli_query($con, $select_rand);
    if (!$rand_query) {
        die("not result query" . mysqli_error($con));
    }else

        while($row = mysqli_fetch_array($rand_query))
        {
         $rand = $row["randsalt"];
         $email_db=$row['user_email'];
    }

       if (empty($user_name) && empty($email) && empty($password))
       {
           echo "<div class='alert alert-danger'>the field should is not empty</div>";
           header("refresh:2; url=register.php",TRUE,307);
       }
       else if($email == $email_db)
       {
           echo "<div class='alert alert-danger'>the email is already exist</div>";
           header("refresh:2; url=register.php",TRUE,307);

       }
   else if ($conpass !== $password ) {
       echo "<div class='alert alert-danger'>the password is not matching</div>";
       header("refresh:2; url=register.php",TRUE,307);

    }


   else {
      $password=password_hash($password,PASSWORD_BCRYPT,array("cost" =>14));
       $signup_query = "insert into users(username,user_email,user_password,user_role) values('$user_name','$email','$password','editor')";
       $query_insert = mysqli_query($con, $signup_query);
       header("Location: index.php");

    }

}
?>
<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="useremail" id="email" class="form-control" placeholder="Enter email@example.com">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="userpassword" id="key" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="user_con_password" id="key" class="form-control" placeholder="confarrm Password">
                            </div>

                            <input type="submit" name="create_user" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php";?>

