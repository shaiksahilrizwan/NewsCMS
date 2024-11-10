<?php 
    include 'header.php'; 
    include 'admin/config.php';
    if(!isset($_GET['search'])){
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
                <!-- post-container -->
                <div class="post-container">
                  <h2 class="page-heading">Search : <?php echo $_GET['search'];?></h2>
                    <?php 
                        $search=$_GET['search'];
                        $sql2="SELECT * FROM POST AS P , CATEGORY AS C , USER AS U WHERE  P.AUTHOR=U.USERID AND P.CATEGORY=C.CATEGORYID AND (POSTTITLE LIKE '%{$search}%' OR POSTDESCRIPTION LIKE '%{$search}%') ORDER BY POSTID DESC LIMIT {$offset},{$limit}";
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
                        echo "<li><a href='search.php?page=$prev&search=$search'>Prev</a></li>";
                    }
                    $totalrecords=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM POST WHERE POSTTITLE LIKE '%{$search}%'")); # no of records
                    $totalpages=0;
                    if($totalrecords>0){
                        $totalpages=ceil($totalrecords/$limit); #calculating total number of pages as per page limit 
                        for($i=1;$i<=$totalpages;$i++){ 
                            if($i==$page){   # no of pages required that many displayed
                                # if page is same as current counter then active 
                  ?>
                      <li class="active"><a href="search.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a></li>
                <?php 
                            }
                            else{
                                ?>
                                <li><a href="search.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a></li>
                        <?php
                            }
                    
                    }    
                }
                # if current page is less than total pages then can move forward
                if($page<$totalpages){
                    $next=$page+1;
                    echo "<li><a href='search.php?page=$next&search=$search'>Next</a></li>";
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
