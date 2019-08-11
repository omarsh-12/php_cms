<div class="col-md-4">


    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
        <div class="input-group">
            <input type="text" name="search" class="form-control">
            <span class="input-group-btn">
                            <button class="btn btn-default" name="send" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
        </div>
        </form>
        <!-- /.input-group -->
    </div>
   <?php if (!isset($_SESSION['user_role'])) {
       ?>
       <div class="well">
           <h4>Login</h4>
           <?php if (isset($_GET['Login'])) {
               ?>
               <div class="alert alert-danger"><?php echo $_GET['Login']; ?></div>

               <?php
               header("refresh:2; url=index.php", TRUE, 307);
           } else {
               $_GET['Login'] = '';
           }

           ?>
           <form action="includes/login.php" method="post">
               <div class="form-group">
                   <input type="text" autocomplete="off" name="name" placeholder="enter user name" class="form-control">
               </div>
               <div class="input-group">
                   <input type="password" name="password" placeholder="enter password" class="form-control">
                   <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" type="submit">
                                login
                        </button>

                        </span>
               </div>

           </form>
           <!-- /.input-group -->
       </div>
       <?php
   }
?>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php

                    $query="SELECT * FROM categories";
                    $res=mysqli_query($con,$query);
                    while($row=mysqli_fetch_assoc($res)) {
                        $cat_id=$row['cat_id'];
                        $name = $row['cat_title'];
                        ?>

                        <li><a href="category.php?show_cat=<?php echo $cat_id;?>"><?php echo $name ?></a>
                        </li>

                        <?php


                    }
                    ?>




                </ul>
            </div>
            <!-- /.col-lg-6 -->
            <div class="col-lg-12">
                <ul class="list-unstyled">

            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <div class="well">
        <h4>Side Widget Well</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
    </div>

</div>
