<?php 
    include 'header.php'; 
    include 'admin/config.php';#Database Connection
    ?>
    <?php 
                if(!isset($_GET['page'])){
                    $page=1;#if first time visit
                }else{
                    $page=$_GET['page'];#else 
                }
                $limit=5;
                $offset=($page-1)*$limit;
              ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                    <?php 
                        if(!isset($_GET['id'])){
                            header("Location: ".$site);
                        }
                        $catid=$_GET['id'];
                        $sql="SELECT * FROM CATEGORY WHERE CATEGORYID={$catid}";
                        $result=mysqli_query($conn,$sql) or die("Can not load data");
                        while($row=mysqli_fetch_assoc($result)){
                            $catname=$row['CATEGORYNAME'];
                            $catid2=$row['CATEGORYID'];
                        }
                    ?>
                  <h2 class="page-heading"><?php echo $catname; ?></h2>
                  <?php 
                        $sql2="SELECT * FROM POST AS P,USER AS U WHERE P.CATEGORY={$catid} AND P.AUTHOR=U.USERID ORDER BY P.POSTID DESC LIMIT {$offset}, {$limit}";
                        $result2=mysqli_query($conn,$sql2) or die("Can Not Load Data");
                        while($row2=mysqli_fetch_assoc($result2)){
                    
                    ?>
                  <div class="post-content">
                  
                        <div class="row">
                            <div class="col-md-4">
                                <a class="post-img" href="single.php?id=<?php echo $row2['POSTID']; ?>"><img src="<?php echo "admin/upload/".$row2['POSTIMAGE']; ?>" alt=""/></a>
                            </div>
                            <div class="col-md-8">
                                <div class="inner-content clearfix">
                                    <h3><a href='single.php?id=<?php echo $row2['POSTID']; ?>'><?php echo $row2['POSTTITLE']; ?></a></h3>
                                    <div class="post-information">
                                        <span>
                                            <i class="fa fa-tags" aria-hidden="true"></i>
                                            <a href='category.php?id=<?php echo $catid; ?>'><?php echo $catname; ?></a>
                                        </span>
                                        <span>
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            <a href='author.php?id=<?php echo $row2['USERID']; ?>'><?php echo $row2['username']; ?></a>
                                        </span>
                                    </div>
                                    <p class="description">
                                        <?php echo substr($row2['POSTDESCRIPTION'],0,50); ?>
                                    </p>
                                    <a class='read-more pull-right' href='single.php?id=<?php echo $row2['POSTID']; ?>'>read more</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                ?>
                    <ul class='pagination admin-pagination'>
                  <?php 
                  #pagination Buttons
                    if($page>1){
                        $prev=$page-1;
                        echo "<li><a href='category.php?page=$prev&id=$catid2'>Prev</a></li>";#sending both the category id and page counter
                    }
                    $totalrecords=mysqli_num_rows(mysqli_query($conn,"SELECT * FROM POST WHERE CATEGORY={$catid2}"));
                    $totalpages=0;
                    if($totalrecords>0){
                        $totalpages=ceil($totalrecords/$limit);
                        for($i=1;$i<=$totalpages;$i++){ 
                            if($i==$page){   #sending both the category id and page counter
                    
                  ?>
                      <li class="active"><a href="category.php?page=<?php echo $i; ?>&id=<?php echo $catid2; ?>"><?php echo $i; ?></a></li>
                <?php 
                            }
                            else{ #sending both the category id and page counter
                                ?>
                                <li><a href="category.php?page=<?php echo $i; ?>&id=<?php echo $catid2; ?>"><?php echo $i; ?></a></li>
                        <?php
                            }
                    
                    }    
                }
                
                if($page<$totalpages){
                    $next=$page+1;
                    echo "<li><a href='category.php?page=$next&id=$catid2'>Next</a></li>";
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
