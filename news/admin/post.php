<?php 
    include "header.php"; 
    include "config.php";
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <?php 
                if(!isset($_GET['page'])){
                    $page=1;#if first time visit
                }else{
                    $page=$_GET['page'];#else 
                }
                $limit=5;
                $offset=($page-1)*$limit;
              ?>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php 
                            if($_SESSION['role']==1){
                                #if user is admin
                            $sql="SELECT * FROM POST ORDER BY POSTID DESC LIMIT {$offset},{$limit}";
                            }else{
                                $sql="SELECT * FROM post WHERE AUTHOR = {$_SESSION['userid']} ORDER BY POSTID DESC LIMIT {$offset}, {$limit}";#normal user can only see his postings only
                            }
                            $result=mysqli_query($conn,$sql) or die("Can not display Details");
                            if(mysqli_num_rows($result)>0){
                                while($row=mysqli_fetch_assoc($result)){
                        ?>
                          <tr>
                              <td class='id'><?php echo $row['POSTID']; ?></td>
                              <td><?php echo $row['POSTTITLE']; ?></td>
                              <?php
                                    $sql2="SELECT CATEGORYNAME FROM CATEGORY WHERE CATEGORYID={$row['CATEGORY']}";
                                    $result2=mysqli_query($conn,$sql2) or die("Can not process data");
                                    while($row2=mysqli_fetch_assoc($result2)){
                                        $catname=$row2['CATEGORYNAME'];
                                    }
                              ?>
                              <td><?php echo $catname; ?></td>
                              <?php 
                                $sql3="SELECT username from USER WHERE USERID={$row['AUTHOR']}";
                                $result3=mysqli_query($conn,$sql3) or die("Can not process data");
                                while($row3=mysqli_fetch_assoc($result3)){
                                    $authname=$row3['username'];
                                }
                              ?>
                              <td><?php echo $authname ?></td>
                              <!-- Update and Delete Links -->
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['POSTID']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['POSTID']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          
                          <?php 
                                }
                            } else{
                                echo "No Records to display";
                            }
                          ?>
                          
                      </tbody>
                  </table>
                  <ul class='pagination admin-pagination'>
                  <?php 
                  #pagination Buttons
                    if($page>1){
                        $prev=$page-1;
                        echo "<li><a href='post.php?page=$prev'>Prev</a></li>";
                    }
                    if($_SESSION['role']==1){
                        #for pagination of whole records for admin
                        $sql="SELECT * FROM POST";
                    }else{
                        $sql="SELECT * FROM post WHERE AUTHOR = {$_SESSION['userid']}";
                        }
                    $totalrecords=mysqli_num_rows(mysqli_query($conn,$sql));
                    $totalpages=0;
                    if($totalrecords>0){
                        $totalpages=ceil($totalrecords/$limit);
                        for($i=1;$i<=$totalpages;$i++){ 
                            if($i==$page){   
                    
                  ?>
                      <li class="active"><a href="post.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php 
                            }
                            else{
                                ?>
                                <li><a href="post.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php
                            }
                    
                    }    
                }
                
                if($page<$totalpages){
                    $next=$page+1;
                    echo "<li><a href='post.php?page=$next'>Next</a></li>";
                }
                ?>
                 </ul>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
