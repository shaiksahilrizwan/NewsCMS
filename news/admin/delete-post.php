<?php 
    include "config.php";
    #Getting ID of post
    $id=$_GET['id'];
    $sql="SELECT * FROM POST WHERE POSTID={$id}";
    #checking if present or not
    $result=mysqli_query($conn,$sql) or die("Can not load data!");
    if(mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_assoc($result)){
            $cat=$row['CATEGORY'];#Getting the categoryid for updation of number of posts
            $filetoremove=$row['POSTIMAGE'];
        } 
        $sql1="DELETE FROM POST WHERE POSTID={$id};";
        $sql1.="UPDATE CATEGORY SET POST=POST-1 WHERE CATEGORYID={$cat};";
        if(mysqli_multi_query($conn,$sql1)){
            #delete image from folder
            unlink("upload/".$filetoremove);
            header("Location: $site"."Admin/post.php");#Query Runs 
        }
        else{
            echo "<script>alert('Can not delete Record!')</scriptt>";
            header("Location: $site"."Admin/post.php");#if Query failed
        }
    }
    #If not present 
    else{
        header("Location: $site"."Admin/post.php");
    }
?>