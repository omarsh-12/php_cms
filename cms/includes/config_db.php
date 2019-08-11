<?php
$con=@mysqli_connect('localhost','root','','cms1');
if ($con)
{
 //   echo "success connect";
}
else
{
    echo "faild connect";
}
