<?php 
    include 'header.php'; 
    include 'admin/config.php';
    if(!isset($_GET['id'])){
        header("Location: ".$site);
    }
?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?php 
                if(!isset($_GET['page'])){
                    $page=1;#if user first visits the page
                }else{
                    $page=$_GET['page'];#pagination number
                }
                $limit=5;
                $offset=($page-1)*$limit;#for database query
              ?>
            <?php 
                if(!isset($_GET['page'])){
                    $page=1;#if user first visits the page
                }else{
                    $page=$_GET['page'];#pagination number
                }
                $limit=5;
                $offset=($page-1)*$limit;#for database query
              ?>
                <!-- post-container -->
                <div class="post-container">
                    <?php 
                        $id=$_GET['id'];
                        $sql="SELECT * FROM USER WHERE USERID={$id}";
                        $result=mysqli_query($conn,$sql) or die("can not load data");
                        if(mysqli_num_rows($result)>0){
                            while($row=mysqli_fetch_assoc($result)){
                                $authname=$row['username'];
                            }
                    ?>
                  <h2 class="page-heading"><?php echo $authname; ?></h2>
                  <?php 
                  
                          }
                        else{
                                echo '<h2>No Author Found!</h2>';
                        }
                ?>
                    <?php 
                        $sql2="SELECT * FROM USER AS U , POST AS P , CATEGORY AS C WHERE U.USERID=P.AUTHOR AND P.AUTHOR={$id} AND P.CATEGORY=C.CATEGORYID ORDER BY P.POSTID DESC LIMIT {$offset},{$limit}";
                        $result2=mysqli_query($conn,$sql2) or die("Can not load data");
                        if(mysqli_num_rows($result2)>0){
                            while($row2=mysqli_fetch_assoc($result2)){
                    ?>
                    <div class="post-content">
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row2['POSTID']; ?>"><img src="admin/upload/<?php echo $row2['POSTIMAGE']; ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href="single.php?id=<?php echo $row2['POSTID']; ?>"><?php echo $row2['POSTTITLE']; ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href="category.php?id=<?php echo $row2['CATEGORY']; ?>"><?php echo $row2['CATEGORYNAME']; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href="author.php?id=<?php echo $row2['AUTHOR']; ?>"><?php echo $row2['username']; ?></a>
                                        </span>
                                    </div>
                                    <p class="description">
                                    <?php echo substr($row2['POSTDESCRIPTION'],0,50); ?>
                                </p>
                                    <a class='read-more pull-right' href="single.php?id=<?php echo $row2['POSTID']; ?>">read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } }else{
                        echo "<h2>No Posts to display</h2>";
                    }
                    ?>
                    <ul class='pagination admin-pagination'>
                  <?php 
                    if($page>1){ 
                        $prev=$page-1;#if the page > 0 
                        echo "<li><a href='author.php?page=$prev&id=$id'>Prev</a></li>";
                    }
                    $totalrecords=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM POST WHERE AUTHOR={$id}")); # no of records
                    $totalpages=0;
                    if($totalrecords>0){
                        $totalpages=ceil($totalrecords/$limit); #calculating total number of pages as per page limit 
                        for($i=1;$i<=$totalpages;$i++){ 
                            if($i==$page){   # no of pages required that many displayed
                                # if page is same as current counter then active 
                  ?>
                      <li class="active"><a href="author.php?page=<?php echo $i; ?>&id=<?php echo $id; ?>"><?php echo $i; ?></a></li>
                <?php 
                            }
                            else{
                                ?>
                                <li><a href="author.php?page=<?php echo $i; ?>&id=<?php echo $id; ?>"><?php echo $i; ?></a></li>
                        <?php
                            }
                    
                    }    
                }
                # if current page is less than total pages then can move forward
                if($page<$totalpages){
                    $next=$page+1;
                    echo "<li><a href='author.php?page=$next&id=$id'>Next</a></li>";
                }
                ?>
                 </ul>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
