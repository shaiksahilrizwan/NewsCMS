<?php 
    include "config.php";
    if(isset($_POST['cat'])){
    if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM CATEGORY WHERE CATEGORYNAME='{$_POST['cat']}'"))>0){
        header("Location: ".$site."Admin/category.php");
    }
    else{
        $sql="INSERT INTO category(CATEGORYNAME,POST) VALUES ('{$_POST['cat']}',0)";
        if(mysqli_query($conn,$sql)){
            header("Location: ".$site."Admin/category.php");
        }
        else{
            echo "<h2>Error Adding Catgeory!</h2>";
                        }
    }
    }
    header("Location: ".$site."Admin/category.php");
?>