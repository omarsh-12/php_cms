<?php include '../includes/config_db.php'?>

<?php
if(isset($_POST['insert'])){
    $title=$_POST['title'];
    $author=$_POST['author'];
    $status=$_POST['status'];
    $category=$_POST['category'];
    $image=$_FILES['image']['name'];
    $image_tmp=$_FILES['image']['tmp_name'];
    $tags=$_POST['tags'];
    $post_date=date('m-d-y');
    $content=$_POST['content'];
     move_uploaded_file($image_tmp,"../images/$image");
     $query="INSERT INTO posts(post_title,post_author,post_status,post_category_id,post_image,post_tags,post_date,post_content) VALUES('$title','$author','$status','$category','$image','$tags',now(),'$content')";
$result=mysqli_query($con,$query);
$id=mysqli_insert_id($con);
if ($result)
{?>


    <div class="alert alert-success">success insert record <a href="../post.php?show=<?php echo $id;?>">View Post</a> </div>

   <?php
}
else{
    ?>


    <div class="alert alert-danger">Fail insert record</div>
    <?php
}


}


?>
<div class="container">
    <div class="col-md-8">
        <form action="#" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title :</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label for="author">post_Author :</label>
                <input type="text" class="form-control" name="author">
            </div>
            <div class="form-group">
                <label for="status">post_status :</label>
                <select class="form-control" name="status">
                    <option>published</option>
                    <option>unpublished</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">category :</label>
                <select name="category" class="form-control">
                    <?php
                    $query="SELECT * FROM categories";
                    $result=mysqli_query($con,$query);
                    if ($result)
                    {
                        while ($row=mysqli_fetch_assoc($result))
                        {
                            $title=$row['cat_title'];
                            $id=$row['cat_id'];
                        ?>
                            <option value="<?php echo $id; ?>">
                            <?php echo $title?>
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
                <input id="content" value="Editor content goes here" type="hidden" name="content">
                <trix-editor input="content"></trix-editor>
            </div>
                <div class="form-group">
                    <label for="tags">Post_tags :</label>
                    <input type="text" class="form-control" name="tags">
                </div>


            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="insert" name="insert">
            </div>

        </form></div>
    </div>