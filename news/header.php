<?php 
    include "admin/config.php";
    //echo "<h1>".."</h2>";
    $pg=basename($_SERVER['PHP_SELF']);
    switch($pg){
        case "single.php":
            if(isset($_GET['id'])){
                $sql_title="SELECT * FROM POST WHERE POSTID={$_GET['id']}";
                if(mysqli_num_rows(mysqli_query($conn,$sql_title))>0){
                $result_title=mysqli_query($conn,$sql_title)or die("No title Found");
                $row_title=mysqli_fetch_assoc($result_title);
                $page_title=$row_title['POSTTITLE'];
                }else{
                    $page_title="No Post found";
                }
            }
            else{
                $page_title="No Post Found";
            }
            break;
        case "category.php":
            if(isset($_GET['id'])){
                $sql_title="SELECT * FROM CATEGORY WHERE CATEGORYID={$_GET['id']}";
                $result_title=mysqli_query($conn,$sql_title)or die("No title Found");
                $row_title=mysqli_fetch_assoc($result_title);
                $page_title=$row_title['CATEGORYNAME']." "."News";
            }
            else{
                $page_title="No Category Found";
            }
            break;
        case "author.php":
            if(isset($_GET['id'])){
                $sql_title="SELECT * FROM USER WHERE USERID={$_GET['id']}";
                $result_title=mysqli_query($conn,$sql_title)or die("No title Found");
                $row_title=mysqli_fetch_assoc($result_title);
                $page_title="News by ".$row_title['username'];
            }
            else{
                $page_title="No Author Found";
            }
            break;
        case "search.php":
            if(isset($_GET['search'])){
                $page_title=$_GET['search'];
            }
            else{
                $page_title="No Search Found";
            }
            break;
        default:
            $page_title= "News Website";

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
                    <div class=" col-md-offset-4 col-md-4">
                        <a href="index.php"><img class="logo" src="images/news.jpg"></a>
                    </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class='menu'>
                    <li><a href="<?php echo $site; ?>">Home</a></li>
                    <?php 
                        #Database Connection
                        include "admin/config.php";
                        $sql="SELECT * FROM CATEGORY";
                        $result=mysqli_query($conn,$sql) or die("Can not load Menu data");
                        while($row=mysqli_fetch_assoc($result)){
                            if(isset($_GET['id'])){
                            if($_GET['id']==$row['CATEGORYID']){
                                #if the current catid is same as catgory id that is we are viewing the page active the category header
                    ?>
                    <li><a class="active" href='category.php?id=<?php echo $row['CATEGORYID']; ?>'><?php echo $row['CATEGORYNAME']; ?></a></li>
                    <?php 
                            }else{ ?>
                            <li><a href='category.php?id=<?php echo $row['CATEGORYID']; ?>'><?php echo $row['CATEGORYNAME']; ?></a></li>
                    
                <?php } }
                else{?>
                        <li><a href='category.php?id=<?php echo $row['CATEGORYID']; ?>'><?php echo $row['CATEGORYNAME']; ?></a></li>
                <?php
            } } ?> 
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->