<?php



?>


<?php

function insert_cat()
{
 global $con;
    if (isset($_POST['insert'])) {
        $title=$_POST['title'];
        if ($title == '' ||empty($title))
        {?>
            <div class="alert alert-danger">
                This Field should not be empty
            </div>
            <?php
        }else
        {
            $query_insert = "INSERT INTO categories(cat_title) VALUES ('$title')";
            $result=mysqli_query($con,$query_insert);
            if ($result) {
                ?>
                <div class="alert alert-success">
                    Insert Record Success
                </div>
                <?php

            }  }
    }



}


?>