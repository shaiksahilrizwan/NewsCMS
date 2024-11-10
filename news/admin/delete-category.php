<?php 
    include "config.php";
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM CATEGORY WHERE CATEGORYID={$id}"))){
            $sql="DELETE FROM CATEGORY WHERE CATEGORYID={$id}";
            $result=mysqli_query($conn,$sql) or die("Can not process Data removal");
        }else{
            echo "<script>alert('No Category Present to delete')</script>";
        }
    }
    header("Location: ".$site."Admin/category.php");
?>