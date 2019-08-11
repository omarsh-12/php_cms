<?php include '../includes/config_db.php'?>
<?php



?>
<?php

if(isset($_POST['update'])){
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
    $rand_query="SELECT * FROM users where user_id='$user_id'";
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
    //$password=crypt($password,$randsalt);

    $query_update="update users set username ='$name',user_password='$password',user_firstname='$f_name',user_lastname='$l_name',user_email='$email',user_image='$image',user_role='$role' where user_id='$user_id'  ";
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
if (isset($_GET['edit'])) {
    $user_id = $_GET['edit'];

    $query_select = "select *from users where user_id='$user_id'";
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

                    <form action="#" method="post" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $user_id?>" name="user_id">
                        <div class="form-group">
                            <label for="title">userName :</label>
                            <input type="text" value="<?php echo $name; ?>" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label for="author">password :</label>
                            <input type="password" class="form-control" value="<?php echo $password; ?>"
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
                            <label for="content">Role :</label>
                            <select name="role" class="form-control">

                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="update_user" name="update">
                        </div>

                    </form>

                </div>
                <div class="col-md-4">
                    <h3 class="text-center"><?php echo $name; ?></h3>
                    <img height="300" width="400" src="../images/<?php echo $image; ?>" alt="">
                </div>
            </div>

