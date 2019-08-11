<?php

function update_cat(){
global $con;
  ?>

   <form action="categories.php" method="POST">
    <div class="form-group">
        <label for="category">Edit Category</label>
        <?php

            if (isset($_GET['edit'])) {
                $cate_id = $_GET['edit'];
                $sel_query = "SELECT *FROM categories WHERE cat_id='$cate_id'";
                $res_sel = mysqli_query($con, $sel_query);
                if ($res_sel) {
                    while ($row = mysqli_fetch_assoc($res_sel)) {
                        $cat_title = $row['cat_title'];
                        echo "<input type=\"hidden\" value='{$cate_id}'  name=\"cat_id\">";
                        echo "<input type=\"text\" value='{$cat_title}' name=\"title\" class=\"form-control\" >";
                    }
                }
            }
            ?>



    </div>
    <div class="form-group">
        <input type="submit" name="update" value="Edit Category" class="btn btn-primary">
    </div>
</form>




    <?php
    if(isset($_POST['update'])) {
        $cat_id = @mysqli_real_escape_string($con,$_POST['cat_id']);
        $title = @mysqli_real_escape_string($con,$_POST['title']);
        if ($title == '' || empty($title)) {
            echo "<div class=\"alert alert-danger\">Fail Update</div>";
        } else {
            $update = "UPDATE categories SET cat_title='$title' WHERE cat_id='$cat_id'";

            $result = mysqli_query($con, $update);
            if ($result) {
                ?>


                <div class="alert alert-success">Success Update</div>
            <?php } else {
                ?>
                <div class="alert alert-danger">Fail Update</div>
                <?php
            }
        }
    }
}

?>







