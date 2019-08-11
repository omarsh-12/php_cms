<?php include '../includes/config_db.php'?>

<?php
if(isset($_POST['create_user'])){
    $name=$_POST['username'];
    $password=$_POST['password'];
    $email=$_POST['email'];
    $f_name=$_POST['fname'];
    $l_name=$_POST['lname'];
    $image=$_FILES['image']['name'];
    $image_tmp=$_FILES['image']['tmp_name'];

    $role=$_POST['role'];
     move_uploaded_file($image_tmp,"../images/$image");
    $rand_query="SELECT randsalt FROM users ";
    $res_rand=mysqli_query($con,$rand_query);
    if ($res_rand)
    {
        while ($row=mysqli_fetch_assoc($res_rand))
        {

            $randsalt=$row['randsalt'];
        }


    }
    //$password=crypt($password,$randsalt);
    $password=password_hash($password,PASSWORD_BCRYPT,array("cost" =>14));
    $query="INSERT INTO users(username,user_password,user_firstname,user_lastname,user_email,user_image,user_role,randsalt) VALUES('$name','$password','$f_name','$l_name','$email','$image','$role','$randsalt')";
$result=mysqli_query($con,$query);
if ($result)
{?>


    <div class="alert alert-success">success insert users</div>


   <?php
   echo "Create User :"." "."<a href=\"users.php\">View User</a>";
}
else{
    ?>


    <div class="alert alert-danger">Fail insert users</div>
    <?php
}


}


?>
<div class="container">
    <div class="col-md-8">
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">userName :</label>
                <input autocomplete="on" type="text" class="form-control" name="username">
            </div>
             <div class="form-group">
                <label for="author">password :</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <label for="author">email :</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="status">FirstName :</label>
              <input type="text" name="fname" class="form-control">
            </div>
            <div class="form-group">
                <label for="category">LastName :</label>
            <input type="text" name="lname" class="form-control">
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
                <input type="submit" class="btn btn-primary" value="Add_user" name="create_user">
            </div>

        </form></div>
    </div>