<?php

function delete_cat()
{
    if (isset($_GET['delete'])) {
        global $con;
        $cat_id = $_GET['delete'];
        $delete_cate = "DELETE FROM categories Where cat_id='$cat_id'";
        $res_delete = mysqli_query($con, $delete_cate);
        header("Location: categories.php");
    }
}
?>