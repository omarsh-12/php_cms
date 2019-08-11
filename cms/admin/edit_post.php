<?php include '../includes/config_db.php'?>

<?php
if(isset($_POST['update'])) {
    $pos_id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $tags = $_POST['tags'];
    $post_date = date('m-d-y');
    $content = $_POST['content'];
    move_uploaded_file($image_tmp, "../images/$image");
    if (empty($image)) {

        $img_query="SELECT * FROM posts where post_id='$pos_id'";
        $res_img=mysqli_query($con,$img_query);
        if ($res_img)
        {
            while ($row=mysqli_fetch_assoc($res_img))
            {
                $image=$row['post_image'];
            }



        }
    }
    {
        $update_query = "UPDATE posts SET post_title='$title', post_author='$author', post_status='$status', post_category_id='$category', post_image='$image', post_tags='$tags', post_date=now(), post_content='$content' WHERE post_id='$pos_id'";
        $res_update = mysqli_query($con, $update_query);
        if ($res_update) {
            ?>
            <div class="alert alert-success">success update Post <a href="../post.php?show=<?php echo $pos_id;?>">View Post</a> Or More<a href="posts.php"> Edit Post</a> </div>
            <?php

        } else {
            ?>
            <div class="alert alert-success">Fail update</div>
            <?php
        }
    }

}
?>



<div class="container">

    <div class="col-md-6">
        <h2>Edit Post</h2>
        <form action="#" method="post" enctype="multipart/form-data">
            <?php
            if (isset($_GET['edit'])) {
             $post_id=$_GET['edit'];
                $sel_query = "SELECT * FROM posts WHERE post_id='$post_id'";
            $res_select=mysqli_query($con,$sel_query);
            if ($res_select) {
                while ($row = mysqli_fetch_assoc($res_select)) {
                    $title_pos = $row['post_title'];
                    $author = $row['post_author'];
                    $status = $row['post_status'];
                    $category = $row['post_category_id'];
                     $image=$row['post_image'];
                    $tags = $row['post_tags'];
                    $post_date = $row['post_date'];
                    $content = $row['post_content'];

            {
            }                        ?>

                        <input type="hidden" name="id" value="<?php echo $post_id?>">
                        <div class="form-group">
                            <label for="title">Title :</label>
                            <input type="text" value="<?php echo $title_pos ?>" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label for="author">post_Author :</label>
                            <input type="text" class="form-control" value="<?php echo $author; ?>" name="author">
                        </div>
                        <div class="form-group">
                            <label for="status">post_status :</label>
                            <select class="form-control" name="status">
                                <option <?php
                                if ($status=="published")
                                {?>selected
                                   <?php
                                }
                                    ?>
                                >published</option>
                                <option  <?php
                                         if ($status=="draft")
                                         {?>selected
                                    <?php
                                    }
                                    ?>>draft</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">category :</label>
                            <select name="category" class="form-control">
                                <?php
                                $query = "SELECT * FROM categories";
                                $result = mysqli_query($con, $query);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $title = $row['cat_title'];
                                        $id = $row['cat_id'];
                                        ?>
                                        <option   value="<?php if ($category==$id)
                                        {?>
                                            selected
                                       <?php }
                                            echo $id; ?>">
                                            <?php echo $title ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Post Image :</label>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="content">Content :</label>
                            <input id="content" value="<?php echo $content;?>" type="hidden" name="content">
                            <trix-editor input="content"></trix-editor>
                        </div>
                            <div class="form-group">
                                <label for="tags">Post_tags :</label>
                                <input type="text" class="form-control" value="<?php echo $tags ?>" name="tags">
                            </div>



                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="update" name="update">
                        </div>

                    <?php }

            }
            }?>


        </form></div>
    <div class="col-md-4">
     <?php
     ?> <h1><?php echo $title_pos;?></h1>
        <img height='250px' width='400px' src="../images/<?php echo $image;?>">
        <?php


     ?>
    </div>
</div>