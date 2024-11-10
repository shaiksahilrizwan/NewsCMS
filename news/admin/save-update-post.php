<?php 
    include "config.php";
    if(empty($_FILES['new-image']['name'])){
        echo $filename=$_POST['old-image'];
    }else{
        $errors=array();
        $filename=$_FILES['new-image']['name'];
        $filesize=$_FILES['new-image']['size'];
        $filetemp=$_FILES['new-image']['tmp_name'];
        $filetype=$_FILES['new-image']['type'];
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
            print_r($errors);
            #No code should  execute from here
            die();
        }
    }
    $sqlcheck="SELECT * FROM POST WHERE POSTID={$_POST['post_id']}";
    $result2=mysqli_query($conn,$sqlcheck) or die("Can Not remove Old Image");
    while($row=mysqli_fetch_assoc($result2)){
        $oldimg=$row['POSTIMAGE'];
    }
    #If the Oldimage is replaced then should be deleted form Folder
    if($oldimg!=$filename)
        unlink("upload/".$oldimg);
    echo $sqlnewcheckcat="SELECT * FROM POST WHERE POSTID={$_POST['post_id']}";
    $resultcheck=mysqli_query($conn,$sqlnewcheckcat) or die("Can not check data");
    if($row3=mysqli_fetch_assoc($resultcheck)){
        $catidold=$row3['CATEGORY'];
    }else{
        echo "failed query! ";
    }
    if($catidold==$_POST['category']){
        $sql="UPDATE POST SET POSTTITLE='{$_POST['post_title']}', POSTDESCRIPTION='{$_POST['postdesc']}',CATEGORY={$_POST['category']},POSTIMAGE='{$filename}' WHERE POSTID={$_POST['post_id']}";
        $result=mysqli_query($conn,$sql) or die("Can not Save Changes!");
    }
    else{
        $sql="UPDATE POST SET POSTTITLE='{$_POST['post_title']}', POSTDESCRIPTION='{$_POST['postdesc']}',CATEGORY={$_POST['category']},POSTIMAGE='{$filename}' WHERE POSTID={$_POST['post_id']};";
        $sql.="UPDATE CATEGORY SET POST=POST-1 WHERE CATEGORYID={$catidold};";
        echo $sql.="UPDATE CATEGORY SET POST=POST+1 WHERE CATEGORYID={$_POST['category']}";
        $result=mysqli_multi_query($conn,$sql) or die("Can not update post");
    }
    header("Location: $site"."Admin/post.php");
?>