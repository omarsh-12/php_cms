<?php session_start();?>
<?php
$user_name=$_SESSION['username'];
if (!isset($user_name))
{

    header("Location: ../index.php");

}

?>
<?php include '../includes/config_db.php'?>
<!DOCTYPE html>
<html lang="en">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css">

<?php include "includes/header.php";?>

    <div id="wrapper">
       <?php function online_users()
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
        }?>
        <!-- Navigation -->
<?php include 'includes/navigation.php' ?>
        <div id="page-wrapper" >

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header text-center">
                            Welcome To Admin
                            <small><a href="profile.php"><?php echo $_SESSION['username'];?></a></small>
                        </h1>
             <h1 class="text-center"></h1>
<?php
if (isset($_GET['delete']))
{
    $post_id=$_GET['delete'];
    $query="DELETE FROM posts WHERE post_id='$post_id' ";
$delete_post=mysqli_query($con,$query);
$query_comment="DELETE FROM comments WHERE comment_post_id='$post_id'";
$query_comm_res=mysqli_query($con,$query_comment);
if ($delete_post)
{?>

    <div class="alert alert-success">success delete post</div>

   <?php
}
else
{?>
    <div class="alert alert-danger">Fail delete post</div>
   <?php
}
}
?>
<?php
if (isset($_GET['source']))
{
$source=$_GET['source'];
}
else
{
    $source='';

}
    switch ($source)
{
case 'add_post':
    include 'add_post.php';
    break;
case 'edit_post' :
    include 'edit_post.php';
    break;



case 'view_all_comments':
    include "view_all_comments.php";
    break;
default:

?>

                        <?php
                        if (isset($_GET['reset']))
                        {
                            $post_id_reset=$_GET['reset'];
                            $query="update posts set post_views_count=0 where post_id=".mysqli_real_escape_string($con,$post_id_reset)." ";
                            $res_query=mysqli_query($con,$query);
                        }


                        
                        ?>



                        <?php
                        if (isset($_POST['checkboxarray']))
                        {
                            foreach ($_POST['checkboxarray'] as $checkboxvalue)
                            {

                                $bulk_def=$_POST['bulk-def'];
                                switch ($bulk_def)
                                {
                                    case "published":
                                        $query="update posts set post_status='$bulk_def' where post_id='$checkboxvalue'";
                                $res_up=mysqli_query($con,$query);
                                break;

                                    case "draft":
                                        $query="update posts set post_status='$bulk_def' where post_id='$checkboxvalue'";
                                        $res_up=mysqli_query($con,$query);
                                        break;

                                    case "delete":
                                        $query="delete from posts where post_id='$checkboxvalue'";
                                        $res_up=mysqli_query($con,$query);
                                        break;
                                    case "clone":
                                        $query="select *from posts where post_id='$checkboxvalue'";
                                        $res_up=mysqli_query($con,$query);
                                        while($row=mysqli_fetch_array($res_up))
                                        {
                                            $id = $row['post_id'];
                                            $author = $row['post_author'];
                                            $title = $row['post_title'];
                                            $category = $row['post_category_id'];
                                            $status = $row['post_status'];
                                            $image = $row['post_image'];
                                            $content = $row['post_content'];
                                            $date = $row['post_date'];
                                            $comment_count = $row['post_comment_count'];
                                            $post_tags = $row['post_tags'];
                                        }
                                        $query_insert="insert into posts(post_author,post_title,post_category_id,post_status,post_image,post_content,post_date,post_tags) values('$author','$title','$category','$status','$image','$content',now(),'$post_tags')";
                                       $insert_query=mysqli_query($con,$query_insert);
                                        break;

                                }

                            }
                        }
                        ?>


                        <form action="" method="post">


                        
                        <table class="table table-bordered table-hover">
                            <div class="col-xs-4" style="padding-left: 2px;padding-bottom: 5px;">
                                <select name="bulk-def" class="form-control" id="">
                                    <option value="published">published</option>
                                    <option value="draft">draft</option>
                                    <option value="delete">delete</option>
                                    <option value="clone">clone</option>
                                </select>
                            </div>
                            <div class="col-xs-4">
                                <input type="submit" name="" value="Apply" class="btn btn-primary" id="">
                                <a href="posts.php?source=add_post"><input type="button" name="" value="ADD NEW" class="btn btn-success" id=""></a>
                            </div>
                            <thead>
                            <tr>
                                <th><input type="checkbox" onclick="toggle(this);"></th>
                                <th>ID</th>
                                <th>post_author</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Date</th>
                                <th>Comment_count</th>
                                <th>Tags</th>
                                <th>Action</th>
                                <th>Views</th>
                            </tr>
                            </thead>

                            <?php
                            $query = "SELECT *FROM posts  order by post_id desc ";
                            $res = mysqli_query($con, $query);
                            if ($res) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['post_id'];
                                    $author = $row['post_author'];
                                    $title = $row['post_title'];
                                    $category = $row['post_category_id'];
                                    $status = $row['post_status'];
                                    $image = $row['post_image'];
                                    $content = $row['post_content'];
                                    $date = $row['post_date'];
                                    $comment_count = $row['post_comment_count'];
                                    $post_tags = $row['post_tags'];
                                    $post_views=$row['post_views_count'];
                                    ?>
                                    <tr>

                                         <td><input name="checkboxarray[]" class="checkbox" type="checkbox" value="<?php echo $id;?>"></td>
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $author; ?></td>
                                        <td><a href="../post.php?show=<?php echo $id;?>"><?php echo $title; ?></a></td>
                                        <?php
                                        $sel_category = "select * from categories where cat_id='$category'";
                                        $res_cate = mysqli_query($con, $sel_category);
                                        if ($res_cate) {
                                            while ($row = mysqli_fetch_assoc($res_cate)) {

                                                $category_name = $row['cat_title'];

                                            }


                                        }

                                        ?>
                                        <td><?php if ($category > 0) {
                                                echo $category_name;
                                            } else {
                                                echo "Not Category";
                                            } ?></td>
                                        <td><?php echo $status; ?></td>
                                        <td><a href="../post.php?show=<?php echo $id;?>"> <img height="100px" class="img-responsive" alt="image" width="150px"
                                                 src="../images/<?php echo $image ?>"></a></td>
                                        <td><?php echo $date; ?></td>
                                        <?php
                                       // $query_comment_res=mysqli_query($con,"select * from comments where comment_post_id='$id'");
                                        //$count_commet=mysqli_num_rows($query_comment_res);
                                        ?>
                                        <td><a href="posts.php?source=view_all_comments"><?php echo $comment_count; ?></a></td>
                                        <td><?php echo $post_tags; ?></td>
                                        <td><a href="posts.php?edit=<?php echo $id; ?>&&source=edit_post"
                                               class="btn btn-success btn-sm my-1">Edit</a>
                                            <a onclick="javascript: return confirm('Are you sure you want to delete the post?');" href="posts.php?delete=<?php echo $id ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                        <td><?php echo $post_views;?>
                                            <a href="posts.php?reset=<?php echo $id;?>">reset</a>
                                        </td>
                                    </tr>


                                    <?php
                                }


                            }
                            }

?>



</table>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

   <?php include 'includes/footer.php' ?>

        <script>

            function toggle(source) {
                var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i] != source)
                        checkboxes[i].checked = source.checked;
                }
            }


        </script>

