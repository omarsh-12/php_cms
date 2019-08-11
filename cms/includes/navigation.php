<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS LBLOG</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
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
                 <?php if (isset($_SESSION['username']))
                     {?>
                <li><a href="admin/index.php">Admin</a>
                </li>
                <?php }
                ?>
                <?php if(!isset($_SESSION['user_role']))
                {
                echo "<li><a href=\"register.php\">Register</a>
                </li>";}?>
                 <?php if(isset($_SESSION['user_role']))
                 {
                     if (isset($_GET['show']))
                     {
                         $the_post_id=$_GET['show'];
                         ?>
                         <li><a href="admin/posts.php?edit=<?php echo $the_post_id; ?>&&source=edit_post"">Edit Post</a></li>";
<?php

                     }




                 }


                     ?>
                <?php if(isset($_SESSION['user_role']))
                {?>
                    <li class="dropdown nav navbar-right" >
                        <a href="#" class="dropdown-toggle"  data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username'];?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="./profile.php"><i class="fa fa-fw fa-user"></i>My Profile</a>
                            </li>


                            <li class="divider"></li>
                            <li>
                                <a href="./admin/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>

                    <?php
                }
                ?>
            </ul>






        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
