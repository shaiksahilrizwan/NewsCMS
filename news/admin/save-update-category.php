<?php
   include "config.php";
   if(!isset($_POST['submit'])){
        header("Location: ".$site."Admin/category.php");
   }else{
    $newcatname=mysqli_real_escape_string($conn,$_POST['cat_name']);
    $catid=mysqli_real_escape_string($conn,$_POST['cat_id']);
    $result=mysqli_query($conn,"SELECT * FROM CATEGORY WHERE CATEGORYNAME='{$newcatname}'") or die("Can not load data !");
    if(mysqli_num_rows($result)>0){
        ?>
        <script>
            alert('Category name already exists. Please use a new name.');
        </script>
    <?php 
     header("Location:".$site."Admin/update-category.php?id=$catid&error=Already Existing Categoryname select new one");
    }else{
        $sql2="UPDATE CATEGORY SET CATEGORYNAME='{$newcatname}' WHERE CATEGORYID={$catid}";
         if(mysqli_query($conn,$sql2)){
             header("Location: ".$site."Admin/category.php");
         }else{
            echo "Can not Update data!";
         }
    }
   }
?>