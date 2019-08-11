<div class="container">
<div class=" justify-content-center my-2">
    <div class="col-md-8">
        <form action="" method="post">
            <div class="form-group">
                <label for="name">UserName :</label>
                <input type="text" name="name" value="<?php echo $login_username;?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="name">UserEmail :</label>
                <input type="email" name="name" value="<?php echo $login_user_email;?>" class="form-control">
            </div> <div class="form-group">
                <label for="name">UserRole:</label>
                <input type="text" name="name" value="<?php echo $login_user_role;?>" class="form-control">
            </div> <div class="form-group">
                <label for="name">UserPassword :</label>
                <input type="password" name="name" value="<?php echo $login_user_password;?>" class="form-control">
            </div>
    <div class="form-group">

        <input type="submit" name="save" value="Save" class="btn btn-success col-lg-3">
    </div>

    </form></div>
    <div class="col-md-4 my-3">
        <img class="img-circle " height="200" width="250" src="../images/<?php echo $login_user_image?>" alt="">
    </div> </div>

</div>

</div>
