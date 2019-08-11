<?php
include '../includes/config_db.php';

?>

<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <th>id</th>
        <th>Comment_post</th>
        <th>author</th>
        <th>email</th>
        <th>content</th>
        <th>status</th>
        <th>date</th>
        <th>Action</th>
        <th>Delete</th>
    </tr>
    </thead>
    <?php

    $comment_query="select * from comments";
    $res_comments=mysqli_query($con,$comment_query);
    if ($res_comments)
    {
        while ($row=mysqli_fetch_assoc($res_comments))
        {
            $id=$row['comment_id'];
            $post=$row['comment_post_id'];
            $author=$row['comment_author'];
            $email=$row['comment_email'];
            $content=$row['comment_content'];
            $stat=$row['comment_status'];
            $date=$row['comment_date'];
?>
            <tr>
                <td><?php echo $id;?></td>
                <?php
                $query_post="select * from posts where post_id='$post'";
                $res_post=mysqli_query($con,$query_post);
                if ($res_post)
                {
                    while($row1=mysqli_fetch_assoc($res_post))
                    {
                        $id_post=$row1['post_id'];
                        $title=$row1['post_title'];
                        ?>
                        <td><a href="../post.php?show=<?php echo $id_post; ?>"><?php echo $title;?></a></td>
                        
                <?php
                    }

                }

                ?>

                <td><?php echo $author;?></td>
                <td><?php echo $email;?></td>
                <td><?php echo $content;?></td>
                <td><?php echo $stat;?></td>
                <td><?php echo $date;?></td>
                <td>
               <?php
 if ($stat=="approve") {?>
     <a class="btn btn-primary btn-sm" href="comments.php?unapprove=<?php echo $id;?>">UNapprove</a>

 
<?php

  }            ?>
  <?php
if ($stat=="unapprove") {?>
     <a class="btn btn-success btn-sm" href="comments.php?approve=<?php echo $id;?>">Approve</a>

 
<?php
}
  ?>
                 </td>
                
                <td><a class="btn btn-danger btn-sm" href="comments.php?deleted=<?php echo $id;?>">Delete</a> </td>
            </tr>


<?php
        }
    }




    ?>
</table>



<?php 
if (isset($_GET['deleted'])) {
    $comm_id=$_GET['deleted'];
$query_delete="DELETE from comments where comment_id='$comm_id'";
$query_del_res=mysqli_query($con,$query_delete);
$query_post="UPDATE posts SET post_comment_count=post_comment_count-1 WHERE post_id='$post'";
$query_post_res=mysqli_query($con,$query_post);
header("Location: comments.php");

  }?>
<?php
if (isset($_GET['approve'])) {
    $comm_id=$_GET['approve'];
$query_upprove="UPDATE comments SET comment_status='approve' WHERE comment_id='$comm_id'";
$query_up_res=mysqli_query($con,$query_upprove);
if ($query_up_res) {
   header("Location: comments.php");
}

  }?>


<?php
if (isset($_GET['unapprove'])) {
    $comm_id=$_GET['unapprove'];
$query_unupprove="UPDATE comments SET comment_status='unapprove' WHERE comment_id='$comm_id'";
$query_unup_res=mysqli_query($con,$query_unupprove);
if ($query_unup_res) {
   header("Location: comments.php");
}

  }?>


