<?php include 'header.php'; ?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                <div class="post-container">
                  <!-- post-container -->
                   <?php 
                   #including the Database Connectivity
                    include "admin/config.php";
                    if(!isset($_GET['id'])){
                        header("Location: ".$site);
                    }
                    $sql="SELECT * FROM POST AS P , CATEGORY AS C , USER AS U WHERE P.CATEGORY=C.CATEGORYID AND P.AUTHOR =U.USERID AND P.POSTID={$_GET['id']} ";
                    $result=mysqli_query($conn,$sql) or die("Can not load Post!");
                    if(mysqli_num_rows($result)>0){
                        while($row=mysqli_fetch_assoc($result)){
                   ?>
                    
                        <div class="post-content single-post">
                            <h3><?php echo $row['POSTTITLE']; ?></h3>
                            <div class="post-information">
                                <span>
                                    <i class="fa fa-tags" aria-hidden="true"></i><a href="<?php echo "category.php?id=".$row['CATEGORYID']; ?>">
                                    <?php echo $row['CATEGORYNAME']; ?></a>
                                </span>
                                <span>
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <a href='author.php?id=<?php echo $row['USERID']; ?>'><?php echo $row['username']; ?></a>
                                </span>
                            </div>
                            <img class="single-feature-image" src="<?php echo "admin/upload/".$row['POSTIMAGE']; ?>" alt=""/>
                            <p class="description">
                                <?php echo $row['POSTDESCRIPTION']; ?>
                            </p>
                        </div>
                    </div>
                    <?php 
                        }
                    }else{
                        echo "<h2>No Post Found to Show!</h2>";
                    }
                    ?>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
