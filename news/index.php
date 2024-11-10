<?php 
    include 'header.php'; 
    include "admin/config.php";
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
                        <?php 
                        #selecting the Category and Username for displaying and post joining the 3 tables
                            $sql="SELECT * FROM POST AS P , CATEGORY AS C , USER AS U WHERE P.CATEGORY=C.CATEGORYID AND P.AUTHOR =U.USERID ORDER BY P.POSTID DESC LIMIT {$offset},{$limit}";
                            $result=mysqli_query($conn,$sql) or die("Can not load Data");
                            if(mysqli_num_rows($result)>0){  #if there are records displaying them 
                            while($row=mysqli_fetch_assoc($result)){
                        ?>
                        <div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?id=<?php echo $row["POSTID"]; ?>"><img src="admin/upload/<?php echo $row['POSTIMAGE']; ?>" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href='single.php?id=<?php echo $row['POSTID']; ?>'><?php echo $row['POSTTITLE']; ?></a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href='category.php?id=<?php echo $row['CATEGORYID']; ?>'><?php echo $row['CATEGORYNAME']; ?></a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href='author.php?id=<?php echo $row['USERID']; ?>'><?php echo $row['username']; ?></a>
                                            </span>
                                        </div>
                                        <p class="description">
                                            <?php echo substr($row['POSTDESCRIPTION'],0,50)."..."; ?>
                                        </p>
                                        <a class='read-more pull-right' href='single.php?id=<?php echo $row['POSTID']; ?>'>read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        } 
                    }else{
                        echo "<h2>No Posts Found to display!</h2>";#if there are no records
                    }
                        ?>
                        <ul class='pagination admin-pagination'>
                  <?php 
                    if($page>1){ 
                        $prev=$page-1;#if the page > 0 
                        echo "<li><a href='index.php?page=$prev'>Prev</a></li>";
                    }
                    $totalrecords=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM POST")); # no of records
                    $totalpages=0;
                    if($totalrecords>0){
                        $totalpages=ceil($totalrecords/$limit); #calculating total number of pages as per page limit 
                        for($i=1;$i<=$totalpages;$i++){ 
                            if($i==$page){   # no of pages required that many displayed
                                # if page is same as current counter then active 
                  ?>
                      <li class="active"><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php 
                            }
                            else{
                                ?>
                                <li><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                            }
                    
                    }    
                }
                # if current page is less than total pages then can move forward
                if($page<$totalpages){
                    $next=$page+1;
                    echo "<li><a href='index.php?page=$next'>Next</a></li>";
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
