<?php 
    include "header.php"; 
    include "config.php";
    if(!mysqli_num_rows(mysqli_query($conn,"SELECT * FROM user WHERE USERID='{$_SESSION['userid']}' AND role=1"))>0){
        header("Location: ".$site."Admin/post.php");
    }
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php
                        if(isset($_GET['page']))
                            $page=$_GET['page'];
                        else
                            $page=1; 
                        $limit=10;
                        $offset=($page-1)*$limit;
                        $sql="SELECT * FROM USER ORDER BY USERID DESC LIMIT {$offset},{$limit}";
                        $result=mysqli_query($conn,$sql) or die("Can't Process Request");
                        if(mysqli_num_rows($result)>0){
                            while($row=mysqli_fetch_assoc($result)){
                      ?>
                      
                          <tr>
                              <td class='id'><?php echo $row['USERID']; ?></td>
                              <td><?php echo $row['FIRSTNAME']." ".$row['LASTNAME']; ?></td>
                              <td><?php echo $row['username']; ?></td>
                              <td><?php if($row['role']==1){
                                            echo "Admin"; 
                                        }else{
                                            echo "Normal User";
                              }?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row['USERID']; ?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $row['USERID']; ?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                      
                      <?php }
                      }
                      else{
                        echo "No Records to Display!";
                      }
                ?>
                    </tbody>
                    </table>
                    <ul class='pagination admin-pagination'>

                <?php
                       
                      if($page>1){
                        $prev=$page-1;
                        echo "<li><a href='users.php?page=$prev'>Prev</a></li>";
                      }
                      $sql="SELECT * FROM USER";
                      $result=mysqli_query($conn,$sql) or die("Error in Connecting");
                      if(mysqli_num_rows($result)>0){
                            $total_records=mysqli_num_rows($result);
                            $total_pages=ceil($total_records/$limit);
                            for($i=1;$i<=$total_pages;$i++){
                                    if($i==$page){
                                ?> 
                            
                                <li class="active"><a href="users.php?page=<?php echo $i ; ?>"><?php echo $i; ?></a></li>
                            
                        <?php       
                                    }else{
                                ?>
                                <li><a href="users.php?page=<?php echo $i ; ?>"><?php echo $i; ?></a></li>
                                <?php
                                
                                    }
                                    

                            }
                            if($page<$total_pages){
                                $next=$page+1;
                                echo "<li><a href='users.php?page=$next'>Next</a></li>";
                            }
                        }
                            mysqli_close($conn);
                    ?>
                  
                    </ul>  
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
