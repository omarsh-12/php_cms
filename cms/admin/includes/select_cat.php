<?php

function select_cat()
{  global $con;
    $query="SELECT *FROM categories";

    $result=mysqli_query($con,$query);
    if ($result)
    {
        while ($row=mysqli_fetch_assoc($result)) {
            $title = $row['cat_title'];
            $id = $row['cat_id'];
?>


            <tr>
                <td><?php echo $id;?></td>
                <td><?php echo $title; ?></td>
                <td><a href="categories.php?edit=<?php echo $id?>" class="btn btn-success btn-sm">Edit</a>
                    <a class="btn btn-danger btn-sm" href="categories.php?delete=<?php echo $id?>">Delete</a></td>
            </tr>
<?php

        }}

}?>