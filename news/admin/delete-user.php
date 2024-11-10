<?php
    # includng the DB connection and Header redirect Path
    include "config.php";
    #Only for Admin page is accessable
    if(!mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user WHERE USERID='{$_SESSION['userid']}' AND role=1"))>0){
        header("Location: ".$site."Admin/post.php");
    }
?>
<?php
    $uid=$_GET['id'];
    $sqlcheck="SELECT * FROM USER WHERE USERID={$uid}"; #Checking for record existence
    $result=mysqli_query($conn,$sqlcheck) or die("Refused to Connect");
    if(mysqli_num_rows($result)>0){
        $sql="DELETE FROM USER WHERE USERID={$uid}"; #if record exist deletion of Record
        if(mysqli_query($conn,$sql)){
            header("Location: $site/Admin/users.php"); # Redirect
        }else{
            echo "<script>alert('Can't delete User Record');</script>"; # if Error in SQL Execution
            header("Location: $site/Admin/users.php");  
        }
    }else{
        echo "<script>alert('No Record found to Delete!');</script>"; # No Record Found
        header("Location: $site/Admin/users.php"); 
    }
    # Closing Connection
    mysqi_close($conn);
?>