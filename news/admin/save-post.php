<?php 
    #saving the post 
    include "config.php";
    if(isset($_FILES['fileToUpload'])){
        $errors=array();
        $filename=$_FILES['fileToUpload']['name'];
        $filesize=$_FILES['fileToUpload']['size'];
        $filetemp=$_FILES['fileToUpload']['tmp_name'];
        $filetype=$_FILES['fileToUpload']['type'];
        #Getting the Extension of file
        $fileext=strtolower(end(explode('.',$filename)));
        $extensions=array("jpeg","jpg","png");
        if(in_array($fileext,$extensions)===false){
            #Adding error to array
            $errors[]="This file type not allowed! Choose JPG or PNG type";
        }
        #Checking File size to be less than 5MB 1kb 1024 bytes 1MB 1024 kbs 
        if($filesize>5242880){
            #Adding error to array
            $errors[]="File Size should be less than 5MB";
        }
        #Check for no errors
        if(empty($errors)==true){
            $sqlcheck="SELECT COUNT(*) AS COUNT FROM POST WHERE POSTIMAGE='{$filename}'";
            $result2=mysqli_query($conn,$sqlcheck) or die("Can not get Data");
            while($row2=mysqli_fetch_assoc($result2)){
                $count=$row2['COUNT'];
            }
            if($count>0){
                $arrayoffile=(explode('.',$filename));
                $filename_noext=strtolower($arrayoffile[0]);
                $filename=$filename_noext.($count+1).".".$fileext;
            }
            move_uploaded_file($filetemp,"upload/".$filename);
        }
        else{
            echo "<pre>";
            print_r($errors);
            echo "</pre>";
            #No code should  execute from here
            die("<a href='post.php'>Go Back</a>");
        }
    }
    $title=mysqli_real_escape_string($conn,$_POST['post_title']);
    $postdesc=mysqli_real_escape_string($conn,$_POST['postdesc']);
    $category=mysqli_real_escape_string($conn,$_POST['category']);
    session_start();
    $author=$_SESSION['userid'];
    #Inserting and Updating 2 tables 
    $sql="INSERT INTO POST(POSTTITLE,POSTDESCRIPTION,POSTIMAGE,CATEGORY,AUTHOR) VALUES('{$title}','{$postdesc}','{$filename}',{$category},{$author});";
    $sql.="UPDATE CATEGORY SET POST=POST+1 WHERE CATEGORYID={$category};";
    if(mysqli_multi_query($conn,$sql)){
        header("Location: $site"."/Admin/post.php");
    }else{
        die("Failed Query");#When Insert or Update fails
    }
?>